<?php

use yii\db\Migration;

/**
 * Class m191231_053916_alter_bukti_add_detail
 */
class m191231_053916_alter_bukti_add_detail extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%rincian_biaya_sppd}}', 'detail', $this->json());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%rincian_biaya_sppd}}', 'detail');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191231_053916_alter_bukti_add_detail cannot be reverted.\n";

        return false;
    }
    */
}
