<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%anggaran}}`.
 */
class m191119_200642_create_anggaran_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%anggaran}}', [
            'id' => $this->primaryKey(),
            'opd_id' => $this->integer()->notNull(),
            'produk_hukum_id' => $this->integer()->notNull(),
            'kode_rekening' => $this->string(15)->notNull(),
            'jumlah' => $this->decimal(15, 2)->notNull(),
            'saldo' => $this->decimal(15, 2),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
        
        $this->addForeignKey('{{%fk-aggrn-opd}}', '{{%anggaran}}', 'opd_id', '{{%opd}}', 'id');
        $this->addForeignKey('{{%fk-aggrn-phi}}', '{{%anggaran}}', 'produk_hukum_id', '{{%produk_hukum}}', 'id');
        $this->addForeignKey('{{%fk-aggrn-kr}}', '{{%anggaran}}', 'kode_rekening', '{{%rekening}}', 'kode');
        $this->addForeignKey('{{%fk-aggrn-cb}}', '{{%anggaran}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-aggrn-ub}}', '{{%anggaran}}', 'updated_by', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%anggaran}}');
    }

}
