<?php

namespace backend\models;

use Yii;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use common\models\SppdExt;
use common\models\OpdExt;
use common\models\KategoriBiayaSppdExt;

/**
 * @property \common\models\SppdExt[] $data
 * @property \common\models\OpdExt $opd
 */
class SppdRegisterForm extends \yii\base\Model {

    public $opd_id;
    public $dari_tanggal;
    public $sampai_tanggal;
    private $_data;
    private $_last_row;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            // username and password are both required
            [['opd_id', 'dari_tanggal', 'sampai_tanggal'], 'required'],
            ['dari_tanggal', 'date', 'timestampAttribute' => 'dari_tanggal'],
            ['sampai_tanggal', 'date', 'timestampAttribute' => 'sampai_tanggal'],
            ['dari_tanggal', 'compare', 'compareAttribute' => 'sampai_tanggal',
                'operator' => '<=', 'enableClientValidation' => false],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpd() {
        return OpdExt::findOne(['id' => $this->opd_id]);
    }

    public function generateExcel() {
        $result = ['success' => false, 'message' => '', 'time' => null];
        if (empty($this->data)) {
            $result['message'] = 'Tidak ada data SPPD yang rampung';
            return $result;
        }

        $path = $this->data[0]->getUploadPath(true);
        $filename = $this->opd_id . '_' . $this->dari_tanggal . '_' .
                $this->sampai_tanggal . '_' . 'register.xlsx';

        if (strtotime($this->sampai_tanggal) < time() &&
                file_exists($path . DIRECTORY_SEPARATOR . $filename)) {
            $result['success'] = true;
            $result['message'] = 'File generate sudah ada.';
            return $result;
        }

        $result['time'] = time();

        set_time_limit(0);
        $spreadsheet = new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0);

        $this->header($spreadsheet);
        $this->body($spreadsheet);
        $this->footer($spreadsheet);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->setPreCalculateFormulas(false);
        $writer->save($path . DIRECTORY_SEPARATOR . $filename);


