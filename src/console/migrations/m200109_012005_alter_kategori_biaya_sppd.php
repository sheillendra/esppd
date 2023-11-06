<?php

use yii\db\Migration;

/**
 * Class m200109_012005_alter_kategori_biaya_sppd
 */
class m200109_012005_alter_kategori_biaya_sppd extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $detailColumn = [
            5 => ['nama_pesawat', 'no_flight', 'kode_booking', 'nomor_tiket', 'jenis_rute']
        ];

        $kategoris = \common\models\KategoriBiayaSppdExt::find()->all();
        foreach ($kategoris as $kategori) {
            if (!isset($detailColumn[(int) $kategori->id])) {
                continue;
            }
            $kategori->detachBehavior(1);
            $kategori->detail_column = $detailColumn[(int) $kategori->id];
            $kategori->updated_by = 2;
            $kategori->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        return true;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m200109_012005_alter_kategori_biaya_sppd cannot be reverted.\n";

      return false;
      }
     */
}
