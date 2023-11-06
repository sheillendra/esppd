<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%jabatan_daerah}}`.
 */
class m191109_190514_create_jabatan_daerah_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%jabatan_daerah}}', [
            'id' => $this->primaryKey(),
            'opd_id' => $this->integer(),
            'nama' => $this->string(100)->notNull(),
            'nama_2' => $this->string(20)->notNull(),
            'tingkat_sppd' => $this->string(20),
            'status' => $this->integer(1)->notNull()->defaultValue(1),
            'urutan' => $this->integer(),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('{{%fk-jabda-oi}}', '{{%jabatan_daerah}}', 'opd_id', '{{%opd}}', 'id');
        $this->addForeignKey('{{%fk-jabda-cb}}', '{{%jabatan_daerah}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-jabda-ub}}', '{{%jabatan_daerah}}', 'updated_by', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%jabatan_daerah}}');
    }

}
