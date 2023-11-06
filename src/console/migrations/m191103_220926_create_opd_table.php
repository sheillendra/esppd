<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%opd}}`.
 */
class m191103_220926_create_opd_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%opd}}', [
            'id' => $this->primaryKey(),
            'kode' => $this->string(25)->notNull(),
            'kode_wilayah' => $this->string(12),
            'nama' => $this->string(100)->notNull(),
            'singkatan' => $this->string(30)->notNull(),
            'baris_kop_1' => $this->string()->notNull(),
            'baris_kop_2' => $this->string()->notNull(),
            'text_kedudukan' => $this->string(20)->notNull(),
            'status' => $this->integer(1)->defaultValue(1),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('{{%fk-opd-kw}}', '{{%opd}}', 'kode_wilayah', '{{%wilayah}}', 'kode');
        $this->addForeignKey('{{%fk-opd-cb}}', '{{%opd}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-opd-ub}}', '{{%opd}}', 'updated_by', '{{%user}}', 'id');

        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%opd}}');
    }

}
