window.yii.app.pejabatDaerah = (($) => {
    var el;
    var dg;

    var frm;
    var dlg;
    var jabatanInput;
    var pendudukInput;
    var produkHukumInput;
    var frmDlg = (row) => {
        var title = 'Tambah Pejabat Daerah';
        var url;
        if (row) {
            title = 'Edit Pejabat Daerah';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/pejabat-daerah/update',
                id: row.id
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/pejabat-daerah/create' }, true);
        }

        if (dlg) {
            dlg.dialog('setTitle', title);
            dlg.dialog('open');
            frm.form({ url: url });
            if (row) {
                frm.form('load', row);
                jabatanInput.combobox('setValue', row.jabatan_daerah_id);
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
                        handler: () => {
                            frm.form('submit');
                        }
                    }
                ],
                content: '<div style="padding: 20px"><form id="pejabat-daerah-form" method="post"></form></div>'
            });

            frm = dlg.find('#pejabat-daerah-form');

            jabatanInput = $('<input name="jabatan_daerah_id" style="border: none" />');
            frm.append(jabatanInput);
            yii.app.refDropdown('jabatanDaerah', jabatanInput, () => {
                if (row) {
                    jabatanInput.combobox('setValue', row.jabatan_daerah_id);
                }
            }, {
                label: 'Jabatan Daerah',
                required: true,
                validType: 'inList[yii.app.pejabatDaerah.jabatanInput(), "id"]'
            });

            pendudukInput = $('<input name="penduduk_id" />');
            frm.append(pendudukInput);
            yii.app.pendudukDropdown(pendudukInput, {
                required: true,
                validType: 'inList[yii.app.pejabatDaerah.pendudukInput(), "id"]'
            });

            produkHukumInput = $('<input name="produk_hukum_id" />');
            frm.append(produkHukumInput);
            yii.app.produkHukumDropdown(produkHukumInput, {
                required: true,
                validType: 'inList[yii.app.pejabatDaerah.produkHukumInput(), "id"]'
            });

            frm.form({
                url: url,
                success: (data) => {
                    dlg.dialog('close');
                    dg.datagrid('reload');
                },
                error: (res) => {
                    console.log(res);
                }
            });

            if (row) {
                frm.form('load', row);
            }
        }
    };

    var initDg = () => {
        dg = el.find('#pejabat-daerah-dg');
        dg.datagrid({
            url: yii.easyui.getHost('api'),
            queryParams: yii.easyui.ajaxAuthToken({
                r: 'v1/jeasyui/pejabat-daerah',
                expand: 'penduduk, jabatanDaerah, produkHukum'
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
                        field: 'jabatan_daerah_id', title: 'Jabatan', sortable: true,
                        formatter: (value, row, index) => {
                            return row.jabatanDaerah.nama;
                        }
                    },
                    {
                        field: 'penduduk_id', title: 'Penduduk', sortable: true,
                        formatter: (value, row, index) => {
                            return row.penduduk.nama_lengkap;
                        }
                    },
                    {
                        field: 'produk_hukum_id', title: 'Dasar Hukum', sortable: true,
                        formatter: (value, row, index) => {
                            return row.produkHukum.nama;
                        }
                    },
                ]
            ],
            toolbar: [
                {
                    text: 'Baru',
                    iconCls: 'icon-add',
                    handler: () => {
                        frmDlg();
                    }
                }, {
                    text: 'Edit',
                    iconCls: 'icon-edit',
                    handler: () => {
                        frmDlg(dg.datagrid('getSelected'));
                    }
                }, '-', {
                    text: 'Hapus',
                    iconCls: 'icon-remove',
                    handler: () => {
                        alert('delete');
                    }
                }
            ],
            onLoadSuccess: (data) => {
                $(this).datagrid('selectRow', 0);
            },
            onLoadError: (xhr) => {
                yii.easyui.ajaxError(xhr, (r) => {
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
        init: () => {
            el = $('#pejabat-daerah-index');
            el.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="pejabat-daerah-east"></div>',
                width: '40%'
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="pejabat-daerah-dg"></table>'
            });

            initDg();

        },
        jabatanInput: () => {
            return jabatanInput;
        },
        pendudukInput: () => {
            return pendudukInput;
        },
        produkHukumInput: () => {
            return produkHukumInput;
        },
    };
})(window.jQuery);