window.yii.app.sppd = (($) => {

    var el;
    var centerEl;

    var dg;
    var pg;
    var biayaDg;

    var sppdSelectedRow;

    var sppdForm;
    var biayaForm;
    var sppdDlg;
    var biayaDlg;
    var nomorSppdInput;
    var anggaranSppdInput;
    var wilayahBerangkatSppdInput;
    var wilayahTujuanSppdInput;
    var keteranganSppdInput;

    var sppdIdInput;
    var tanggalBiayaInput;
    var kategoriBiayaInput;
    var jenisBiayaInput;
    var satuanBiayaInput;
    var uraianBiayaInput;
    var volumeBiayaInput;
    var hargaBiayaInput;
    var keteranganBiayaInput;

    var biayaFormDlg = (row) => {
        var title = 'Biaya SPPD Baru';
        var url;
        var parentRow = dg.datagrid('getSelected');
        if (row) {
            title = 'Edit Biaya SPPD';
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/rincian-biaya-sppd/update',
                id: row.id
            }, true);
        } else {
            url = yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({ r: 'v1/rincian-biaya-sppd/create' }, true);
        }

        if (biayaDlg) {
            biayaDlg.dialog('setTitle', title);
            biayaDlg.dialog('open');
            biayaForm.form({ url: url });
            if (row) {
                biayaForm.form('load', row);
            } else {
                biayaForm.form('reset');
                sppdIdInput.val(parentRow.id);
            }
        } else {
            biayaDlg = $('<div></div>').dialog({
                title: title,
                modal: true,
                height: 450,
                width: 355,
                buttons: [
                    {
                        iconCls: 'icon-disk',
                        text: 'Save',
                        handler: () => {
                            biayaForm.form('submit');
                        }
                    }
                ],
                content: '<div style="padding: 20px"><form id="sppd-biaya-form" method="post"></form></div>'
            });

            biayaForm = biayaDlg.find('#sppd-biaya-form');

            tanggalBiayaInput = $('<input name="tanggal"/>');
            biayaForm.append(tanggalBiayaInput);
            tanggalBiayaInput.datebox({
                label: 'Tanggal: ',
                labelPosition: 'top',
                width: 300,
                required: true,
                min: parentRow.tanggal_berangkat,
                max: parentRow.tanggal_kembali,
                editable: false,
                onShowPanel: () => {
                    var opts = $(this).datebox('options');
                    $(this).datebox('calendar').calendar({
                        validator: (date) => {
                            var min = opts.parser(opts.min);
                            var max = opts.parser(opts.max);
                            if (min <= date && date <= max) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    });
                }
            });

            sppdIdInput = $('<input name="sppd_id" type="hidden"/>');
            biayaForm.append(sppdIdInput);
            sppdIdInput.val(parentRow.id);

            kategoriBiayaInput = $('<input name="kategori_biaya_id" style="border: none"/>');
            biayaForm.append(kategoriBiayaInput);
            yii.app.refDropdown('kategoriBiayaSppd', kategoriBiayaInput, (refData, res) => {

            }, {
                required: true,
                prompt: 'Pilih kategori biaya',
                label: 'Kategori',
                onSelect: (value) => {
                    if (!yii.app.ref.jenisBiayaSppdByKategori[value.id]) {
                        yii.app.ref.jenisBiayaSppdByKategori[value.id] = [];
                        $.each(yii.app.refResultById['kategoriBiayaSppd'], (k, v) => {
                            if (v.id === ~~value.id) {
                                $.each(v.jenisBiayaSppds, (kk, vv) => {
                                    yii.app.ref.jenisBiayaSppdByKategori[value.id].push({
                                        id: vv.id,
                                        text: vv.nama
                                    });
                                });
                            }
                        });


                    }
                    jenisBiayaInput.combobox('clear');
                    jenisBiayaInput.combobox('loadData', yii.app.ref.jenisBiayaSppdByKategori[value.id]);
                }
            });

            jenisBiayaInput = $('<input name="jenis_biaya_id" style="border: none"/>');
            biayaForm.append(jenisBiayaInput);
            jenisBiayaInput.combobox({
                prompt: 'Kosongkan bila tidak ada',
                label: 'Jenis Biaya',
                labelPosition: 'top',
                width: 300,
                valueField: 'id',
                textField: 'text',
                icons: [
                    {
                        iconCls: 'icon-clear',
                        handler: (e) => {
                            jenisBiayaInput.combobox('clear');
                        }
                    }
                ],
            });

            uraianBiayaInput = $('<input name="uraian"/>');
            biayaForm.append(uraianBiayaInput);
            uraianBiayaInput.textbox({
                label: 'Uraian: ',
                labelPosition: 'top',
                width: 300,
                multiline: true,
                height: 80
            });

            volumeBiayaInput = $('<input name="volume"/>');
            biayaForm.append(volumeBiayaInput);
            volumeBiayaInput.numberspinner({
                label: 'Volume: ',
                labelPosition: 'top',
                width: 300,
                required: true,
                min: 1
            });

            satuanInput = $('<input name="satuan_id" style="border: none"/>');
            biayaForm.append(satuanInput);
            yii.app.refDropdown('satuan', satuanInput, (refData, res) => { }, {
                editable: false,
            });

            hargaBiayaInput = $('<input name="harga" />');
            biayaForm.append(hargaBiayaInput);
            hargaBiayaInput.numberbox({
                label: 'Harga: ',
                labelPosition: 'top',
                width: 300,
                required: true,
                groupSeparator: '.',
                decimalSeparator: ',',
            });

            keteranganBiayaInput = $('<input name="keterangan"/>');
            biayaForm.append(keteranganBiayaInput);
            keteranganBiayaInput.textbox({
                label: 'Keterangan: ',
                labelPosition: 'top',
                width: 300,
                multiline: true,
                height: 80
            });

            biayaForm.form({
                url: url,
                iframe: false,
                success: (data) => {
                    biayaDlg.dialog('close');
                    biayaDg.datagrid('reload');
                }
            });

            if (row) {
                biayaForm.form('load', row);
            } else {
                tanggalBiayaInput.datebox('setValue', parentRow.tanggal_berangkat);
                volumeBiayaInput.numberspinner('setValue', 1);
            }
        }
    };

    var ajaxChangeStatus = (status, row) => {
        yii.easyui.showMainMask();
        $.ajax({
            url: yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/sppd/change-status',
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
                        if (status.id == 1) {
                            pg.propertygrid('loadData', pgData(row));
                        }
                        biayaDg.datagrid('reload');
                        //dg.datagrid('selectRow', row.id);
                    } else {
                        pg.propertygrid('loadData', pgData(row));
                    }

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

    var ajaxUpdate = (data) => {
        yii.easyui.showMainMask();
        $.ajax({
            url: yii.easyui.getHost('api') + yii.easyui.ajaxAuthToken({
                r: 'v1/sppd/update',
                id: sppdSelectedRow.id,
            }, true),
            data: data,
            type: 'POST',
            dataType: 'json',
            success: (res) => {
                yii.easyui.hideMainMask();
                Object.keys(data).forEach((k) => {
                    sppdSelectedRow[k] = data[k];
                });
            },
            error: (xhr) => {
                yii.easyui.hideMainMask();
                return yii.easyui.ajaxError(xhr, (r) => {
                    if (r) {
                        ajaxUpdate(data);
                    } else {
                        pg.propertygrid('loadData', pgData(sppdSelectedRow));
                    }
                });
            }
        });
    };

    var pgData = (row) => {
        row = row || {
            pelaksanaTugas: {
                suratTugas: {}
            }
        };

        row.anggaran = row.anggaran ||
        {
            anggaran: {
                kode_rekening: ''
            }
        };

        var readonly = false;
        if (row.status > 10) {
            readonly = true;
        }

        return {
            rows: [
                {
                    name: 'Status',
                    value: yii.app.getRef('statusSppd', row.status),
                    group: 'SPPD',
                    editor: yii.app.editor.ref('statusSppd', {
                        editable: false,
                        onSelect: (status) => {
                            if (row.status !== ~~status.id) {
                                $.messager.confirm('Status SPPD', 'Apakah anda yakin akan mengubah Status SPPD menjadi ' + status.text + '?', (r) => {
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
                    group: 'SPPD',
                    fieldName: 'nomor',
                    editor: readonly ? null : yii.app.editor.textbox({
                        icons: [
                            {
                                iconCls: 'icon-save',
                                handler: (e) => {
                                    pg.propertygrid('endEdit', 1);
                                }
                            }
                        ]
                    }),
                },
                {
                    name: 'Berangkat dari',
                    value: yii.app.getRef('wilayah', row.wilayah_berangkat, () => {
                        pg.propertygrid('loadData', pgData(row));
                    }),
                    group: 'SPPD',
                    fieldName: 'wilayah_berangkat',
                    fieldType: 'wilayah',
                    editor: readonly ? null : yii.app.editor.wilayah({
                        editable: false,
                        // icons: [
                        //     {
                        //         iconCls: 'icon-save',
                        //         handler: (e) => {
                        //             pg.propertygrid('endEdit', 2);
                        //         }
                        //     }
                        // ]
                    }),
                },
                {
                    name: 'Tujuan',
                    value: yii.app.getRef('wilayah', row.wilayah_tujuan, () => {
                        pg.propertygrid('loadData', pgData(row));
                    }),
                    group: 'SPPD',
                    fieldName: 'wilayah_tujuan',
                    fieldType: 'wilayah',
                    editor: readonly ? null : yii.app.editor.wilayah({
                        editable: false,
                        icons: [
                            {
                                iconCls: 'icon-save',
                                handler: (e) => {
                                    pg.propertygrid('endEdit', 3);
                                }
                            }
                        ]
                    }),
                },
                {
                    name: 'Alat Angkutan',
                    value: row.alat_angkutan,
                    group: 'SPPD',
                    fieldName: 'alat_angkutan',
                    editor: readonly ? null : yii.app.editor.textbox({
                        icons: [
                            {
                                iconCls: 'icon-save',
                                handler: (e) => {
                                    pg.propertygrid('endEdit', 4);
                                }
                            }
                        ]
                    }),
                },
                {
                    name: 'Kode Rekening',
                    value: row.anggaran.kode_rekening,
                    group: 'SPPD',
                    fieldName: 'anggaran_id',
                    editor: readonly ? null : yii.app.editor.anggaran()
                },
                {
                    name: 'Keterangan',
                    value: row.keterangan,
                    group: 'SPPD',
                    fieldName: 'keterangan',
                    editor: readonly ? null : yii.app.editor.textarea({
                        icons: [
                            {
                                iconCls: 'icon-save',
                                handler: (e) => {
                                    pg.propertygrid('endEdit', 6);
                                }
                            }
                        ]
                    })
                },
                {
                    name: 'Jumlah Anggaran',
                    value: row.anggaran.jumlah,
                    group: 'Anggaran',
                },
                {
                    name: 'Saldo',
                    value: row.anggaran.saldo,
                    group: 'Anggaran',
                },
                {
                    name: 'Nomor Surat Tugas',
                    value: row.pelaksanaTugas.suratTugas.nomor,
                    group: 'Surat Tugas',
                },
                {
                    name: 'Tanggal',
                    value: row.tanggal,
                    group: 'Surat Tugas',
                },
                {
                    name: 'Tanggal Berangkat',
                    value: row.tanggal_berangkat,
                    group: 'Surat Tugas',
                },
                {
                    name: 'Tanggal Kembali',
                    value: row.tanggal_kembali,
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
                },
                {
                    name: 'Maksud',
                    value: row.maksud,
                    group: 'Tujuan',
                },
            ]
        };
    };

    var initPg = () => {
        pg = centerEl.find('#sppd-center-east');
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

    var initSppdDg = () => {
        sppdSelectedRow = {};
        dg = centerEl.find('#sppd-dg');
        dg.datagrid({
            url: yii.easyui.getHost('api'),
            queryParams: yii.easyui.ajaxAuthToken({
                r: 'v1/jeasyui/sppd',
                expand: 'pelaksanaTugas, pelaksanaTugas.suratTugas, anggaran'
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
            idField: 'id',
            sortName: 'id',
            sortOrder: 'desc',
            columns: [
                [
                    { field: 'ck', checkbox: true },
                    //{ field: 'id', title: 'ID', sortable: true },
                    { field: 'tanggal', title: 'Tanggal', sortable: true },
                    { field: 'nomor', title: 'Nomor' },
                    {
                        field: 't1.fix_nama', title: 'Nama Pelaksana',
                        formatter: (value, row, index) => {
                            return row.pelaksanaTugas.fix_nama;
                        }
                    },
                ]
            ],
            toolbar: '#sppd-tb',
            onLoadSuccess: (data) => {
                dg.datagrid('selectRow', 0);
            },
            onLoadError: (xhr) => {
                yii.easyui.ajaxError(xhr, (r) => {
                    if (r) {
                        dg.datagrid('reload');
                    }
                });
            },
            onSelect: (index, row) => {
                sppdSelectedRow = row;
                pg.propertygrid('loadData', pgData(row));
                biayaDg.datagrid('addFilterRule', { field: 'sppd_id', op: 'equal', value: row.id });
                biayaDg.datagrid({
                    url: yii.easyui.getHost('api'),
                    queryParams: yii.easyui.ajaxAuthToken({
                        r: 'v1/jeasyui/rincian-biaya-sppd',
                    }),
                });
            },
        }).datagrid('enableFilter', [
            yii.app.filter.customize(dg, 'tanggal', 'equal'),
            yii.app.filter.customize(dg, 'nomor', 'contains', true),
            yii.app.filter.customize(dg, 't1.fix_nama', 'contains', true),
        ]);


        $('#sppd-tb-hapus').linkbutton({
            text: 'Hapus',
            iconCls: 'icon-remove',
            plain: true,
            onClick: () => {
                let row = dg.datagrid('getSelected');
                yii.app.ajax.delete({
                    id: row.id,
                    route: 'v1/sppd/delete',
                    text: 'SPPD',
                    callback: () => {
                        dg.datagrid('reload');
                    }
                });
            }
        });

        var sppdMmPdf = $('#sppd-tb-pdf-mm');
        sppdMmPdf.menu({ minWidth: 250 });
        sppdMmPdf.menu('appendItem', {
            text: 'SPPD Belum TTD',
            onclick: () => {
                let row = dg.datagrid('getSelected');
                if (row.status < yii.app.sppd.STATUS_PENGESAHAN) {
                    return $.messager.alert('PDF SPPD', 'Status SPPD harus PENGESAHAN', 'error');
                }
                yii.app.dialog.pdf('sppd', row, 'link_sppd_blank');
            },
        });
        sppdMmPdf.menu('appendItem', {
            text: 'Visum',
            onclick: () => {
                let row = dg.datagrid('getSelected');
                if (row.status < yii.app.sppd.STATUS_PENGESAHAN) {
                    return $.messager.alert('PDF SPPD', 'Status SPPD harus PENGESAHAN', 'error');
                }
                yii.app.dialog.pdf('sppd', row, 'link_visum');
            },
        });

        sppdMmPdf.menu('appendItem', {
            text: 'Kwitansi',
            onclick: () => {
                let row = dg.datagrid('getSelected');
                if (row.status < yii.app.sppd.STATUS_PENGESAHAN) {
                    return $.messager.alert('PDF SPPD', 'Status SPPD harus PENGESAHAN', 'error');
                }
                yii.app.dialog.pdf('sppd', row, 'link_kwitansi');
            },
        });

        sppdMmPdf.menu('appendItem', { separator: true });

        sppdMmPdf.menu('appendItem', {
            text: 'SPPD Barcode',
            onclick: () => {
                let row = dg.datagrid('getSelected');
                if (row.status < yii.app.sppd.STATUS_PENGESAHAN) {
                    return $.messager.alert('PDF SPPD', 'Status SPPD harus PENGESAHAN', 'error');
                }
                yii.app.dialog.pdf('sppd', row, 'link_sppd_barcode');
            },
        });

        sppdMmPdf.menu('appendItem', { separator: true });

        sppdMmPdf.menu('appendItem', {
            text: 'SPPD Sudah TTD',
            onclick: () => {
                let row = dg.datagrid('getSelected');
                if (row.status < yii.app.sppd.STATUS_TERBIT) {
                    return $.messager.alert('PDF SPPD', 'Status SPPD harus TERBIT', 'error');
                }
                yii.app.dialog.pdf('sppd', row, 'link_sppd_ttd');
            },
        });

        sppdMmPdf.menu('appendItem', {
            text: 'Riil',
            iconCls: 'icon-pdf',
            onclick: () => {
                let row = dg.datagrid('getSelected');
                if (row.status < yii.app.sppd.STATUS_HITUNG_RAMPUNG) {
                    return $.messager.alert('PDF SPPD', 'Status SPPD harus HITUNG RAMPUNG', 'error');
                }
                yii.app.dialog.pdf('sppd', row, 'link_riil');
            },
        });

        sppdMmPdf.menu('appendItem', {
            text: 'Hitung Rampung',
            iconCls: 'icon-pdf',
            onclick: () => {
                let row = dg.datagrid('getSelected');
                if (row.status < yii.app.sppd.STATUS_HITUNG_RAMPUNG) {
                    return $.messager.alert('PDF SPPD', 'Status SPPD harus HITUNG RAMPUNG', 'error');
                }
                yii.app.dialog.pdf('sppd', row, 'link_rampung');
            },
        });

        $('#sppd-tb-pdf').menubutton({
            text: 'PDF',
            iconCls: 'icon-pdf',
            menu: sppdMmPdf
        });
    };

    var biayaGroupChildIndex;
    var biayaGroupChildIndexMap = {};
    var initBiayaDg = () => {
        biayaDg = el.find('#sppd-biaya-dg');
        biayaDg.datagrid({
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
            groupField: 'kategori_biaya_id',
            view: groupview,
            groupFormatter: (value, rows) => {
                if (biayaGroupChildIndex === null) {
                    biayaGroupChildIndex = 0;
                    biayaGroupChildIndexMap[value] = biayaGroupChildIndex;
                } else {
                    if (biayaGroupChildIndexMap[value] === undefined) {
                        biayaGroupChildIndex++;
                        biayaGroupChildIndexMap[value] = biayaGroupChildIndex;
                    }
                }

                return yii.app.getRef('kategoriBiayaSppd', value, () => {
                    biayaDg.datagrid('refreshRow', biayaGroupChildIndexMap[value]);
                });
            },
            columns: [
                [
                    { field: 'ck', checkbox: true },
                    {
                        field: 'jenis_biaya_id',
                        title: 'Jenis Biaya',
                        // width: 170,
                        formatter: (value, row, index) => {
                            return yii.app.getRef('jenisBiayaSppd', value, () => {
                                biayaDg.datagrid('refreshRow', index);
                            });
                        }
                    },
                    { field: 'uraian', title: 'Uraian' },
                    {
                        field: 'volume', title: 'Volume',
                        align: 'right',
                        formatter: (value, row, index) => {
                            return yii.easyui.currencyFormatter(value);
                        }
                    },
                    {
                        field: 'harga', title: 'Biaya',
                        align: 'right',
                        formatter: (value, row, index) => {
                            return yii.easyui.currencyFormatter(value);
                        }
                    },
                    {
                        field: 'total',
                        title: 'Jumlah',
                        align: 'right',
                        formatter: (value, row, index) => {
                            return yii.easyui.currencyFormatter(value);
                        }
                    },

                ]
            ],
            toolbar: [
                {
                    text: 'Baru',
                    iconCls: 'icon-add',
                    handler: () => {
                        if (validateHitungBiaya()) {
                            return biayaFormDlg();
                        }
                    }
                }, {
                    text: 'Edit',
                    iconCls: 'icon-edit',
                    handler: () => {
                        if (validateHitungBiaya()) {
                            biayaFormDlg(biayaDg.datagrid('getSelected'));
                        }
                    }
                }, '-', {
                    text: 'Hapus',
                    iconCls: 'icon-remove',
                    handler: () => {
                        if (validateHitungBiaya()) {
                            let row = biayaDg.datagrid('getSelected');
                            yii.app.ajax.delete({
                                id: row.id,
                                route: 'v1/rincian-biaya-sppd/delete',
                                text: 'Rincian Biaya SPPD',
                                callback: () => {
                                    biayaDg.datagrid('reload');
                                }
                            });
                        }
                    }
                },
            ],
            onLoadError: (xhr) => {
                yii.easyui.ajaxError(xhr, (r) => {
                    if (r) {
                        dg.datagrid('reload');
                    }
                });
            },
        }).datagrid('enableFilter', [
        ]);
    };

    var validateHitungBiaya = () => {
        var rowParent = dg.datagrid('getSelected');
        if (rowParent.status !== yii.app.sppd.STATUS_HITUNG_BIAYA) {
            $.messager.alert(yii.easyui.t.warning, 'Ubah Status SPPD ke "Hitung Biaya" terlebih dahulu.', 'warning');
            return false;
        }

        return true;
    };

    return {
        isActive: false,
        init: () => {
            el = $('#sppd-index');
            el.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Rincian Biaya',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="sppd-biaya-dg"></div>',
                width: 450,
                hideCollapsedContent: !1,
            }).layout('add', {
                region: 'center',
                border: false,
                content: '<div id="sppd-center"></div>'
            });

            centerEl = el.find('#sppd-center');
            centerEl.layout({
                fit: true,
                border: false
            }).layout('add', {
                title: 'Detail',
                region: 'east',
                split: true,
                border: true,
                content: '<div id="sppd-center-east"></div>',
                width: 300,
                hideCollapsedContent: !1,
            }).layout('add', {
                region: 'center',
                border: true,
                content: '<table id="sppd-dg"></table>'
            });

            initSppdDg();

            initPg();

            biayaGroupChildIndex = null;
            initBiayaDg();
        }
    };
})(window.jQuery);