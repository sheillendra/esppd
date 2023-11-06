<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%surat_tugas}}`.
 */
class m191113_192742_create_surat_tugas_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%surat_tugas}}', [
            'id' => $this->primaryKey(),
            'pejabat_daerah_id' => $this->integer(),
            'pejabat_struktural_id' => $this->integer(),
            'tanggal_terbit' => $this->date()->notNull(),
            'nomor' => $this->string()->notNull(),
            'tanggal_mulai' => $this->date(),
            'jumlah_hari' => $this->integer()->notNull(),
            'maksud' => $this->text()->notNull(),
            'status' => $this->integer(1)->notNull()->defaultValue(1),
            'keterangan' => $this->text(),
            //data pemberi perintah harus di-fix-kan, dicatat yang saat itu dimiliki karena data-data itu dinamis
            'fix_opd_nama' => $this->string(),
            'fix_opd_kop_1' => $this->string(),
            'fix_opd_kop_2' => $this->string(),
            'fix_opd_kedudukan' => $this->string(),
            'fix_jabatan' => $this->string(),
            'fix_nama' => $this->string(),
            'fix_pangkat' => $this->string(),
            'fix_nip' => $this->string(),
            'pdf_filename_blank' => $this->string(40),
            'pdf_filename_barcode' => $this->string(40),
            'pdf_filename_ttd' => $this->string(40),
            'pdf_url_blank' => $this->string(),
            'pdf_url_barcode' => $this->string(),
            'pdf_url_ttd' => $this->string(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('{{%fk-st-pdi}}', '{{%surat_tugas}}', 'pejabat_daerah_id', '{{%pejabat_daerah}}', 'id');
        $this->addForeignKey('{{%fk-st-psi}}', '{{%surat_tugas}}', 'pejabat_struktural_id', '{{%pejabat_struktural}}', 'id');
        $this->addForeignKey('{{%fk-st-cb}}', '{{%surat_tugas}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-st-ub}}', '{{%surat_tugas}}', 'updated_by', '{{%user}}', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%surat_tugas}}');
    }

}
