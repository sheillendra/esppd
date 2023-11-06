window.yii.app.pangkatGolongan = (function ($) {
    var pangkatGolonganDg;

    var pangkatGolonganForm;
    var pangkatGolonganDlg;
    var kodeInput;
    var pangkatInput;
    var golInput;
    var ruangInput;
    var tingkatSppdInput;
    var pangkatGolonganFormDlg = function (row) {
        var title = 'Tambah Pangkat Golongan';
        var url;
        if (row) {
            title = 'Edit Pangkat Golongan';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/pangkat-golongan/update',
                id: row.kode
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/pangkat-golongan/create' }, true);
        }

        if (pangkatGolonganDlg) {
            pangkatGolonganDlg.dialog('setTitle', title);
            pangkatGolonganDlg.dialog('open');
            pangkatGolonganForm.form({ url: url });
            if (row) {
                pangkatGolonganForm.form('load', row);
                kodeInput.textbox({ readonly: true });
            } else {
                pangkatGolonganForm.form('reset');
                kodeInput.textbox({ readonly: false });
            }
        } else {
            pangkatGolonganDlg = $('<div></div>').dialog({
                title: title,
                modal: true,
                height: 450,
                width: 355,
                buttons: [
                    {
                        iconCls: 'icon-disk',
                        text: 'Save',
                        handler: function () {
                            pangkatGolonganForm.form('submit');
                        }
                    }
                ],
                content: '<div style="padding: 20px"><form id="pangkat-golongan-form" method="post"></form></div>'
            });

            pangkatGolonganForm = pangkatGolonganDlg.find('#pangkat-golongan-form');

            kodeInput = $('<input name="kode" />');
            pangkatGolonganForm.append(kodeInput);
            kodeInput.textbox({
                label: 'Kode: ',
                labelPosition: 'top',
                width: 300,
                required: true,
                readonly: row ? true : false
            });

            pangkatInput = $('<input name="pangkat" />');
            pangkatGolonganForm.append(pangkatInput);
            pangkatInput.textbox({
                label: 'Nama: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            golInput = $('<input name="golongan" />');
            pangkatGolonganForm.append(golInput);
            golInput.textbox({
                label: 'Golongan: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            ruangInput = $('<input name="ruang" />');
            pangkatGolonganForm.append(ruangInput);
            ruangInput.textbox({
                label: 'Golongan: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            tingkatSppdInput = $('<input name="tingkat_sppd" />');
            pangkatGolonganForm.append(tingkatSppdInput);
            tingkatSppdInput.textbox({
                label: 'Tingkat Sppd: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            pangkatGolonganForm.form({
                url: url,
                success: function (data) {
                    pangkatGolonganDlg.dialog('close');
                    pangkatGolonganDg.datagrid('reload');
                }
            });

            if (row) {
                pangkatGolonganForm.form('load', row);
            }
        }
    };

    return {
        isActive: false,
        init: function () {
            var pangkatGolonganEl = $('#pangkat-golongan-index');
            pangkatGolonganEl.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="pangkat-golongan-east"></div>',
                width: '40%'
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="pangkat-golongan-dg"></table>'
            });

            pangkatGolonganDg = $('#pangkat-golongan-dg');
            pangkatGolonganDg.datagrid({
                url: yii.easyui.getHost('api'),
                queryParams: yii.easyui.ajaxAuthToken({ r: 'v1/jeasyui/pangkat-golongan' }),
                method: 'get',
                fit: true,
                border: false,
                striped: true,
                checkOnSelect: false,
                singleSelect: true,
                emptyMsg: 'No Records Found.',
                rownumbers: true,
                pagination: true,
                pageSize: 50,
                remoteFilter: true,
                sortName: 'kode',
                remoteSort: true,
                columns: [
                    [
                        { field: 'ck', checkbox: true },
                        { field: 'kode', title: 'Kode', sortable: true },
                        { field: 'pangkat', title: 'Pangkat', sortable: true },
                        { field: 'golongan', title: 'Golongan', sortable: true },
                        { field: 'ruang', title: 'Ruang', sortable: true },
                    ]
                ],
                toolbar: [{
                    text: 'Baru',
                    iconCls: 'icon-add',
                    handler: function () {
                        pangkatGolonganFormDlg();
                    }
                }, {
                    text: 'Edit',
                    iconCls: 'icon-edit',
                    handler: function () {
                        pangkatGolonganFormDlg(pangkatGolonganDg.datagrid('getSelected'));
                    }
                }, '-', {
                    text: 'Hapus',
                    iconCls: 'icon-remove',
                    handler: function () {
                        alert('delete');
                    }
                }
                ],
                onLoadSuccess: function (data) {
                    $(this).datagrid('selectRow', 0);
                },
                onLoadError: function (xhr) {
                    yii.easyui.ajaxError(xhr, function (r) {
                        if (r) {
                            pangkatGolonganDg.datagrid('reload');
                        }
                    });
                }
            }).datagrid('enableFilter', [
                yii.app.filter.customize(pangkatGolonganDg, 'id', 'equal'),
                yii.app.filter.customize(pangkatGolonganDg, 'nama', 'contains', true),
                yii.app.filter.customize(pangkatGolonganDg, 'nama_2', 'contains', true),
            ]);

        }
    };
})(window.jQuery);