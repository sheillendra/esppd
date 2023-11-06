<?php

use yii\db\Migration;

/**
 * Class m191231_225057_alter_kategori_biaya_sppd_add_detail_column
 */
class m191231_225057_alter_kategori_biaya_sppd_add_detail_column extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%kategori_biaya_sppd}}', 'detail_column', $this->json());

        $detailColumn = [
            3 => ['nama_hotel', 'nomor_kamar', 'kelas_kamar'],
            5 => ['nama_pesawat', 'no_flight', 'kode_booking', 'nomor_tiket',]
        ];

        $kategoris = \common\models\KategoriBiayaSppdExt::find()->all();
        foreach ($kategoris as $kategori) {
            if (!isset($detailColumn[(int) $kategori->id])) {
                continue;
            }
            $kategori->detachBehavior(1);
            $kategori->detail_column = $detailColumn[(int) $kategori->id];
            $kategori->updated_at = 2;
            $kategori->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn('{{%kategori_biaya_sppd}}', 'detail_column');
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m191231_225057_alter_kategori_biaya_sppd_add_detail_column cannot be reverted.\n";

      return false;
      }
     */
}
