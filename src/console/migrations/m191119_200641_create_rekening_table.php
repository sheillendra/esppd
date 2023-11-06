<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rekening}}`.
 */
class m191119_200641_create_rekening_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rekening}}', [
            'kode' => $this->string(15)->notNull(),
            'nama' => $this->string()->notNull(),
            'kode_induk' => $this->string(15),
            'status' => $this->tinyInteger(1)->defaultValue(1),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
            'PRIMARY KEY ([[kode]])'
        ]);

        $this->addForeignKey('{{%fk-rekening-ki}}', '{{%rekening}}', 'kode_induk', '{{%rekening}}', 'kode');
        $this->addForeignKey('{{%fk-rekening-cb}}', '{{%rekening}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-rekening-ub}}', '{{%rekening}}', 'updated_by', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rekening}}');
    }
}
