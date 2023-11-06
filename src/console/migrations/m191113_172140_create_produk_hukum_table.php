<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%produk_hukum}}`.
 */
class m191113_172140_create_produk_hukum_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%produk_hukum}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string(),
            'tentang' => $this->text(),
            'pdf_url' => $this->string(),
            'pdf_lampiran_url' => $this->string(),
            'is_anggaran' => $this->boolean(),
            'public' => $this->tinyInteger(1),
            'status' => $this->tinyInteger(1)->defaultValue(1),
            'keterangan' => $this->string(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('{{%fk-prodhuk-cb}}', '{{%produk_hukum}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-prodhuk-ub}}', '{{%produk_hukum}}', 'updated_by', '{{%user}}', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%produk_hukum}}');
    }

}
