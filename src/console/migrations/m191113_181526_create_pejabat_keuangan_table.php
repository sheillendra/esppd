<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pejabat_keuangan}}`.
 */
class m191113_181526_create_pejabat_keuangan_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%pejabat_keuangan}}', [
            'id' => $this->primaryKey(),
            'opd_id' => $this->integer()->notNull(),
            'jabatan_keuangan_id' => $this->integer()->notNull(),
            'pegawai_id' => $this->integer()->notNull(),
            'produk_hukum_id' => $this->integer(),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('{{%fk-pjabkeu-oi}}', '{{%pejabat_keuangan}}', 'opd_id', '{{%opd}}', 'id');
        $this->addForeignKey('{{%fk-pjabkeu-jki}}', '{{%pejabat_keuangan}}', 'jabatan_keuangan_id', '{{%jabatan_keuangan}}', 'id');
        $this->addForeignKey('{{%fk-pjabkeu-pi}}', '{{%pejabat_keuangan}}', 'pegawai_id', '{{%pegawai}}', 'id');
        $this->addForeignKey('{{%fk-pjabkeu-phi}}', '{{%pejabat_keuangan}}', 'produk_hukum_id', '{{%produk_hukum}}', 'id');
        $this->addForeignKey('{{%fk-pjabkeu-cb}}', '{{%pejabat_keuangan}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-pjabkeu-ub}}', '{{%pejabat_keuangan}}', 'updated_by', '{{%user}}', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%pejabat_keuangan}}');
    }

}
