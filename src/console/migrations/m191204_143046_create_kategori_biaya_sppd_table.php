<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kategori_biaya_sppd}}`.
 */
class m191204_143046_create_kategori_biaya_sppd_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kategori_biaya_sppd}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string()->notNull(),
            'status' => $this->integer(1),
            'urutan' => $this->integer(),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
        
        $this->addForeignKey('{{%fk-kbs-cb}}', '{{%kategori_biaya_sppd}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-kbs-ub}}', '{{%kategori_biaya_sppd}}', 'updated_by', '{{%user}}', 'id');
        
        $this->batchInsert('{{%kategori_biaya_sppd}}', ['id', 'nama', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], [
            [1, 'Transportasi', 1, time(), 2, time(), 2],
            [2, 'Uang Harian', 1, time(), 2, time(), 2],
            [3, 'Hotel/Penginapan', 1, time(), 2, time(), 2],
            [4, 'Non Penginapan', 1, time(), 2, time(), 2],
            [5, 'Tiket Pesawat', 1, time(), 2, time(), 2],
            [6, 'Representase', 1, time(), 2, time(), 2],
            [7, 'Lain-lain', 1, time(), 2, time(), 2],
        ]);
        Yii::$app->db->createCommand()->resetSequence('{{%jabatan_keuangan}}', 8)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%kategori_biaya_sppd}}');
    }
}
