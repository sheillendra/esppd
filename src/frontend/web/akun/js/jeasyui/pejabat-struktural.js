window.yii.app.pejabatStruktural = (function ($) {
    var el;
    var dg;

    var frm;
    var dlg;
    var jabatanInput;
    var pegawaiInput;
    var produkHukumInput;
    var frmDlg = function (row) {
        var title = 'Tambah Pejabat Struktural';
        var url;
        if (row) {
            title = 'Edit Pejabat Struktural';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/pejabat-struktural/update',
                id: row.id
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/pejabat-struktural/create' }, true);
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
                            yii.easyui.showMainMask();
                            frm.form('submit');
                        }
                    }
                ],
                content: '<div style="padding: 20px"><form id="pejabat-struktural-form" method="post"></form></div>'
            });

            frm = dlg.find('#pejabat-struktural-form');

            jabatanInput = $('<input name="jabatan_struktural_id" style="border: none"/>');
            frm.append(jabatanInput);
            yii.app.jabatanStrukturalDropdown(jabatanInput, {
                required: true,
                validType: 'inList[yii.app.pejabatStruktural.jabatanInput(), "id"]'
            });

            pegawaiInput = $('<input name="pegawai_id" />');
            frm.append(pegawaiInput);
            yii.app.pegawaiDropdown(pegawaiInput, {
                required: true,
                validType: 'inList[yii.app.pejabatStruktural.pegawaiInput(), "id"]'
            });

            produkHukumInput = $('<input name="produk_hukum_id" />');
            frm.append(produkHukumInput);
            yii.app.produkHukumDropdown(produkHukumInput, { 
                required: true, 
                validType: 'inList[yii.app.pejabatStruktural.produkHukumInput(), "id"]'
            });

            frm.form({
                url: url,
                iframe: false,
                onSubmit: function () {
                    var isValid = $(this).form('validate');
                    if (!isValid) {
                        yii.easyui.hideMainMask();	// hide progress bar while the form is invalid
                    }
                    return isValid;
                },
                success: function (data) {
                    yii.easyui.hideMainMask();
                    dlg.dialog('close');
                    dg.datagrid('reload');
                },
                error: function (res) {
                    yii.easyui.hideMainMask();
                    console.log(res);
                }
            });

            if (row) {
                frm.form('load', row);
            }
        }
    };

    var initDg = () => {
        dg = $('#pejabat-struktural-dg');
        dg.datagrid({
            url: yii.easyui.getHost('api'),
            queryParams: yii.easyui.ajaxAuthToken({
                r: 'v1/jeasyui/pejabat-struktural',
                expand: 'pegawai, jabatanStruktural, produkHukum'
            }),
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
                    {
                        field: 'pegawai_id', title: 'Nama', sortable: true,
                        formatter: function (value, row, index) {
                            return row.pegawai.nama_lengkap;
                        }
                    },
                    {
                        field: 'nip', title: 'NIP', sortable: true,
                        formatter: function (value, row, index) {
                            return row.pegawai.nip;
                        }
                    },
                    {
                        field: 'jabatan_struktural_id', title: 'Jabatan', sortable: true,
                        formatter: function (value, row, index) {
                            return row.jabatanStruktural.nama_2;
                        }
                    },
                    {
                        field: 'produk_hukum_id', title: 'Dasar Hukum', sortable: true,
                        formatter: function (value, row, index) {
                            return row.produkHukum.nama;
                        }
                    },
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
            }
        }).datagrid('enableFilter', [
            yii.app.filter.customize(dg, 'id', 'equal'),
            yii.app.filter.customize(dg, 'nama', 'contains', true),
            yii.app.filter.customize(dg, 'nama_2', 'contains', true),
        ]);
    };

    return {
        isActive: false,
        init: function () {
            el = $('#pejabat-struktural-index');
            el.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="pejabat-struktural-east"></div>',
                width: '40%'
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="pejabat-struktural-dg"></table>'
            });

            initDg();

        },
        /**
         * 
         * @returns element for validation purpose
         */
        jabatanInput: () => {
            return jabatanInput;
        },
        /**
         * 
         * @returns element for validation purpose
         */
        pegawaiInput: () => {
            return pegawaiInput;
        },
        /**
         * 
         * @returns element for validation purpose
         */
        produkHukumInput: () => {
            return produkHukumInput;
        },
    };
})(window.jQuery);