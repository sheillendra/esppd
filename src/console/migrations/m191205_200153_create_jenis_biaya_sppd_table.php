<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%jenis_biaya_sppd}}`.
 */
class m191205_200153_create_jenis_biaya_sppd_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%jenis_biaya_sppd}}', [
            'id' => $this->primaryKey(),
            'kategori_biaya_sppd_id' => $this->integer(),
            'satuan_id' => $this->integer(),
            'nama' => $this->string(100),
            'pembuktian' => $this->integer(1)->defaultValue(0),
            'pergi_pulang' => $this->integer(1)->defaultValue(0),
            'status' => $this->integer(1)->defaultValue(1),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('{{%fk-jbs-kbs}}', '{{%jenis_biaya_sppd}}', 'kategori_biaya_sppd_id', '{{%kategori_biaya_sppd}}', 'id');
        $this->addForeignKey('{{%fk-jbs-sat}}', '{{%jenis_biaya_sppd}}', 'satuan_id', '{{%satuan}}', 'id');
        $this->addForeignKey('{{%fk-jbs-cb}}', '{{%jenis_biaya_sppd}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-jbs-ub}}', '{{%jenis_biaya_sppd}}', 'updated_by', '{{%user}}', 'id');

        $this->batchInsert('{{%jenis_biaya_sppd}}', ['id', 'satuan_id',
            'kategori_biaya_sppd_id', 'pembuktian', 'pergi_pulang', 'nama',
            'created_at', 'created_by', 'updated_at', 'updated_by'
                ], [
            [1, 1, 2, 0, 0, 'Uang Harian', time(), 2, time(), 2],
            [2, 4, 6, 0, 0, 'Representasi', time(), 2, time(), 2],
            [3, 3, 5, 1, 1, 'Tiket Pesawat', time(), 2, time(), 2],
            [4, 2, 3, 1, 0, 'Hotel/Penginapan', time(), 2, time(), 2],
        ]);
        Yii::$app->db->createCommand()->resetSequence('{{%jenis_biaya_sppd}}', 5)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%jenis_biaya_sppd}}');
    }

}
