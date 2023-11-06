<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pelaksana_tugas}}`.
 */
class m191114_155223_create_pelaksana_tugas_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%pelaksana_tugas}}', [
            'id' => $this->primaryKey(),
            'surat_tugas_id' => $this->integer()->notNull(),
            'pegawai_id' => $this->integer(),
            'penduduk_id' => $this->integer(),
            'status' => $this->integer(1)->notNull()->defaultValue(1),
            'urutan' => $this->integer(),
            'keterangan' => $this->text(),
            //data pelaksana harus di-fix-kan, dicatat yang saat itu dimiliki karena data-data itu dinamis
            'fix_nama' => $this->string(),
            'fix_nip' => $this->string(),
            'fix_jabatan' => $this->string(),
            'fix_pangkat_golongan' => $this->string(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('{{%fk-pst-sti}}', '{{%pelaksana_tugas}}', 'surat_tugas_id', '{{%surat_tugas}}', 'id');
        $this->addForeignKey('{{%fk-pst-pgi}}', '{{%pelaksana_tugas}}', 'pegawai_id', '{{%pegawai}}', 'id');
        $this->addForeignKey('{{%fk-pst-pdi}}', '{{%pelaksana_tugas}}', 'penduduk_id', '{{%penduduk}}', 'id');
        $this->addForeignKey('{{%fk-pst-cb}}', '{{%pelaksana_tugas}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-pst-ub}}', '{{%pelaksana_tugas}}', 'updated_by', '{{%user}}', 'id');

        $this->createIndex('{%idx-pst-spp}', '{{%pelaksana_tugas}}', ['surat_tugas_id', 'pegawai_id', 'penduduk_id'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%pelaksana_tugas}}');
    }

}
