<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rincian_biaya_sppd}}`.
 */
class m191206_231117_create_rincian_biaya_sppd_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%rincian_biaya_sppd}}', [
            'id' => $this->primaryKey(),
            'sppd_id' => $this->integer()->notNull(),
            'jenis_biaya_id' => $this->integer(),
            //ini ada karena tidak semua biaya dari jenis biaya yang ada, bisa custom
            'kategori_biaya_id' => $this->integer()->notNull(),
            'tanggal' => $this->date()->notNull(),
            'uraian' => $this->string(),
            'volume' => $this->decimal(10, 2)->notNull(),
            'satuan_id' => $this->integer()->notNull(),
            'harga' => $this->decimal(15, 2)->notNull(),
            'total' => $this->decimal(15, 2),
            'total_bukti' => $this->decimal(15, 2),
            'riil' => $this->integer(1),
            'pdf_bukti' => $this->string(),
            'urutan' => $this->integer(),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('{{%fk-rbs-si}}', '{{%rincian_biaya_sppd}}', 'sppd_id', '{{%sppd}}', 'id');
        $this->addForeignKey('{{%fk-rbs-jbi}}', '{{%rincian_biaya_sppd}}', 'jenis_biaya_id', '{{%jenis_biaya_sppd}}', 'id');
        $this->addForeignKey('{{%fk-rbs-kbi}}', '{{%rincian_biaya_sppd}}', 'kategori_biaya_id', '{{%kategori_biaya_sppd}}', 'id');
        $this->addForeignKey('{{%fk-rbs-sat}}', '{{%rincian_biaya_sppd}}', 'satuan_id', '{{%satuan}}', 'id');
        $this->addForeignKey('{{%fk-rbs-cb}}', '{{%rincian_biaya_sppd}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-rbs-ub}}', '{{%rincian_biaya_sppd}}', 'updated_by', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%rincian_biaya_sppd}}');
    }

}
