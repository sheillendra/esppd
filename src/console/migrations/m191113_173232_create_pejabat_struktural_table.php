<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pejabat_struktural}}`.
 */
class m191113_173232_create_pejabat_struktural_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%pejabat_struktural}}', [
            'id' => $this->primaryKey(),
            'jabatan_struktural_id' => $this->integer()->notNull(),
            'pegawai_id' => $this->integer()->notNull(),
            'produk_hukum_id' => $this->integer()->notNull(),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('{{%fk-pjabstruk-jsi}}', '{{%pejabat_struktural}}', 'jabatan_struktural_id', '{{%jabatan_struktural}}', 'id');
        $this->addForeignKey('{{%fk-pjabstruk-pi}}', '{{%pejabat_struktural}}', 'pegawai_id', '{{%pegawai}}', 'id');
        $this->addForeignKey('{{%fk-pjabstruk-phi}}', '{{%pejabat_struktural}}', 'produk_hukum_id', '{{%produk_hukum}}', 'id');
        $this->addForeignKey('{{%fk-pjabstruk-cb}}', '{{%pejabat_struktural}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-pjabstruk-ub}}', '{{%pejabat_struktural}}', 'updated_by', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%pejabat_struktural}}');
    }

}
