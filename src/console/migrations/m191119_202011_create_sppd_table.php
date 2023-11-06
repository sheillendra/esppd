<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sppd}}`.
 */
class m191119_202011_create_sppd_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sppd}}', [
            'id' => $this->primaryKey(),
            'anggaran_id' => $this->integer(),
            'pelaksana_tugas_id' => $this->integer()->notNull(),
            'bendahara_pengeluaran_id' => $this->integer()->comment('BendaharaPengeluaranSPPD'),
            'pelaksana_teknik_kegiatan_id' => $this->integer()->comment('PelaksanaTeknikKegiatanSppd'),
            'nomor' => $this->string(60),
            'tanggal' => $this->date(),
            'wilayah_berangkat' => $this->string(12),
            'wilayah_tujuan' => $this->string(12),
            'tanggal_berangkat' => $this->date(),
            'tanggal_kembali' => $this->date(),
            'tanggal_rampung' => $this->date(),
            'alat_angkutan' => $this->string(),
            'total_biaya' => $this->decimal(15, 2),
            'saldo_awal' => $this->decimal(15, 2),
            'saldo_akhir' => $this->decimal(15, 2),
            'status' => $this->integer(1)->notNull()->defaultValue(1),
            'keterangan' => $this->text(),
            'fix_tingkat_sppd' => $this->string(40),
            'fix_anggaran_opd' => $this->string(),
            'fix_anggaran_opd_singkatan' => $this->string(),
            'fix_pa_nama' => $this->string()->comment('Pengguna Anggaran'),
            'fix_pa_nip' => $this->string(),
            'fix_bendahara_nama' => $this->string()->comment('Bendahara Pengeluaran'),
            'fix_bendahara_nip' => $this->string(),
            'fix_teknik_nama' => $this->string()->comment('Pejabat Pelaksanaan Teknik Kegiatan'),
            'fix_teknik_nip' => $this->string(),
            'fix_penatausahaan_nama' => $this->string()->comment('Pejabat Penatausahaan Keuangan SKPD'),
            'fix_penatausahaan_nip' => $this->string(),
            'fix_kategori_wilayah' => $this->string(),
            'pdf_filename_sppd_blank' => $this->string(40),
            'pdf_filename_sppd_barcode' => $this->string(40),
            'pdf_filename_sppd_ttd' => $this->string(40),
            'pdf_filename_visum_blank' => $this->string(40),
            'pdf_filename_visum_barcode' => $this->string(40),
            'pdf_filename_visum_ttd' => $this->string(40),
            'pdf_filename_biaya_blank' => $this->string(40),
            'pdf_filename_biaya_barcode' => $this->string(40),
            'pdf_filename_biaya_ttd' => $this->string(40),
            'pdf_filename_kwitansi_blank' => $this->string(40),
            'pdf_filename_kwitansi_barcode' => $this->string(40),
            'pdf_filename_kwitansi_ttd' => $this->string(40),
            'pdf_filename_riil_blank' => $this->string(40),
            'pdf_filename_riil_barcode' => $this->string(40),
            'pdf_filename_rill_ttd' => $this->string(40),
            'pdf_filename_rampung_blank' => $this->string(40),
            'pdf_filename_rampung_barcode' => $this->string(40),
            'pdf_filename_rampung_ttd' => $this->string(40),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('{{%fk-sppd-ai}}', '{{%sppd}}', ['[[anggaran_id]]'], '{{%anggaran}}', ['id']);
        $this->addForeignKey('{{%fk-sppd-pti}}', '{{%sppd}}', 'pelaksana_tugas_id', '{{%pelaksana_tugas}}', 'id');
        $this->addForeignKey('{{%fk-sppd-bpi}}', '{{%sppd}}', 'bendahara_pengeluaran_id', '{{%pejabat_keuangan}}', 'id');
        $this->addForeignKey('{{%fk-sppd-pptki}}', '{{%sppd}}', 'pelaksana_teknik_kegiatan_id', '{{%pejabat_keuangan}}', 'id');
        $this->addForeignKey('{{%fk-sppd-wb}}', '{{%sppd}}', 'wilayah_berangkat', '{{%wilayah}}', 'kode');
        $this->addForeignKey('{{%fk-sppd-wt}}', '{{%sppd}}', 'wilayah_tujuan', '{{%wilayah}}', 'kode');
        $this->addForeignKey('{{%fk-sppd-cb}}', '{{%sppd}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-sppd-ub}}', '{{%sppd}}', 'updated_by', '{{%user}}', 'id');

        $this->createIndex('{{%idx-sppd-bpi}}', '{{%sppd}}', 'bendahara_pengeluaran_id');
        $this->createIndex('{{%idx-sppd-pptki}}', '{{%sppd}}', 'pelaksana_teknik_kegiatan_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sppd}}');
    }
}
