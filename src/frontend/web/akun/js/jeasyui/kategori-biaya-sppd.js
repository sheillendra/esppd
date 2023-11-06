window.yii.app.kategoriBiayaSppd = (function ($) {
    var el;
    var dg;
    var jenisDg;

    var frm;
    var dlg;
    var namaInput;
    var statusInput;
    var keteranganInput;
    var frmDlg = function (row) {
        var title = 'Tambah Kategori';
        var url;
        if (row) {
            title = 'Edit Jabatan Struktural';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/kategori-biaya-sppd/update',
                id: row.id
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/kategori-biaya-sppd/create' }, true);
        }

        if (dlg) {
            dlg.dialog('setTitle', title);
            dlg.dialog('open');
            frm.form({ url: url });
            if (row) {
                frm.form('load', row);
            } else {
                frm.form('reset');
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
                content: '<div style="padding: 20px"><form id="kategori-biaya-sppd-form" method="post"></form></div>'
            });

            frm = dlg.find('#kategori-biaya-sppd-form');

            namaInput = $('<input name="nama" />');
            frm.append(namaInput);
            namaInput.textbox({
                label: 'Nama: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            statusInput = $('<input name="status" />');
            frm.append(statusInput);
            yii.app.refDropdown('status', statusInput);

            keteranganInput = $('<input name="keterangan"/>');
            frm.append(keteranganInput);
            keteranganInput.textbox({
                label: 'Keterangan: ',
                labelPosition: 'top',
                width: 300,
                multiline: true,
                height: 200
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
            }
        }
    };

    var initDg = () => {
        dg = el.find('#kategori-biaya-sppd-dg');
        dg.datagrid({
            url: yii.easyui.getHost('api'),
            queryParams: yii.easyui.ajaxAuthToken({ r: 'v1/jeasyui/kategori-biaya-sppd' }),
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
                    { field: 'nama', title: 'Nama', sortable: true },
                    {
                        field: 'status',
                        title: 'Status',
                        formatter: function (value, row, index) {
                            return yii.app.ref.status[value];
                        }
                    },
                    { field: 'keterangan', title: 'Keterangan', sortable: true },
                ]
            ],
            toolbar: [{
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
                        dg.datagrid('reload');
                    }
                });
            },
            onSelect: function (index, row) {
                //sppdSelectedRow = row;
                //sppdPg.propertygrid('loadData', pgData(row));
                jenisDg.datagrid('addFilterRule', { field: 'kategori_biaya_sppd_id', op: 'equal', value: row.id });
                jenisDg.datagrid({
                    url: yii.easyui.getHost('api'),
                    queryParams: yii.easyui.ajaxAuthToken({
                        r: 'v1/jeasyui/jenis-biaya-sppd',
                    }),
                });
            },
        }).datagrid('enableFilter', [
            yii.app.filter.customize(dg, 'nama', 'contains', true),
            yii.app.filter.customize(dg, 'keterangan', 'contains', true),
            yii.app.filter.customize(dg, 'status', 'equal'),
        ]);
    };

    var initJenisDg = () => {
        jenisDg = el.find('#jenis-biaya-sppd-dg');
        jenisDg.datagrid({
            url: yii.easyui.getHost('api'),
            queryParams: yii.easyui.ajaxAuthToken({ r: 'v1/jeasyui/jenis-biaya-sppd' }),
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
                    { field: 'nama', title: 'Nama', sortable: true },
                    {
                        field: 'status',
                        title: 'Status',
                        formatter: function (value, row, index) {
                            return yii.app.ref.status[value];
                        }
                    },
                    { field: 'keterangan', title: 'Keterangan', sortable: true },
                ]
            ],
            toolbar: [{
                text: 'Baru',
                iconCls: 'icon-add',
                handler: function () {
                    frmDlg();
                }
            }, {
                text: 'Edit',
                iconCls: 'icon-edit',
                handler: function () {
                    frmDlg(jenisDg.datagrid('getSelected'));
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
                        jenisDg.datagrid('reload');
                    }
                });
            },
        }).datagrid('enableFilter', [
            yii.app.filter.customize(jenisDg, 'nama', 'contains', true),
            yii.app.filter.customize(jenisDg, 'keterangan', 'contains', true),
            yii.app.filter.customize(jenisDg, 'status', 'equal'),
        ]);
    };

    return {
        isActive: false,
        init: function () {
            el = $('#kategori-biaya-sppd-index');
            el.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Jenis Biaya SPPD',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="jenis-biaya-sppd-dg"></div>',
                width: '40%'
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="kategori-biaya-sppd-dg"></table>'
            });

            initDg();

            initJenisDg();

        }
    };
})(window.jQuery);