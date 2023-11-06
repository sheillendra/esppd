<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pejabat_daerah}}`.
 */
class m191113_172141_create_pejabat_daerah_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%pejabat_daerah}}', [
            'id' => $this->primaryKey(),
            'jabatan_daerah_id' => $this->integer()->notNull(),
            'penduduk_id' => $this->integer()->notNull(),
            'produk_hukum_id' => $this->integer()->notNull(),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('{{%fk-pjabda-jdi}}', '{{%pejabat_daerah}}', 'jabatan_daerah_id', '{{%jabatan_daerah}}', 'id');
        $this->addForeignKey('{{%fk-pjabda-pi}}', '{{%pejabat_daerah}}', 'penduduk_id', '{{%penduduk}}', 'id');
        $this->addForeignKey('{{%fk-pjabda-phi}}', '{{%pejabat_daerah}}', 'produk_hukum_id', '{{%produk_hukum}}', 'id');
        $this->addForeignKey('{{%fk-pjabda-cb}}', '{{%pejabat_daerah}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-pjabda-ub}}', '{{%pejabat_daerah}}', 'updated_by', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%pejabat_daerah}}');
    }

}
