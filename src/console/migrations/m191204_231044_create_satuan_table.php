<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%satuan}}`.
 */
class m191204_231044_create_satuan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%satuan}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string(20),
            'harian' => $this->integer(1)->defaultValue(0),
            'status' => $this->integer(1)->notNull()->defaultValue(1),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('{{%fk-satuan-cb}}', '{{%satuan}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-satuan-ub}}', '{{%satuan}}', 'updated_by', '{{%user}}', 'id');

        $this->batchInsert('{{%satuan}}', ['id', 'nama', 'harian', 'created_at', 'created_by', 'updated_at', 'updated_by'], [
            [1, 'Hari', 1, time(), 2, time(), 2],
            [2, 'Malam', 1, time(), 2, time(), 2],
            [3, 'Flyed', 0, time(), 2, time(), 2],
            [4, 'Ls', 0, time(), 2, time(), 2],
            [5, 'Trip', 0, time(), 2, time(), 2],
        ]);
        Yii::$app->db->createCommand()->resetSequence('{{%satuan}}', 6)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%satuan}}');
    }
}
