<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%jabatan_keuangan}}`.
 */
class m191113_175449_create_jabatan_keuangan_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%jabatan_keuangan}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string()->notNull(),
            'singkatan' => $this->string(20),
            'urutan' => $this->integer(),
            'status' => $this->integer(1)->notNull()->defaultValue(1),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('{{%fk-jabkeu-cb}}', '{{%jabatan_keuangan}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-jabkeu-ub}}', '{{%jabatan_keuangan}}', 'updated_by', '{{%user}}', 'id');

        $this->batchInsert('{{%jabatan_keuangan}}', ['id', 'nama', 'singkatan', 'urutan', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], [
            [1, 'Pengguna Anggaran', 'PA', 1, 1, time(), 2, time(), 2],
            [2, 'Kuasa Pengguna Anggaran', 'KPA', 2, 1, time(), 2, time(), 2],
            [3, 'Pejabat Pembuat Komitmen', 'PPK', 3, 1, time(), 2, time(), 2],
            [4, 'Pejabat Pelaksanaan Teknik Kegatan', 'PPTK', 4, 1, time(), 2, time(), 2],
            [5, 'Bendahara Pengeluaran', '', 5, 1, time(), 2, time(), 2],
            [6, 'Bendahara PPKD', '', 6, 1, time(), 2, time(), 2],
            [7, 'Bendahara Gaji', '', 7, 1, time(), 2, time(), 2],
            [8, 'Pejabat Penatausahaan Keuangan SKPD', 'PPK SKPD', 8, 1, time(), 2, time(), 2],
            [9, 'Bendahara Penerimaan SKPD', '', 9, 1, time(), 2, time(), 2],
            [10, 'Bendahara Penerimaan PPKD', '', 10, 1, time(), 2, time(), 2],
            [11, 'Pengurus dan penyimpan Barang/Aset', '', 11, 1, time(), 2, time(), 2],
        ]);
        Yii::$app->db->createCommand()->resetSequence('{{%jabatan_keuangan}}', 12)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%jabatan_keuangan}}');
    }

}