        $result['success'] = true;
        $result['registerFile'] = $this->data[0]->sheetId(['register', $filename]);
        $result['message'] = 'Generate Excel berhasil';
        return $result;
    }

    protected function getColWidth() {
        return ['A' => 5, 'B' => 27, 'C' => 30, 'D' => 11, 'E' => 55,
            'F' => 15, 'G' => 11, 'H' => 11, 'I' => 10, 'J' => 15, 'K' => 15,
            'L' => 18.67, 'M' => 15.20, 'N' => 15.20, 'O' => 15.20, 'P' => 15.20,
            'Q' => 15.20, 'R' => 15.20, 'S' => 15.20, 'T' => 15.20,
            'U' => 15.20, 'V' => 15.20, 'W' => 15.20, 'X' => 15.20,
            'Y' => 15.20, 'Z' => 15.20, 'AA' => 15.20, 'AB' => 15.20,
            'AC' => 15.20, 'AD' => 15.20, 'AE' => 15.20, 'AF' => 15.20,
            'AG' => 15.20,
        ];
    }

    protected function getHeaderCellOptions() {
        return [
            'AG1' => ['value' => 'Lampiran 4', 'align' => 'right'],
            'A2' => [
                'value' => 'REKAP PERJALANAN DINAS LUAR DAERAH (LUAR PROVINSI) PERIODE ' .
                $this->dari_tanggal . ' - ' . $this->sampai_tanggal,
                'merge' => 'AG2'
            ],
            'A5' => [
                'value' => 'Nama OPD : ' . $this->opd->nama,
                'align' => 'left'
            ],
            'A7' => ['value' => 'No.', 'merge' => 'A9'],
            'B7' => [
                'value' => "Nama Lengkap \n(TANPA GELAR)",
                'merge' => 'B9',
                'fill' => 'b9cce4',
                'wrap' => true,
            ],
            'C7' => [
                'value' => 'SURAT TUGAS DAN SPPD',
                'merge' => 'I8',
                'fill' => 'ffff00'
            ],
            'J7' => ['value' => 'Kwitansi / Rincian Perjadin', 'merge' => 'P8',],
            'Q7' => ['value' => 'Transportasi Pesawat', 'merge' => 'AB7',],
            'AC7' => ['value' => 'Akomodasi', 'merge' => 'AG7',],
            'Q8' => ['value' => 'Keberangkatan', 'merge' => 'V8',],
            'W8' => ['value' => 'Kepulangan', 'merge' => 'AB8',],
            'AC8' => ['value' => 'Nama Hotel', 'merge' => 'AC9',],
            'AD8' => ['value' => 'Tanggal Checkin', 'merge' => 'AD9',],
            'AE8' => ['value' => 'Tanggal Checkout', 'merge' => 'AE9',],
            'AF8' => ['value' => 'Nomor Kamar', 'merge' => 'AF9',],
            'AG8' => ['value' => 'Kelas Kamar', 'merge' => 'AG9',],
            'C9' => ['value' => 'No. SPPD', 'fill' => 'ffff00'],
            'D9' => ['value' => 'Tanggal SPPD', 'fill' => 'ffff00', 'wrap' => true,],
            'E9' => ['value' => 'Kegiatan / Dalam Rangka', 'fill' => 'ffff00', 'wrap' => true],
            'F9' => ['value' => 'Tujuan', 'fill' => 'ffff00'],
            'G9' => ['value' => 'Tanggal Berangkat', 'fill' => 'ffff00', 'wrap' => true],
            'H9' => ['value' => 'Tanggal Kembali', 'fill' => 'ffff00', 'wrap' => true],
            'I9' => ['value' => 'Lamanya (hari)', 'fill' => 'ffff00', 'wrap' => true],
            'J9' => ['value' => 'Uang Harian', 'wrap' => true],
            'K9' => ['value' => 'Uang Representasi', 'wrap' => true],
            'L9' => ['value' => 'Hotel'],
            'M9' => ['value' => 'Transportasi Lokal', 'wrap' => true],
            'N9' => ['value' => 'Biaya Transportasi', 'wrap' => true],
            'O9' => ['value' => 'Biaya Lainnya', 'wrap' => true],
            'P9' => ['value' => 'Jumlah Diterima Sesuai Kwitansi', 'wrap' => true],
            'Q9' => ['value' => 'Nama Pesawat', 'wrap' => true],
            'R9' => ['value' => 'Tanggal dd/mm/yy', 'wrap' => true],
            'S9' => ['value' => 'No. Flight', 'wrap' => true],
            'T9' => ['value' => 'Kode Booking', 'wrap' => true],
            'U9' => ['value' => 'Nomor Tiket', 'wrap' => true],
            'V9' => ['value' => 'Harga Tiket', 'wrap' => true],
            'W9' => ['value' => 'Nama Pesawat', 'wrap' => true],
            'X9' => ['value' => 'Tanggal dd/mm/yy', 'wrap' => true],
            'Y9' => ['value' => 'No. Flight', 'wrap' => true],
            'Z9' => ['value' => 'Kode Booking', 'wrap' => true],
            'AA9' => ['value' => 'Nomor Tiket', 'wrap' => true],
            'AB9' => ['value' => 'Harga Tiket', 'wrap' => true],
            'A10' => ['value' => '1'],
            'B10' => ['value' => '2'],
            'C10' => ['value' => '3'],
            'D10' => ['value' => '4'],
            'E10' => ['value' => '5'],
            'F10' => ['value' => '6'],
            'G10' => ['value' => '7'],
            'H10' => ['value' => '8'],
            'I10' => ['value' => '9'],
            'J10' => ['value' => '10'],
            'K10' => ['value' => '11'],
            'L10' => ['value' => '12'],
            'M10' => ['value' => '13'],
            'N10' => ['value' => '14'],
            'O10' => ['value' => '15'],
            'P10' => ['value' => '16'],
            'Q10' => ['value' => '17'],
            'R10' => ['value' => '18'],
            'S10' => ['value' => '19'],
            'T10' => ['value' => '10'],
            'U10' => ['value' => '21'],
            'V10' => ['value' => '22'],
            'W10' => ['value' => '23'],
            'X10' => ['value' => '24'],
            'Y10' => ['value' => '25'],
            'Z10' => ['value' => '26'],
            'AA10' => ['value' => '27'],
            'AB10' => ['value' => '28'],
            'AC10' => ['value' => '29'],
            'AD10' => ['value' => '30'],
            'AE10' => ['value' => '31'],
            'AF10' => ['value' => '32'],
            'AG10' => ['value' => '33'],
        ];
    }

    /**
     * 
     * @param Spreadsheet $spreadsheet
     */
    protected function header($spreadsheet) {
        foreach ($this->getColWidth() as $col => $width) {
            $spreadsheet->getSheet(0)->getColumnDimension($col)->setWidth($width);
        }

        foreach ($this->getHeaderCellOptions() as $coor => $options) {
            if (isset($options['value'])) {
                $spreadsheet->getSheet(0)->setCellValue($coor, $options['value']);
            }

            if (isset($options['merge'])) {
                $spreadsheet->getSheet(0)->mergeCells($coor . ':' . $options['merge']);
            }

            if (isset($options['align'])) {
                $spreadsheet->getSheet(0)->getStyle($coor)->getAlignment()
                        ->setHorizontal($options['align']);
            } else {
                $spreadsheet->getSheet(0)->getStyle($coor)->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }

            if (isset($options['valign'])) {
                $spreadsheet->getSheet(0)->getStyle($coor)->getAlignment()
                        ->setVertical($options['valign']);
            } else {
                $spreadsheet->getSheet(0)->getStyle($coor)->getAlignment()
                        ->setVertical(Alignment::VERTICAL_CENTER);
            }

            if (isset($options['fill'])) {
                $spreadsheet->getSheet(0)->getStyle($coor)->getFill()->setFillType('solid')
                        ->getStartColor()->setRGB($options['fill']);
            }

            if (isset($options['wrap'])) {
                $spreadsheet->getSheet(0)->getStyle($coor)->getAlignment()
                        ->setWrapText($options['wrap']);
            }
        }
    }

    /**
     * 
     * @param Spreadsheet $spreadsheet
     */
    protected function body($spreadsheet) {
        $row = 11;
        $rowNumber = 1;
        foreach ($this->data as $data) {
            $hotel = 0;
            if (isset($data->rincianBiayaSppdPerKategori[KategoriBiayaSppdExt::KATEGORI_HOTEL_PENGINAPAN])) {
                $hotel += $data->rincianBiayaSppdPerKategori[KategoriBiayaSppdExt::KATEGORI_HOTEL_PENGINAPAN]['total'];
            }

            if (isset($data->rincianBiayaSppdPerKategori[KategoriBiayaSppdExt::KATEGORI_NON_PENGINAPAN])) {
                $hotel += $data->rincianBiayaSppdPerKategori[KategoriBiayaSppdExt::KATEGORI_NON_PENGINAPAN]['total'];
            }

            $spreadsheet->getSheet(0)
                    ->setCellValue('A' . $row, $rowNumber)
                    ->setCellValue('B' . $row, $data->pelaksanaTugas->pegawai->nama_tanpa_gelar)
                    ->setCellValue('C' . $row, $data->nomor)
                    ->setCellValue('D' . $row, $data->tanggal)
                    ->setCellValue('E' . $row, $data->pelaksanaTugas->suratTugas->maksud)
                    ->setCellValue('F' . $row, $data->wilayahTujuan->nama)
                    ->setCellValue('G' . $row, $data->tanggal_berangkat)
                    ->setCellValue('H' . $row, $data->tanggal_kembali)
                    ->setCellValue('I' . $row, $data->pelaksanaTugas->suratTugas->jumlah_hari)
                    ->setCellValue('J' . $row, isset($data->rincianBiayaSppdPerKategori[KategoriBiayaSppdExt::KATEGORI_UANG_HARIAN]) ?
                                    $data->rincianBiayaSppdPerKategori[KategoriBiayaSppdExt::KATEGORI_UANG_HARIAN]['total'] : 0)
                    ->setCellValue('K' . $row, isset($data->rincianBiayaSppdPerKategori[KategoriBiayaSppdExt::KATEGORI_REPRESENTASE]) ?
                                    $data->rincianBiayaSppdPerKategori[KategoriBiayaSppdExt::KATEGORI_REPRESENTASE]['total'] : 0)
                    ->setCellValue('L' . $row, $hotel)
                    ->setCellValue('M' . $row, isset($data->rincianBiayaSppdPerKategori[KategoriBiayaSppdExt::KATEGORI_TRANSPORTASI]) ?
                                    $data->rincianBiayaSppdPerKategori[KategoriBiayaSppdExt::KATEGORI_TRANSPORTASI]['total'] : 0)
                    ->setCellValue('N' . $row, isset($data->rincianBiayaSppdPerKategori[KategoriBiayaSppdExt::KATEGORI_TIKET_PESAWAT]) ?
                                    $data->rincianBiayaSppdPerKategori[KategoriBiayaSppdExt::KATEGORI_TIKET_PESAWAT]['total'] : 0)
                    ->setCellValue('O' . $row, isset($data->rincianBiayaSppdPerKategori[KategoriBiayaSppdExt::KATEGORI_LAIN_LAIN]) ?
                                    $data->rincianBiayaSppdPerKategori[KategoriBiayaSppdExt::KATEGORI_LAIN_LAIN]['total'] : 0)
                    ->setCellValue('P' . $row, $data->total_biaya)
            ;

            $spreadsheet->getSheet(0)->getStyle('J' . $row . ':P' . $row)->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

            $row = $this->bodyRincianBiaya($spreadsheet, $data, $row);
            $rowNumber++;
        }
        $this->_last_row = $row;
    }

    /**
     * 
     * @param Spreadsheet $spreadsheet
     * @param SppdExt $data
     * $param integer $row
     */
    protected function bodyRincianBiaya($spreadsheet, $data, $row) {
        $tiketPesawats = $data->getRincianBiayaSppdsByKategori(KategoriBiayaSppdExt::KATEGORI_TIKET_PESAWAT);
        $rowBerangkat = $row;
        $rowKembali = $row;
        $rowHotel = $row;
        $firstRowRincian = $row;
        foreach ($tiketPesawats as $tiketPesawat) {
            $namaPesawat = isset($tiketPesawat->detail['nama_pesawat']) ?
                    $tiketPesawat->detail['nama_pesawat'] : '';

            $noFlight = isset($tiketPesawat->detail['no_flight']) ?
                    $tiketPesawat->detail['no_flight'] : '';

            $kodeBooking = isset($tiketPesawat->detail['kode_booking']) ?
                    $tiketPesawat->detail['kode_booking'] : '';

            $noTiket = isset($tiketPesawat->detail['nomor_tiket']) ?
                    $tiketPesawat->detail['nomor_tiket'] : '';

            if (isset($tiketPesawat->detail['jenis_rute']) &&
                    $tiketPesawat->detail['jenis_rute'] == KategoriBiayaSppdExt::JENIS_RUTE_BERANGKAT) {
                $spreadsheet->getSheet(0)
                        ->setCellValue('Q' . $rowBerangkat, $namaPesawat)
                        ->setCellValue('R' . $rowBerangkat, $tiketPesawat->tanggal)
                        ->setCellValue('S' . $rowBerangkat, $noFlight)
                        ->setCellValue('T' . $rowBerangkat, $kodeBooking)
                        ->setCellValue('U' . $rowBerangkat, $noTiket)
                        ->setCellValue('V' . $rowBerangkat, $tiketPesawat->total_bukti)
                ;
                $rowBerangkat++;
            } else {
                $spreadsheet->getSheet(0)
                        ->setCellValue('W' . $rowKembali, $namaPesawat)
                        ->setCellValue('X' . $rowKembali, $tiketPesawat->tanggal)
                        ->setCellValue('Y' . $rowKembali, $noFlight)
                        ->setCellValue('Z' . $rowKembali, $kodeBooking)
                        ->setCellValue('AA' . $rowKembali, $noTiket)
                        ->setCellValue('AB' . $rowKembali, $tiketPesawat->total_bukti)
                ;
                $rowKembali++;
            }
        }

        if ($rowBerangkat < $rowKembali) {
            $rowBerangkat = $rowKembali;
        }

        $hotels = $data->getRincianBiayaSppdsByKategori(KategoriBiayaSppdExt::KATEGORI_HOTEL_PENGINAPAN);
        foreach ($hotels as $hotel) {
            $namaHotel = isset($hotel->detail['nama_hotel']) ?
                    $hotel->detail['nama_hotel'] : '';
            $noKamar = isset($hotel->detail['nomor_kamar']) ?
                    $hotel->detail['nomor_kamar'] : '';
            $kelasKamar = isset($hotel->detail['kelas_kamar']) ?
                    $hotel->detail['kelas_kamar'] : '';
            $spreadsheet->getSheet(0)
                    ->setCellValue('AC' . $rowHotel, $namaHotel)
                    ->setCellValue('AD' . $rowHotel, $hotel->tanggal)
                    ->setCellValue('AE' . $rowHotel, date('Y-m-d', strtotime($hotel->tanggal . ' +' . number_format($hotel->volume, 0) . ' day ')))
                    ->setCellValue('AF' . $rowHotel, $noKamar)
                    ->setCellValue('AG' . $rowHotel, $kelasKamar)
            ;
            
            $spreadsheet->getSheet(0)->getStyle('AD' . $rowHotel)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $spreadsheet->getSheet(0)->getStyle('AE' . $rowHotel)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            
            $rowHotel++;
        }

        if ($rowBerangkat < $rowHotel) {
            $rowBerangkat = $rowHotel;
        }

        if ($rowBerangkat - $firstRowRincian > 1) {
            $row += $rowBerangkat - $firstRowRincian;
            $this->bodyRowspan($spreadsheet, $firstRowRincian, $row - 1);
        } else {
            $row++;
        }

        return $row;
    }

    /**
     * 
     * @param Spreadsheet $spreadsheet
     */
    protected function bodyRowspan($spreadsheet, $start, $end) {
        foreach ($this->getColWidth() as $col => $width) {
            if ($col === 'Q') {
                break;
            }
            $spreadsheet->getSheet(0)->mergeCells($col . $start . ':' . $col . $end)
                    ->getStyle($col . $start)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }
    }

    /**
     * 
     * @param Spreadsheet $spreadsheet
     */
    protected function footer($spreadsheet) {
        $spreadsheet->getSheet(0)->getStyle('A7:AG' . $this->_last_row)
                ->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => Color::COLOR_BLACK],
                        ]
                    ],
        ]);
        $spreadsheet->getProperties()
                ->setCreator('Sistem SPPD Online')
                ->setLastModifiedBy('Sistem SPPD Online')
                ->setTitle('Register SPPD For BPK')
                ->setSubject('Register SPPD For BPK')
                ->setDescription('File Register SPPD sesuai dengan format BPK.')
                ->setKeywords('sppd online')
                ->setCategory('sppd');
    }

    /**
     * 
     * @return \common\models\SppdExt[]
     */
    protected function getData() {
        if ($this->_data === null) {
            $this->_data = SppdExt::find()
                    ->alias('t0')
                    ->leftJoin('{{%anggaran}} t1', 't0.anggaran_id = t1.id')
                    ->where(['t1.opd_id' => $this->opd_id])
                    ->andWhere(['>=', 't0.tanggal', $this->dari_tanggal])
                    ->andWhere(['<=', 't0.tanggal', $this->sampai_tanggal])
                    ->andWhere(['t0.status' => SppdExt::STATUS_HITUNG_RAMPUNG])
                    ->all();
        }
        return $this->_data;
    }

    protected function getBiayaPerKategori() {
        
    }

}
