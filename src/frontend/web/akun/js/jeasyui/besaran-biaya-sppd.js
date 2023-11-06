window.yii.app.besaranBiayaSppd = (function ($) {
    var dg;

    return {
        isActive: false,
        init: function () {
            var El = $('#besaran-biaya-sppd-index');
            El.layout({
                fit: true,
                border: false
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="besaran-biaya-sppd-dg"></table>'
            });

            dg = $('#besaran-biaya-sppd-dg');
            dg.datagrid({
                url: yii.easyui.getHost('api'),
                queryParams: yii.easyui.ajaxAuthToken({
                    r: 'v1/jeasyui/besaran-biaya-sppd',
                    expand: 'jenisBiayaSppd'
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
                        //{ field: 'id', title: 'ID', sortable: true },
                        {
                            field: 'jenis_biaya_sppd_id', title: 'Jenis Biaya', sortable: true,
                            formatter: function (value, row, index) {
                                return yii.app.getRef('jenisBiayaSppd', value, () => {
                                    dg.datagrid('refreshRow', index);
                                });
                            }
                        },
                        {
                            field: 'jumlah', title: 'Pangkat Gol.',
                            sortable: true,
                            align: 'right',
                            formatter: function (value, row, index) {
                                return yii.easyui.currencyFormatter(value);
                            }
                        },
                        { field: 'pangkat_golongan_id', title: 'Pangkat Gol.', sortable: true },
                        { field: 'eselon_id', title: 'Eselon', sortable: true },
                        { field: 'jabatan_struktural_id', title: 'Jabatan Struktural', sortable: true },
                        {
                            field: 'jabatan_daerah_id', title: 'Jabatan Daerah', sortable: true,
                            formatter: function (value, row, index) {
                                return yii.app.getRef('jabatanDaerah', value, () => {
                                    dg.datagrid('refreshRow', index);
                                });
                            }
                        },
                        {
                            field: 'wilayah_id',
                            title: 'Wilayah',
                            sortable: true,
                            width: 200,
                            formatter: function (value, row, index) {
                                return yii.app.getRef('wilayah', value, () => {
                                    dg.datagrid('refreshRow', index);
                                });
                            }
                        },
                        {
                            field: 'kategori_wilayah',
                            title: 'Kategori Wilayah',
                            sortable: true,
                            width: 200,
                            formatter: function (value, row, index) {
                                return yii.app.getRef('kategoriWilayah', value, () => {
                                    dg.datagrid('refreshRow', index);
                                });
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

        }
    };
})(window.jQuery);