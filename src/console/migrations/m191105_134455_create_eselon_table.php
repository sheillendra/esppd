<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%eselon}}`.
 */
class m191105_134455_create_eselon_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%eselon}}', [
            'kode' => $this->string(2),
            'eselon' => $this->string(20),
            'pangkat_min_id' => $this->string(2),
            'pangkat_max_id' => $this->string(2),
            'tingkat_sppd' => $this->string(1),
            'status' => $this->smallInteger(1),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
            'PRIMARY KEY ([[kode]])'
        ]);

        $this->addForeignKey('{{%fk-eselon-pmin}}', '{{%eselon}}', '[[pangkat_min_id]]', '{{%pangkat_golongan}}', '[[kode]]');
        $this->addForeignKey('{{%fk-eselon-pmax}}', '{{%eselon}}', '[[pangkat_max_id]]', '{{%pangkat_golongan}}', '[[kode]]');
        $this->addForeignKey('{{%fk-eselon-cb}}', '{{%eselon}}', '[[created_by]]', '{{%user}}', '[[id]]');
        $this->addForeignKey('{{%fk-eselon-ub}}', '{{%eselon}}', '[[updated_by]]', '{{%user}}', '[[id]]');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%eselon}}');
    }

}
