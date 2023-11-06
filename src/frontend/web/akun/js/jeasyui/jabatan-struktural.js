window.yii.app.jabatanStruktural = (function ($) {
    var el;
    var dg;

    var frm;
    var dlg;
    var namaInput;
    var nama2Input;
    var singkatanInput;
    var opdInput;
    var statusInput;
    var frmDlg = function (row) {
        var title = 'Tambah Jabatan Struktural';
        var url;
        if (row) {
            title = 'Edit Jabatan Struktural';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/jabatan-struktural/update',
                id: row.id
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/jabatan-struktural/create' }, true);
        }

        if (dlg) {
            dlg.dialog('setTitle', title);
            dlg.dialog('open');
            frm.form({ url: url });
            if (row) {
                frm.form('load', row);
            } else {
                frm.form('reset');
                statusInput.combobox('setValue', 1);
            }
        } else {
            dlg = $('<div></div>').dialog({
                title: title,
                modal: true,
                height: 450,
                width: 355,
                buttons: [
                    {
                        iconCls: 'icon-disk',
                        text: 'Save',
                        handler: function () {
                            frm.form('submit');
                        }
                    }
                ],
                content: '<div style="padding: 20px"><form id="jabatan-struktural-form" method="post"></form></div>'
            });

            frm = dlg.find('#jabatan-struktural-form');

            namaInput = $('<input name="nama" />');
            frm.append(namaInput);
            namaInput.textbox({
                label: 'Nama: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            nama2Input = $('<input name="nama_2" />');
            frm.append(nama2Input);
            nama2Input.textbox({
                label: 'Nama 2: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            singkatanInput = $('<input name="singkatan" />');
            frm.append(singkatanInput);
            singkatanInput.textbox({
                label: 'Singkatan: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            if (~~window.localStorage.adminOpd > 1) {
                opdInput = $('<input name="opd_id" type="hidden" value="' + window.localStorage.adminOpd + '" />');
                frm.append(opdInput);
            } else {
                opdInput = $('<input name="opd_id" style="border:none"/>');
                frm.append(opdInput);
                yii.app.refDropdown('opd', opdInput, () => { }, {
                    required: true
                });
            }

            statusInput = $('<input name="status" />');
            frm.append(statusInput);
            yii.app.refDropdown('status', statusInput, () => { }, {
                required: true
            });

            frm.form({
                url: url,
                success: function (data) {
                    dlg.dialog('close');
                    dg.datagrid('reload');
                }
            });

            if (row) {
                frm.form('load', row);
            } else {
                statusInput.combobox('setValue', 1);
            }
        }
    };

    var initDg = () => {
        dg = el.find('#jabatan-struktural-dg');
        dg.datagrid({
            url: yii.easyui.getHost('api'),
            queryParams: yii.easyui.ajaxAuthToken({ r: 'v1/jeasyui/jabatan-struktural' }),
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
                    //{ field: 'id', title: 'ID', sortable: true },
                    { field: 'nama', title: 'Nama', sortable: true, width: 200 },
                    { field: 'nama_2', title: 'Nama 2', sortable: true },
                    { field: 'singkatan', title: 'Singkatan', sortable: true },
                    {
                        field: 'opd_id', title: 'OPD', sortable: true,
                        formatter: (value, row, index) => {
                            return yii.app.getRef('opd', value, () => {
                                dg.datagrid('refreshRow', index);
                            });
                        }
                    },
                ]
            ],
            toolbar: [
                {
                    text: 'Baru',
                    iconCls: 'icon-add',
                    handler: function () {
                        frmDlg();
                    }
                }, {
                    text: 'Edit',
                    iconCls: 'icon-edit',
                    handler: function () {
                        frmDlg(dg.datagrid('getSelected'));
                    }
                }, '-', {
                    text: 'Hapus',
                    iconCls: 'icon-remove',
                    handler: function () {
                        let row = dg.datagrid('getSelected');
                        yii.app.ajax.delete({
                            id: row.id,
                            route: 'v1/jabatan-struktural/delete',
                            text: 'Jabatan Struktural',
                            callback: () => {
                                dg.datagrid('reload');
                            }
                        });
                    }
                }
            ],
            onLoadSuccess: function (data) {
                $(this).datagrid('selectRow', 0);
            },
            onLoadError: function (xhr) {
                yii.easyui.ajaxError(xhr, function (r) {
                    if (r) {
                        dg.datagrid('reload');
                    }
                });
            }
        }).datagrid('enableFilter', [
            yii.app.filter.customize(dg, 'id', 'equal'),
            yii.app.filter.customize(dg, 'opd_id', 'equal'),
            yii.app.filter.customize(dg, 'nama', 'contains', true),
            yii.app.filter.customize(dg, 'nama_2', 'contains', true),
            yii.app.filter.customize(dg, 'singkatan', 'contains', true),
        ]);
    };

    return {
        isActive: false,
        init: function () {
            el = $('#jabatan-struktural-index');
            el.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="jabatan-struktural-east"></div>',
                width: '40%'
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="jabatan-struktural-dg"></table>'
            });

            initDg();

        }
    };
})(window.jQuery);