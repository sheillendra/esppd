window.yii.app.jabatanKeuangan = (function ($) {
    var jabatanKeuanganDg;

    var jabatanKeuanganForm;
    var jabatanKeuanganDlg;
    var namaInput;
    var nama2Input;
    var jabatanKeuanganFormDlg = function (row) {
        var title = 'Tambah Jabatan Keuangan';
        var url;
        if (row) {
            title = 'Edit Jabatan Keuangan';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/jabatan-keuangan/update',
                id: row.id
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/jabatan-keuangan/create' }, true);
        }

        if (jabatanKeuanganDlg) {
            jabatanKeuanganDlg.dialog('setTitle', title);
            jabatanKeuanganDlg.dialog('open');
            jabatanKeuanganForm.form({ url: url });
            if (row) {
                jabatanKeuanganForm.form('load', row);
            } else {
                jabatanKeuanganForm.form('reset');
            }
        } else {
            jabatanKeuanganDlg = $('<div></div>').dialog({
                title: title,
                modal: true,
                height: 450,
                width: 355,
                buttons: [
                    {
                        iconCls: 'icon-disk',
                        text: 'Save',
                        handler: function () {
                            jabatanKeuanganForm.form('submit');
                        }
                    }
                ],
                content: '<div style="padding: 20px"><form id="jabatan-keuangan-form" method="post"></form></div>'
            });

            jabatanKeuanganForm = jabatanKeuanganDlg.find('#jabatan-keuangan-form');

            namaInput = $('<input name="nama" />');
            jabatanKeuanganForm.append(namaInput);
            namaInput.textbox({
                label: 'Nama: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            nama2Input = $('<input name="nama_2" />');
            jabatanKeuanganForm.append(nama2Input);
            nama2Input.textbox({
                label: 'Nama: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            jabatanKeuanganForm.form({
                url: url,
                success: function (data) {
                    jabatanKeuanganDlg.dialog('close');
                    jabatanKeuanganDg.datagrid('reload');
                }
            });

            if (row) {
                jabatanKeuanganForm.form('load', row);
            }
        }
    };

    return {
        isActive: false,
        init: function () {
            var jabatanKeuanganEl = $('#jabatan-keuangan-index');
            jabatanKeuanganEl.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="jabatan-keuangan-east"></div>',
                width: '40%'
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="jabatan-keuangan-dg"></table>'
            });

            jabatanKeuanganDg = $('#jabatan-keuangan-dg');
            jabatanKeuanganDg.datagrid({
                url: yii.easyui.getHost('api'),
                queryParams: yii.easyui.ajaxAuthToken({ r: 'v1/jeasyui/jabatan-keuangan' }),
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
                        { field: 'id', title: 'ID', sortable: true },
                        { field: 'nama', title: 'Nama', sortable: true },
                        { field: 'singkatan', title: 'Singkatan', sortable: true },
                        { field: 'status', title: 'Status', sortable: true },
                    ]
                ],
                toolbar: [{
                    text: 'Baru',
                    iconCls: 'icon-add',
                    handler: function () {
                        jabatanKeuanganFormDlg();
                    }
                }, {
                    text: 'Edit',
                    iconCls: 'icon-edit',
                    handler: function () {
                        jabatanKeuanganFormDlg(jabatanKeuanganDg.datagrid('getSelected'));
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
                            jabatanKeuanganDg.datagrid('reload');
                        }
                    });
                }
            }).datagrid('enableFilter', [
                yii.app.filter.customize(jabatanKeuanganDg, 'id', 'equal'),
                yii.app.filter.customize(jabatanKeuanganDg, 'nama', 'contains', true),
                yii.app.filter.customize(jabatanKeuanganDg, 'nama_2', 'contains', true),
            ]);

        }
    };
})(window.jQuery);