<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%penduduk}}`.
 */
class m191113_170735_create_penduduk_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%penduduk}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'nik' => $this->string(16)->notNull(),
            'nama' => $this->string(100)->notNull(),
            'jenis_kelamin' => $this->integer(1)->notNull(),
            'status' => $this->integer(1)->notNull()->defaultValue(1),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);


        $this->addForeignKey('{{%fk-pdduk-ui}}', '{{%penduduk}}', 'user_id', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-pdduk-cb}}', '{{%penduduk}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-pdduk-ub}}', '{{%penduduk}}', 'updated_by', '{{%user}}', 'id');

        $this->createIndex('{{%idx-pdduk-ui}}', '{{%penduduk}}', 'user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%penduduk}}');
    }

}
