<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pangkat_golongan}}`.
 */
class m191102_043546_create_pangkat_golongan_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%pangkat_golongan}}', [
            'kode' => $this->string(2),
            'pangkat' => $this->string(40),
            'golongan' => $this->string(3),
            'ruang' => $this->string(1),
            'tingkat_sppd' => $this->string(1),
            'status' => $this->smallInteger(1),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
            'PRIMARY KEY ([[kode]])'
        ]);

        $this->addForeignKey('{{%fk-pangkat-cb}}', '{{%pangkat_golongan}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-pangkat-ub}}', '{{%pangkat_golongan}}', 'updated_by', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%pangkat_golongan}}');
    }

}
