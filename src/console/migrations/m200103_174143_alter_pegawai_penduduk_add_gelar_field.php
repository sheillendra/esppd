<?php

use yii\db\Migration;

/**
 * Class m200103_174143_alter_pegawai_penduduk_add_gelar_field
 */
class m200103_174143_alter_pegawai_penduduk_add_gelar_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%pegawai}}', 'nama_tanpa_gelar', $this->string(100));
        $this->addColumn('{{%pegawai}}', 'gelar_depan', $this->string(20));
        $this->addColumn('{{%pegawai}}', 'gelar_belakang', $this->string(20));
        $this->addColumn('{{%penduduk}}', 'nama_tanpa_gelar', $this->string(100));
        $this->addColumn('{{%penduduk}}', 'gelar_depan', $this->string(20));
        $this->addColumn('{{%penduduk}}', 'gelar_belakang', $this->string(20));
        
        $this->execute('UPDATE {{%pegawai}} SET "nama_tanpa_gelar" = "nama" WHERE true');
        $this->execute('UPDATE {{%penduduk}} SET "nama_tanpa_gelar" = "nama" WHERE true');
        
        $this->dropColumn('{{%pegawai}}', 'nama');
        $this->dropColumn('{{%penduduk}}', 'nama');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%pegawai}}', 'nama', $this->string(100));
        $this->addColumn('{{%penduduk}}', 'nama', $this->string(100));
        
        $this->execute('UPDATE {{%pegawai}} SET "nama" = COALESCE(COALESCE("gelar_depan" || \' \'), \'\') || "nama_tanpa_gelar" || COALESCE(COALESCE(\', \' || "gelar_belakang"), \'\') WHERE true');
        $this->execute('UPDATE {{%penduduk}} SET "nama" = COALESCE(COALESCE("gelar_depan" || \' \'), \'\') || "nama_tanpa_gelar" || COALESCE(COALESCE(\', \' || "gelar_belakang"), \'\') WHERE true');
        
        $this->dropColumn('{{%pegawai}}', 'nama_tanpa_gelar');
        $this->dropColumn('{{%pegawai}}', 'gelar_depan');
        $this->dropColumn('{{%pegawai}}', 'gelar_belakang');
        $this->dropColumn('{{%penduduk}}', 'nama_tanpa_gelar');
        $this->dropColumn('{{%penduduk}}', 'gelar_depan');
        $this->dropColumn('{{%penduduk}}', 'gelar_belakang');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200103_174143_alter_pegawai_penduduk_add_gelar_field cannot be reverted.\n";

        return false;
    }
    */
}
