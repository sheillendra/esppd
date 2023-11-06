window.yii.app.suratTugasPribadi = (function ($) {

    var el;

    var dg;
    var pg;
    var dlg;

    var pgData = function (row) {
        row = row || { suratTugas: {} };
        return {
            rows: [
                {
                    name: 'Status',
                    value: yii.app.getRef('statusSuratTugas', row.suratTugas.status),
                    group: 'Surat Tugas',
                },
                {
                    name: 'Nomor',
                    value: row.suratTugas.nomor,
                    group: 'Surat Tugas',
                },
                {
                    name: 'Tanggal Terbit',
                    value: row.suratTugas.tanggal_terbit,
                    group: 'Surat Tugas',
                },
                {
                    name: 'Tanggal Mulai',
                    value: row.suratTugas.tanggal_mulai,
                    group: 'Surat Tugas',
                },
                {
                    name: 'Jumlah Hari',
                    value: row.suratTugas.jumlah_hari,
                    group: 'Surat Tugas',
                },
                {
                    name: 'Nama',
                    value: row.fix_nama,
                    group: 'Pelaksana',
                },
                {
                    name: 'NIP',
                    value: row.fix_nip,
                    group: 'Pelaksana',
                },
                {
                    name: 'Pejabat Struktural',
                    value: row.fix_jabatan,
                    group: 'Pelaksana',
                },
                {
                    name: 'Nama',
                    value: row.suratTugas.fix_nama,
                    group: 'Perintah Dari',
                },
                {
                    name: 'Pejabat Struktural',
                    value: row.suratTugas.fix_jabatan,
                    group: 'Perintah Dari',
                },
                {
                    name: 'Maksud',
                    value: row.suratTugas.maksud,
                    group: 'Tujuan',
                },
                {
                    name: 'Keterangan',
                    value: row.suratTugas.keterangan,
                    group: 'Tujuan',
                },
            ]
        };
    };

    var initStPg = () => {
        pg = el.find('#surat-tugas-pribadi-center-east');
        pg.propertygrid({
            showGroup: true,
            scrollbarSize: 0,
            fit: true,
            border: false,
            nowrap: false,
            data: pgData(),
        });
    };

    var initDlg = (row, typePdf) => {
        let title = row.suratTugas.nomor;
        let content = '<iframe src="' + row.suratTugas[typePdf] + '" style="width: 100%;height:100%;border:none;vertical-align:bottom" />';
        if (dlg) {
            dlg.dialog({content: content});
            dlg.dialog('open');
        } else {
            dlg = $('<div></div>').dialog({
                title: title,
                modal: true,
                height: '95%',
                width: '95%',
                content: content
            });
        }
    };

    var initStDg = () => {
        dg = el.find('#surat-tugas-pribadi-dg');
        dg.datagrid({
            url: yii.easyui.getHost('api'),
            queryParams: yii.easyui.ajaxAuthToken({
                r: 'v1/jeasyui/pelaksana-tugas',
                pribadi: 1,
                expand: 'suratTugas',
                //'pejabatDaerah, pejabatStruktural, pejabatStruktural.pegawai, pejabatDaerah.penduduk, pejabatStruktural.jabatanStruktural, pejabatDaerah.jabatanDaerah'
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
            toolbar: [
                {
                    text: 'PDF Belum Ttd',
                    iconCls: 'icon-pdf',
                    handler: function () {
                        let row = dg.datagrid('getSelected');
                        if (row.suratTugas && row.suratTugas.link_blank) {
                            initDlg(row, 'link_blank');
                        } else {
                            $.messager.alert('PDF', 'PDF belum tersedia', 'warning');
                        }
                    }
                }, {
                    text: 'PDF Barcode',
                    iconCls: 'icon-pdf',
                    handler: function () {
                        let row = dg.datagrid('getSelected');
                        if (row.suratTugas && row.suratTugas.link_barcode) {
                            initDlg(row, 'link_barcode');
                        } else {
                            $.messager.alert('PDF', 'PDF belum tersedia', 'warning');
                        }
                    }
                }, '-', {
                    text: 'PDF Ttd',
                    iconCls: 'icon-pdf',
                    handler: function () {
                        let row = dg.datagrid('getSelected');
                        if (row.suratTugas && row.suratTugas.link_ttd) {
                            initDlg(row, 'link_ttd');
                        } else {
                            $.messager.alert('PDF', 'PDF belum tersedia', 'warning');
                        }
                    }
                }
            ],
            columns: [
                [
                    { field: 'ck', checkbox: true },
                    {
                        field: 't1.tanggal_terbit', title: 'Tanggal Terbit',
                        sortable: true,
                        formatter: (value, row, index) => {
                            return row.suratTugas.tanggal_terbit;
                        }
                    },
                    {
                        field: 't1.nomor', title: 'Nomor', width: 170,
                        formatter: (value, row, index) => {
                            return row.suratTugas.nomor;
                        }
                    },
                    {
                        field: 't1.maksud', title: 'Maksud', width: 170,
                        formatter: (value, row, index) => {
                            return row.suratTugas.maksud;
                        }
                    },
                ]
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
            },
        }).datagrid('enableFilter', [
            yii.app.filter.customize(dg, 't1.tanggal_terbit', 'equal'),
            yii.app.filter.customize(dg, 't1.nomor', 'contains', true),
            yii.app.filter.customize(dg, 't1.maksud', 'contains', true),
        ]);
    };

    return {
        isActive: false,
        init: function () {
            el = $('#surat-tugas-pribadi-index');
            el.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Rincian',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="surat-tugas-pribadi-center-east"></div>',
                width: 400,
                hideCollapsedContent: !1,
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="surat-tugas-pribadi-dg"></table>'
            });

            initStDg();

            initStPg();

        }
    };
})(window.jQuery);