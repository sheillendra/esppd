window.yii.app.opd = (function ($) {
    var el;
    var dg;
    var pg;

    var frm;
    var dlg;
    var kodeInput;
    var namaInput;
    var singkatanInput;
    var kodeWilayahInput;
    var kopBaris1Input;
    var kopBaris2Input;
    var frmDlg = function (row) {
        var title = 'Tambah OPD';
        var url;
        if (row) {
            title = 'Edit OPD';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/opd/update',
                id: row.id
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/opd/create' }, true);
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
                height: 500,
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
                content: '<div style="padding: 20px"><form id="opd-form" method="post"></form></div>'
            });

            frm = dlg.find('#opd-form');

            kodeInput = $('<input name="kode" />');
            frm.append(kodeInput);
            kodeInput.textbox({
                label: 'Kode: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            namaInput = $('<input name="nama" />');
            frm.append(namaInput);
            namaInput.textbox({
                label: 'Nama: ',
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

            kodeWilayahInput = $('<input name="kode_wilayah" />');
            frm.append(kodeWilayahInput);
            kodeWilayahInput.textbox({
                label: 'Wilayah: ',
                labelPosition: 'top',
                width: 300,
                required: true
            });

            kopBaris1Input = $('<input name="baris_kop_1" />');
            frm.append(kopBaris1Input);
            kopBaris1Input.textbox({
                label: 'Baris 1 Kop: ',
                labelPosition: 'top',
                width: 300,
                height: 80,
                multiline: 1,
                required: true
            });

            kopBaris2Input = $('<input name="baris_kop_2" />');
            frm.append(kopBaris2Input);
            kopBaris2Input.textbox({
                label: 'Baris 2 Kop: ',
                labelPosition: 'top',
                width: 300,
                height: 80,
                multiline: 1,
                required: true
            });

            frm.form({
                url: url,
                success: function () {
                    dlg.dialog('close');
                    dg.datagrid('reload');
                }
            });

            if (row) {
                frm.form('load', row);
            }
        }
    };

    var initDg = function () {
        dg = $('#opd-dg');
        dg.datagrid({
            url: yii.easyui.getHost('api'),
            queryParams: yii.easyui.ajaxAuthToken({ r: 'v1/jeasyui/opd' }),
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
                    { field: 'kode', title: 'Kode', sortable: true },
                    { field: 'singkatan', title: 'Singkatan', sortable: true },
                    { field: 'nama', title: 'Nama', width: 200, sortable: true },
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
            yii.app.filter.customize(dg, 'kode', 'contains'),
            yii.app.filter.customize(dg, 'singkatan', 'contains', true),
            yii.app.filter.customize(dg, 'nama', 'contains', true),
        ]);
    };

    var pgData = (row) => {
        row = row || {};
        return {
            rows: [
                {
                    name: 'Kode',
                    value: row.kode,
                    group: 'Umum',
                },
                {
                    name: 'Singkatan',
                    value: row.singkatan,
                    group: 'Umum',
                },
                {
                    name: 'Nama',
                    value: row.nama,
                    group: 'Umum',
                },
                {
                    name: 'Kode Wilayah',
                    value: row.kode_wilayah,
                    group: 'Umum',
                },
                {
                    name: 'Kop Baris 1',
                    value: row.baris_kop_1,
                    group: 'Umum',
                },
                {
                    name: 'Kop Baris 2',
                    value: row.baris_kop_2,
                    group: 'Umum',
                },
            ]
        };
    };

    var initPg = () => {
        pg = el.find('#opd-pg');
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
            el = $('#opd-index');
            el.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="opd-pg"></div>',
                width: '40%'
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="opd-dg"></table>'
            });

            initDg();
            initPg();
        }
    };
})(window.jQuery);