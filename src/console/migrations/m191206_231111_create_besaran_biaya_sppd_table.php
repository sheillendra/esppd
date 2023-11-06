<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%besaran_biaya_sppd}}`.
 */
class m191206_231111_create_besaran_biaya_sppd_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('{{%besaran_biaya_sppd}}', [
            'id' => $this->primaryKey(),
            'pangkat_golongan_id' => $this->string(2),
            'eselon_id' => $this->string(2),
            'jabatan_daerah_id' => $this->integer(),
            'jabatan_struktural_id' => $this->integer(),
            'jabatan_fungsional_id' => $this->integer(),
            'kategori_wilayah' => $this->integer(1),
            'wilayah_id' => $this->string(12),
            'jenis_biaya_sppd_id' => $this->integer(),
            'jumlah' => $this->decimal(15, 2)->notNull(),
            'produk_hukum_id' => $this->integer(),
            'keterangan' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('{{%fk-bbsppd-pgk}}', '{{%besaran_biaya_sppd}}', 'pangkat_golongan_id', '{{%pangkat_golongan}}', 'kode');
        $this->addForeignKey('{{%fk-bbsppd-esk}}', '{{%besaran_biaya_sppd}}', 'eselon_id', '{{%eselon}}', 'kode');
        $this->addForeignKey('{{%fk-bbsppd-jdi}}', '{{%besaran_biaya_sppd}}', 'jabatan_daerah_id', '{{%jabatan_daerah}}', 'id');
        $this->addForeignKey('{{%fk-bbsppd-jsi}}', '{{%besaran_biaya_sppd}}', 'jabatan_struktural_id', '{{%jabatan_struktural}}', 'id');
        $this->addForeignKey('{{%fk-bbsppd-wi}}', '{{%besaran_biaya_sppd}}', 'wilayah_id', '{{%wilayah}}', 'kode');
        $this->addForeignKey('{{%fk-bbsppd-jbsi}}', '{{%besaran_biaya_sppd}}', 'jenis_biaya_sppd_id', '{{%jenis_biaya_sppd}}', 'id');
        $this->addForeignKey('{{%fk-bbsppd-phi}}', '{{%besaran_biaya_sppd}}', 'produk_hukum_id', '{{%produk_hukum}}', 'id');
        $this->addForeignKey('{{%fk-bbsppd-cb}}', '{{%besaran_biaya_sppd}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('{{%fk-bbsppd-ub}}', '{{%besaran_biaya_sppd}}', 'updated_by', '{{%user}}', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%besaran_biaya_sppd}}');
    }

}
