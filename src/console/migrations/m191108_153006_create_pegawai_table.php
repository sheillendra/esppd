<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pegawai}}`.
 */
class m191108_153006_create_pegawai_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%pegawai}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'nama' => $this->string(100)->notNull(),
            'nip' => $this->string(20)->notNull(),
            'pangkat_golongan_id' => $this->string(2)->notNull(),
            'eselon_id' => $this->string(2),
            'opd_id' => $this->integer()->notNull(),
            'status' => $this->integer(1)->defaultValue(1),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('{{%fk-pegawai-ui}}', '{{%pegawai}}', 'user_id', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-pegawai-pk}}', '{{%pegawai}}', 'pangkat_golongan_id', '{{%pangkat_golongan}}', 'kode');
        $this->addForeignKey('{{%fk-pegawai-ek}}', '{{%pegawai}}', 'eselon_id', '{{%eselon}}', 'kode');
        $this->addForeignKey('{{%fk-pegawai-oi}}', '{{%pegawai}}', 'opd_id', '{{%opd}}', 'id');
        $this->addForeignKey('{{%fk-pegawai-cb}}', '{{%pegawai}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-pegawai-ub}}', '{{%pegawai}}', 'updated_by', '{{%user}}', 'id');
        
        $this->createIndex('{{%idx-pegawai-ui}}', '{{%pegawai}}', 'user_id');
  
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%pegawai}} 

        ');
    }

}
