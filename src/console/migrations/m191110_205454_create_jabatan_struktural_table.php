<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%jabatan_struktural}}`.
 */
class m191110_205454_create_jabatan_struktural_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%jabatan_struktural}}', [
            'id' => $this->primaryKey(),
            'opd_id' => $this->integer(),
            'nama' => $this->string(),
            'nama_2' => $this->string(),
            'singkatan' => $this->string(20),
            'tingkat_sppd' => $this->string(1),
            'status' => $this->integer(1)->notNull()->defaultValue(1),
            'urutan' => $this->integer(),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('{{%fk-jabstruk-oi}}', '{{%jabatan_struktural}}', 'opd_id', '{{%opd}}', 'id');
        $this->addForeignKey('{{%fk-jabstruk-cb}}', '{{%jabatan_struktural}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-jabstruk-ub}}', '{{%jabatan_struktural}}', 'updated_by', '{{%user}}', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%jabatan_struktural}}');
    }

}
