<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%wilayah}}`.
 */
class m191103_220925_create_wilayah_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%wilayah}}', [
            'kode' => $this->string(12),
            'kode_induk' => $this->string(12),
            'kode_kemendagri' => $this->string(10),
            'nama' => $this->string(150),
            'ibukota' => $this->integer(1),
            'level' => $this->integer(1)->comment('1: desa; 2: kecamatan; 3: kabupaten/kota; 4: provinsi; 5. negara'),
            'kategori' => $this->integer(1)->comment('0: induk 1: dalam daerah; 2: satu provinsi; 3: luar provinsi 4: luar negeri'),
            'keterangan' => $this->text(),
            'status' => $this->integer(1)->defaultValue(1),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
            'PRIMARY KEY ([[kode]])'
        ]);
        
        $this->addForeignKey('{{%fk-tjsppd-ki}}', '{{%wilayah}}', 'kode_induk', '{{%wilayah}}', 'kode');
        $this->addForeignKey('{{%fk-tjsppd-cb}}', '{{%wilayah}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-tjsppd-ub}}', '{{%wilayah}}', 'updated_by', '{{%user}}', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%wilayah}}');
    }

}
