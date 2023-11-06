window.yii.app.jabatanDaerah = (function ($) {
    var el;
    var dg;

    var frm;
    var dlg;
    var namaInput;
    var nama2Input;
    var opdInput;
    var statusInput;
    var frmDlg = function (row) {
        var title = 'Tambah Jabatan Daerah';
        var url;
        if (row) {
            title = 'Edit Jabatan Daerah';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/jabatan-daerah/update',
                id: row.id
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/jabatan-daerah/create' }, true);
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
                content: '<div style="padding: 20px"><form id="jabatan-daerah-form" method="post"></form></div>'
            });

            frm = dlg.find('#jabatan-daerah-form');

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
                label: 'Singkatan: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            opdInput = $('<input name="opd_id" />');
            frm.append(opdInput);
            yii.app.refDropdown('opd', opdInput, () => { }, {
                required: true
            });

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
        dg = el.find('#jabatan-daerah-dg');
        dg.datagrid({
            url: yii.easyui.getHost('api'),
            queryParams: yii.easyui.ajaxAuthToken({ r: 'v1/jeasyui/jabatan-daerah' }),
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
                    { field: 'nama_2', title: 'Alias', sortable: true },
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
                pg.propertygrid('loadData', pgData(row));
            }
        }).datagrid('enableFilter', [
            yii.app.filter.customize(dg, 'id', 'equal'),
            yii.app.filter.customize(dg, 'nama', 'contains', true),
            yii.app.filter.customize(dg, 'nama_2', 'contains', true),
        ]);
    };

    var pgData = (row) => {
        row = row || {};
        return {
            rows: [
                {
                    name: 'OPD',
                    value: yii.app.getRef('opd', row.opd_id, function () {
                        pg.propertygrid('loadData', pgData(row));
                    }),
                    group: 'OPD',
                },
            ]
        };
    };

    var initPg = () => {
        pg = el.find('#jabatan-daerah-pg');
        pg.propertygrid({
            showGroup: true,
            scrollbarSize: 0,
            fit: true,
            fitColumns: true,
            border: false,
            nowrap: false,
            scrollbarSize: 0,
            data: pgData(),
            onEndEdit: (i, row, change) => {
                if (change.value) {
                    if (row.name === 'Status') {
                        row.value = yii.app.getRef('statusSppd', row.value);
                    } else if (row.fieldName) {
                        var data = {};
                        data[row.fieldName] = change.value;
                        if (row.fieldType === 'wilayah') {
                            row.value = yii.app.getRef('wilayah', row.value);
                        } else if (row.fieldName === 'anggaran_id') {
                            data[row.fieldName] = ~~change.value;
                            row.value = yii.app.ref.anggaran[row.value].kode_rekening;
                        }
                        ajaxUpdate(data);
                    }
                }
            },
            onLoadSuccess: () => {
                pg.propertygrid('collapseGroup');
                pg.propertygrid('expandGroup', 0);
            }
        });
    };

    return {
        isActive: false,
        init: function () {
            el = $('#jabatan-daerah-index');
            el.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<table id="jabatan-daerah-pg"></table>',
                width: '40%'
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="jabatan-daerah-dg"></table>'
            });

            initDg();
            initPg();

        }
    };
})(window.jQuery);