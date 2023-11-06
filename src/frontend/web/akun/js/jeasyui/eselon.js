window.yii.app.eselon = (function ($) {
    var eselonDg;

    var eselonForm;
    var eselonDlg;
    var kodeInput;
    var pangkatInput;
    var tingkatSppdInput;
    var eselonFormDlg = function (row) {
        var title = 'Tambah Eselon';
        var url;
        if (row) {
            title = 'Edit Eselon';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/eselon/update',
                id: row.kode
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/eselon/create' }, true);
        }

        if (eselonDlg) {
            eselonDlg.dialog('setTitle', title);
            eselonDlg.dialog('open');
            eselonForm.form({ url: url });
            if (row) {
                eselonForm.form('load', row);
                kodeInput.textbox({ readonly: true });
            } else {
                eselonForm.form('reset');
                kodeInput.textbox({ readonly: false });
            }
        } else {
            eselonDlg = $('<div></div>').dialog({
                title: title,
                modal: true,
                height: 450,
                width: 355,
                buttons: [
                    {
                        iconCls: 'icon-disk',
                        text: 'Save',
                        handler: function () {
                            eselonForm.form('submit');
                        }
                    }
                ],
                content: '<div style="padding: 20px"><form id="eselon-form" method="post"></form></div>'
            });

            eselonForm = eselonDlg.find('#eselon-form');

            kodeInput = $('<input name="kode" />');
            eselonForm.append(kodeInput);
            kodeInput.textbox({
                label: 'Kode: ',
                labelPosition: 'top',
                width: 300,
                required: true,
                readonly: row ? true : false
            });

            pangkatInput = $('<input name="eselon" />');
            eselonForm.append(pangkatInput);
            pangkatInput.textbox({
                label: 'Eselon: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });
            
            tingkatSppdInput = $('<input name="tingkat_sppd" />');
            eselonForm.append(tingkatSppdInput);
            tingkatSppdInput.textbox({
                label: 'Tingkat Sppd: ',
                labelPosition: 'top',
                width: 300,
            });

            eselonForm.form({
                url: url,
                success: function (data) {
                    eselonDlg.dialog('close');
                    eselonDg.datagrid('reload');
                }
            });

            if (row) {
                eselonForm.form('load', row);
            }
        }
    };

    return {
        isActive: false,
        init: function () {
            var eselonEl = $('#eselon-index');
            eselonEl.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="eselon-east"></div>',
                width: '40%'
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="eselon-dg"></table>'
            });

            eselonDg = $('#eselon-dg');
            eselonDg.datagrid({
                url: yii.easyui.getHost('api'),
                queryParams: yii.easyui.ajaxAuthToken({ r: 'v1/jeasyui/eselon' }),
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
                sortName: 'id',
                remoteSort: true,
                columns: [
                    [
                        { field: 'ck', checkbox: true },
                        { field: 'kode', title: 'Kode', sortable: true },
                        { field: 'eselon', title: 'Eselon', sortable: true },
                        { field: 'tingkat_sppd', title: 'Tingkat SPPD', sortable: true },
                    ]
                ],
                toolbar: [{
                    text: 'Baru',
                    iconCls: 'icon-add',
                    handler: function () {
                        eselonFormDlg();
                    }
                }, {
                    text: 'Edit',
                    iconCls: 'icon-edit',
                    handler: function () {
                        eselonFormDlg(eselonDg.datagrid('getSelected'));
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
                            eselonDg.datagrid('reload');
                        }
                    });
                }
            }).datagrid('enableFilter', [
                yii.app.filter.customize(eselonDg, 'id', 'equal'),
                yii.app.filter.customize(eselonDg, 'nama', 'contains', true),
                yii.app.filter.customize(eselonDg, 'nama_2', 'contains', true),
            ]);

        }
    };
})(window.jQuery);