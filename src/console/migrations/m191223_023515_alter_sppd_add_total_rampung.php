<?php

use yii\db\Migration;

/**
 * Class m191223_023515_alter_sppd_add_total_rampung
 */
class m191223_023515_alter_sppd_add_total_rampung extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sppd}}', 'total_bukti', $this->decimal(15,2)->after('total_biaya'));
        $this->addColumn('{{%sppd}}', 'pdf_url_sppd_ttd', $this->string()->after('pdf_filename_sppd_ttd'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sppd}}', 'total_bukti');
        $this->dropColumn('{{%sppd}}', 'pdf_url_sppd_ttd');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191223_023515_alter_sppd_add_total_rampung cannot be reverted.\n";

        return false;
    }
    */
}
