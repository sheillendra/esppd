window.yii.app.suratTugas = (function ($) {

    var el;
    var centerEl;

    var dg;
    var pg;
    var pltDg;

    var suratTugasForm;
    var suratTugasPltForm;
    var suratTugasDlg;
    var suratTugasPltDlg;
    var nomorStInput;
    var tanggalTerbitInput;
    var tanggalMulaiInput;
    var jumlahHariInput;
    var pejabatDaerahInput;
    var pejabatStrukturalInput;
    var maksudInput;
    var keteranganInput;
    var suratTugasFormDlg = function (row) {
        var title = 'Surat Tugas Baru';
        var url;
        if (row) {
            title = 'Edit SuratTugas';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/surat-tugas/update',
                id: row.id
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/surat-tugas/create' }, true);
        }

        if (suratTugasDlg) {
            suratTugasDlg.dialog('setTitle', title);
            suratTugasDlg.dialog('open');
            suratTugasForm.form({ url: url });
            if (row) {
                suratTugasForm.form('load', row);
            } else {
                suratTugasForm.form('reset');
            }
            pejabatDaerahInput.combobox('enable');
            pejabatStrukturalInput.combobox('enable');
        } else {
            suratTugasDlg = $('<div></div>').dialog({
                title: title,
                modal: true,
                height: 450,
                width: 355,
                buttons: [
                    {
                        iconCls: 'icon-disk',
                        text: 'Save',
                        handler: () => {
                            suratTugasForm.form('submit');
                        }
                    }
                ],
                content: '<div style="padding: 20px"><form id="surat-tugas-form" method="post"></form></div>'
            });

            suratTugasForm = suratTugasDlg.find('#surat-tugas-form');

            nomorStInput = $('<input name="nomor"/>');
            suratTugasForm.append(nomorStInput);
            nomorStInput.textbox({
                label: 'Nomor: ',
                labelPosition: 'top',
                width: 300,
                required: true,
                autocomplete: true
            });

            tanggalTerbitInput = $('<input name="tanggal_terbit"/>');
            suratTugasForm.append(tanggalTerbitInput);
            tanggalTerbitInput.datebox({
                label: 'Tanggal terbit: ',
                labelPosition: 'top',
                width: 300,
                required: true,
            });

            tanggalMulaiInput = $('<input name="tanggal_mulai"/>');
            suratTugasForm.append(tanggalMulaiInput);
            tanggalMulaiInput.datebox({
                label: 'Tanggal Mulai: ',
                labelPosition: 'top',
                width: 300,
                required: true,
            });

            jumlahHariInput = $('<input name="jumlah_hari"/>');
            suratTugasForm.append(jumlahHariInput);
            jumlahHariInput.numberbox({
                label: 'Jumlah Hari: ',
                labelPosition: 'top',
                width: 300,
                required: true,
            });

            pejabatDaerahInput = $('<input name="pejabat_daerah_id"/>');
            suratTugasForm.append(pejabatDaerahInput);
            yii.app.pejabatDaerahDropdown(pejabatDaerahInput, {
                required: true,
                prompt: 'Pejabat Daerah',
                label: 'Perintah Dari',
                onSelect: function (row) {
                    pejabatStrukturalInput.combobox('clear');
                    pejabatStrukturalInput.combobox('disable');
                },
                icons: [
                    {
                        iconCls: 'icon-clear',
                        handler: function (e) {
                            $(e.data.target).combobox('clear');
                            pejabatStrukturalInput.combobox('enable');
                        }
                    }
                ],
            });

            pejabatStrukturalInput = $('<input name="pejabat_struktural_id"/>');
            suratTugasForm.append(pejabatStrukturalInput);
            yii.app.pejabatStrukturalDropdown(pejabatStrukturalInput, {
                required: true,
                prompt: 'Pejabat Struktural',
                label: 'atau dari',
                onSelect: function (row) {
                    pejabatDaerahInput.combobox('clear');
                    pejabatDaerahInput.combobox('disable');
                },
                icons: [
                    {
                        iconCls: 'icon-clear',
                        handler: function (e) {
                            $(e.data.target).combobox('clear');
                            pejabatDaerahInput.combobox('enable');
                        }
                    }
                ],
            });

            maksudInput = $('<input name="maksud"/>');
            suratTugasForm.append(maksudInput);
            maksudInput.textbox({
                label: 'Maksud: ',
                labelPosition: 'top',
                width: 300,
                required: true,
                multiline: true,
                height: 200
            });

            keteranganInput = $('<input name="keterangan"/>');
            suratTugasForm.append(keteranganInput);
            keteranganInput.textbox({
                label: 'Keterangan: ',
                labelPosition: 'top',
                width: 300,
                multiline: true,
                height: 200
            });

            suratTugasForm.form({
                url: url,
                success: function (data) {
                    suratTugasDlg.dialog('close');
                    dg.datagrid('reload');
                }
            });

            if (row) {
                suratTugasForm.form('load', row);
            }
        }
    };

    var pegawaiPltInput;
    var pendudukPltInput;
    var stIdPltInput;

    var suratTugasPltFormDlg = function (row) {
        var title = 'Pelaksana Surat Tugas Baru';
        var url;
        var parentRow = dg.datagrid('getSelected');
        if (row) {
            title = 'Edit Pelaksana SuratTugas';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/pelaksana-tugas/update',
                id: row.id
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/pelaksana-tugas/create' }, true);
        }

        if (suratTugasPltDlg) {
            suratTugasPltDlg.dialog('setTitle', title);
            suratTugasPltDlg.dialog('open');
            suratTugasPltForm.form({ url: url });
            if (row) {
                suratTugasPltForm.form('load', row);
            } else {
                suratTugasPltForm.form('reset');
                stIdPltInput.val(parentRow.id);
            }
            pegawaiPltInput.combobox('enable');
            pendudukPltInput.combobox('enable');
        } else {
            suratTugasPltDlg = $('<div></div>').dialog({
                title: title,
                modal: true,
                height: 450,
                width: 355,
                buttons: [
                    {
                        iconCls: 'icon-disk',
                        text: 'Save',
                        handler: () => {
                            suratTugasPltForm.form('submit');
                        }
                    }
                ],
                content: '<div style="padding: 20px"><form id="surat-tugas-plt-form" method="post"></form></div>'
            });

            suratTugasPltForm = suratTugasPltDlg.find('#surat-tugas-plt-form');

            stIdPltInput = $('<input name="surat_tugas_id" type="hidden"/>');
            suratTugasPltForm.append(stIdPltInput);
            stIdPltInput.val(parentRow.id);

            pegawaiPltInput = $('<input name="pegawai_id"/>');
            suratTugasPltForm.append(pegawaiPltInput);
            yii.app.pegawaiDropdown(pegawaiPltInput, {
                required: true,
                prompt: 'Pilih pegawai',
                label: 'Pegawai',
                onSelect: function (row) {
                    pendudukPltInput.combobox('clear');
                    pendudukPltInput.combobox('disable');
                },
                icons: [
                    {
                        iconCls: 'icon-clear',
                        handler: function (e) {
                            $(e.data.target).combobox('clear');
                            pendudukPltInput.combobox('enable');
                        }
                    }
                ],
                validType: 'inList[yii.app.suratTugas.pegawaiPltInput(), "id"]'
            });

            pendudukPltInput = $('<input name="penduduk_id"/>');
            suratTugasPltForm.append(pendudukPltInput);
            yii.app.pendudukDropdown(pendudukPltInput, {
                required: true,
                prompt: 'Pilih penduduk',
                label: 'atau',
                onSelect: function (row) {
                    pegawaiPltInput.combobox('clear');
                    pegawaiPltInput.combobox('disable');
                },
                icons: [
                    {
                        iconCls: 'icon-clear',
                        handler: function (e) {
                            $(e.data.target).combobox('clear');
                            pegawaiPltInput.combobox('enable');
                        }
                    }
                ],
                validType: 'inList[yii.app.suratTugas.pendudukPltInput(), "id"]'
            });

            suratTugasPltForm.form({
                url: url,
                success: function (data) {
                    suratTugasPltDlg.dialog('close');
                    pltDg.datagrid('reload');
                }
            });

            if (row) {
                suratTugasPltForm.form('load', row);
            }
        }
    };

    var ajaxChangeStatus = (status, row) => {
        yii.easyui.showMainMask();
        $.ajax({
            url: yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/surat-tugas/change-status',
                id: row.id,
                status: ~~status.id
            }, true),
            type: 'POST',
            dataType: 'json',
            success: (res) => {
                yii.easyui.hideMainMask();
                $.messager.alert('Update Status', res.message, res.success ? 'info' : 'error', () => {
                    if (res.success) {
                        row.status = status.id;
                        //if (status.id == 1) {
                        //    pg.propertygrid('loadData', pgData(row));
                        //}
                    }
                    // else {
                        pg.propertygrid('loadData', pgData(row));
                    //}

                });
            },
            error: (xhr) => {
                yii.easyui.hideMainMask();
                return yii.easyui.ajaxError(xhr, (r) => {
                    if (r) {
                        ajaxChangeStatus(status, row);
                    } else {
                        pg.propertygrid('loadData', pgData(row));
                    }
                });
            }
        });
    };

    var pgData = function (row) {
        row = row || {};
        return {
            rows: [
                {
                    name: 'Status',
                    value: yii.app.getRef('statusSuratTugas', row.status),
                    group: 'Surat Tugas',
                    editor: yii.app.editor.ref('statusSuratTugas', {
                        editable: false,
                        onSelect: (status) => {
                            if (row.status !== ~~status.id) {
                                $.messager.confirm('Status SPPD', 'Apakah anda yakin akan mengubah Status Surat Tugas menjadi ' + status.text + '?', (r) => {
                                    if (r) {
                                        ajaxChangeStatus(status, row);
                                    } else {
                                        pg.propertygrid('loadData', pgData(row));
                                    }
                                });
                            }
                        }
                    }),
                },
                {
                    name: 'Nomor',
                    value: row.nomor,
                    group: 'Surat Tugas',
                },
                {
                    name: 'Tanggal Terbit',
                    value: row.tanggal_terbit,
                    group: 'Surat Tugas',
                },
                {
                    name: 'Tanggal Mulai',
                    value: row.tanggal_mulai,
                    group: 'Surat Tugas',
                },
                {
                    name: 'Jumlah Hari',
                    value: row.jumlah_hari,
                    group: 'Surat Tugas',
                },
                {
                    name: 'Pejabat Daerah',
                    value: row.pejabatDaerah ?
                        (
                            row.pejabatDaerah.penduduk.nama_tanpa_gelar + ' - ' + row.pejabatDaerah.jabatanDaerah.nama
                        )
                        : '',
                    group: 'Perintah Dari',
                },
                {
                    name: 'Pejabat Struktural',
                    value: row.pejabatStruktural ?
                        (
                            row.pejabatStruktural.pegawai.nama_tanpa_gelar + ' - ' + row.pejabatStruktural.jabatanStruktural.nama
                        ) : '',
                    group: 'Perintah Dari',
                    formatter: function (row) {

                    },
                },
                {
                    name: 'Maksud',
                    value: row.maksud,
                    group: 'Tujuan',
                },
                {
                    name: 'Keterangan',
                    value: row.keterangan,
                    group: 'Tujuan',
                },
            ]
        };
    };

    var ajaxStSiapSah = function (row) {
        yii.easyui.showMainMask();
        $.ajax({
            url: yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/surat-tugas/siap-sahkan',
                id: row.id
            }, true),
            type: 'POST',
            dataType: 'json',
            success: function (res) {
                yii.easyui.hideMainMask();
                $.messager.alert('Sahkan Surat Tugas', 'Surat tugas siap disahkan', 'info', () => {
                    dg.datagrid('reload');
                });
            },
            error: function (xhr) {
                yii.easyui.hideMainMask();
                return yii.easyui.ajaxError(xhr, function (r) {
                    if (r) {
                        ajaxStSiapSah(row);
                    }
                });
            }
        });
    };

    var initStPg = () => {
        pg = centerEl.find('#surat-tugas-center-east');
        pg.propertygrid({
            showGroup: true,
            scrollbarSize: 0,
            fit: true,
            border: false,
            nowrap: false,
            data: pgData(),
            onEndEdit: (i, row, change) => {
                if (change.value) {
                    if (row.name === 'Status') {
                        row.value = yii.app.getRef('statusSppd', row.value);
                    } else if (row.fieldName) {
                        var data = {};
                        data[row.fieldName] = change.value;
                        ajaxUpdate(data);
                    }
                }
            },
        });
    };

    var initStDg = () => {
        dg = centerEl.find('#surat-tugas-dg');
        dg.datagrid({
            url: yii.easyui.getHost('api'),
            queryParams: yii.easyui.ajaxAuthToken({
                r: 'v1/jeasyui/surat-tugas',
                expand: 'pejabatDaerah, pejabatStruktural, pejabatStruktural.pegawai, pejabatDaerah.penduduk, pejabatStruktural.jabatanStruktural, pejabatDaerah.jabatanDaerah'
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
            columns: [
                [
                    { field: 'ck', checkbox: true },
                    { field: 'tanggal_terbit', title: 'Tanggal Terbit', sortable: true },
                    { field: 'nomor', title: 'Nomor', width: 170 },
                    { field: 'maksud', title: 'Maksud', width: 170 },
                ]
            ],
            toolbar: '#surat-tugas-tb',
            onLoadSuccess: function (data) {
                dg.datagrid('selectRow', 0);
            },
            onLoadError: function (xhr) {
                yii.easyui.ajaxError(xhr, function (r) {
                    if (r) {
                        dg.datagrid('reload');
                    }
                });
            },
            onSelect: (index, row) => {
                pg.propertygrid('loadData', pgData(row));
                pltDg.datagrid('addFilterRule', { field: 'surat_tugas_id', op: 'equal', value: row.id });
                pltDg.datagrid({
                    url: yii.easyui.getHost('api'),
                    queryParams: yii.easyui.ajaxAuthToken({
                        r: 'v1/jeasyui/pelaksana-tugas',
                        expand: 'pegawai, penduduk'
                    }),
                });
            },
        }).datagrid('enableFilter', [
            yii.app.filter.customize(dg, 'tanggal_terbit', 'equal'),
            yii.app.filter.customize(dg, 'nomor', 'contains', true),
            yii.app.filter.customize(dg, 'maksud', 'contains', true),
        ]);

        $('#surat-tugas-tb-baru').linkbutton({
            text: 'Baru',
            iconCls: 'icon-add',
            plain: true,
            onClick: () => {
                suratTugasFormDlg();
            }
        });

        $('#surat-tugas-tb-edit').linkbutton({
            text: 'Edit',
            iconCls: 'icon-edit',
            plain: true,
            onClick: () => {
                let row = dg.datagrid('getSelected');
                if (row.status > yii.app.suratTugas.STATUS_SEDANG_PROSES) {
                    return $.messager.alert('Surat Tugas', 'Status surat tugas haru SEDANG PROSES', 'error');
                }
                suratTugasFormDlg(row);
            }
        });

        $('#surat-tugas-tb-hapus').linkbutton({
            text: 'Hapus',
            iconCls: 'icon-remove',
            plain: true,
            onClick: () => {
                let row = dg.datagrid('getSelected');
                yii.app.ajax.delete({
                    id: row.id,
                    route: 'v1/surat-tugas/delete',
                    text: 'Surat Tugas',
                    callback: () => {
                        dg.datagrid('reload');
                    }
                });
            }
        });

        var suratTugasMmPdf = $('#surat-tugas-tb-pdf-mm');
        suratTugasMmPdf.menu({ minWidth: 250 });
        suratTugasMmPdf.menu('appendItem', {
            iconCls: 'icon-pdf',
            text: 'Surat Tugas Belum TTD',
            onclick: () => {
                let row = dg.datagrid('getSelected');
                if (row.status < yii.app.suratTugas.STATUS_PENGESAHAN) {
                    return $.messager.alert('PDF Surat Tugas', 'Status Surat Tugas harus PENGESAHAN', 'error');
                }
                yii.app.dialog.pdf('surat-tugas', row, 'link_blank');
            },
        });

        suratTugasMmPdf.menu('appendItem', {
            iconCls: 'icon-pdf',
            text: 'Surat Tugas Barcode',
            onclick: () => {
                let row = dg.datagrid('getSelected');
                if (row.status < yii.app.suratTugas.STATUS_PENGESAHAN) {
                    return $.messager.alert('PDF Surat Tugas', 'Status Surat Tugas harus PENGESAHAN', 'error');
                }
                yii.app.dialog.pdf('surat-tugas', row, 'link_barcode');
            },
        });

        suratTugasMmPdf.menu('appendItem', {
            iconCls: 'icon-pdf',
            text: 'Surat Tugas sudah TTD',
            onclick: () => {
                let row = dg.datagrid('getSelected');
                if (row.status < yii.app.suratTugas.STATUS_TERBIT) {
                    return $.messager.alert('PDF Surat Tugas', 'Status Surat Tugas harus TERBIT', 'error');
                }
                yii.app.dialog.pdf('surat-tugas', row, 'link_ttd');
            },
        });

        $('#surat-tugas-tb-pdf').menubutton({
            text: 'PDF',
            iconCls: 'icon-pdf',
            menu: suratTugasMmPdf
        });
    };

    var ajaxGenerateSppd = function (row) {
        yii.easyui.showMainMask();
        $.ajax({
            url: yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/pelaksana-tugas/generate-sppd',
                id: row.id
            }, true),
            type: 'POST',
            dataType: 'json',
            success: function (res) {
                yii.easyui.hideMainMask();
                $.messager.alert('Generate SPPD', res.message, res.success ? 'info' : 'error', () => {
                    if (res.success) {
                        pltDg.datagrid('reload');
                    }
                });
            },
            error: function (xhr) {
                yii.easyui.hideMainMask();
                return yii.easyui.ajaxError(xhr, function (r) {
                    if (r) {
                        ajaxGenerateSppd(row);
                    }
                });
            }
        });
    };

    var initPltDg = () => {
        pltDg = el.find('#surat-tugas-plt-dg');
        pltDg.datagrid({
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
            columns: [
                [
                    { field: 'ck', checkbox: true },
                    {
                        field: 'nama', title: 'Nama', width: 170,
                        formatter: function (value, row, index) {
                            if (row.pegawai) {
                                return row.pegawai.nama_tanpa_gelar;
                            } else if (row.penduduk) {
                                return row.penduduk.nama_tanpa_gelar;
                            }
                            return '';
                        }
                    },
                    {
                        field: 'status',
                        title: 'Status', width: 170,
                        formatter: function (value, row, index) {
                            return yii.app.getRef('statusPelaksanaTugas', value);
                        }
                    },
                ]
            ],
            toolbar: [
                {
                    text: 'Baru',
                    iconCls: 'icon-add',
                    handler: () => {
                        suratTugasPltFormDlg();
                    }
                }, {
                    text: 'Edit',
                    iconCls: 'icon-edit',
                    handler: () => {
                        var row = pltDg.datagrid('getSelected');
                        if (yii.easyui.requiredSelectedRow(row)) {
                            suratTugasPltFormDlg(row);
                        }
                    }
                }, '-', {
                    text: 'Hapus',
                    iconCls: 'icon-remove',
                    handler: () => {
                        var row = pltDg.datagrid('getSelected');
                        yii.app.ajax.delete({
                            id: row.id,
                            route: 'v1/pelaksana-tugas/delete',
                            text: 'Pelaksana Tugas',
                            callback: () => {
                                pltDg.datagrid('reload');
                            }
                        });
                    }
                }, {
                    text: 'Generate SPPD',
                    iconCls: 'icon-script',
                    handler: () => {
                        var row = pltDg.datagrid('getSelected');
                        if (yii.easyui.requiredSelectedRow(row)) {
                            $.messager.confirm('Generate SPPD', 'Yakin akan generate SPPD?', () => {
                                ajaxGenerateSppd(row);
                            });
                        }
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
        }).datagrid('enableFilter', [
        ]);
    };

    return {
        isActive: false,
        init: () => {
            el = $('#surat-tugas-index');
            el.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Pelaksana Tugas',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="surat-tugas-plt-dg"></div>',
                width: 400,
                hideCollapsedContent: !1,
            }).layout('add', {
                region: 'center',
                border: false,
                content: '<div id="surat-tugas-center"></div>'
            });

            centerEl = $('#surat-tugas-center');
            centerEl.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="surat-tugas-center-east"></div>',
                width: 400,
                hideCollapsedContent: !1,
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="surat-tugas-dg"></table>'
            });

            initStDg();

            initStPg();

            initPltDg();
        },
        pegawaiPltInput: () => {
            return pegawaiPltInput;
        },
        pendudukPltInput: () => {
            return pendudukPltInput;
        },
    };
})(window.jQuery);