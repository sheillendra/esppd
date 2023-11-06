<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%anggaran_revisi}}`.
 */
class m191220_232927_create_anggaran_revisi_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%anggaran_revisi}}', [
            'id' => $this->primaryKey(),
            'anggaran_id' => $this->integer(),
            'uraian' => $this->string()->notNull(),
            'saldo_awal' => $this->decimal(15, 2),
            'revisi' => $this->decimal(15, 2)->notNull(),
            'saldo_akhir' => $this->decimal(15, 2),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('{{%fk-arev-ai}}', '{{%anggaran_revisi}}', ['[[anggaran_id]]'], '{{%anggaran}}', ['[[id]]']);
        $this->addForeignKey('{{%fk-arev-cb}}', '{{%anggaran_revisi}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-arev-ub}}', '{{%anggaran_revisi}}', 'updated_by', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%anggaran_revisi}}');
    }
}
