<?php

use yii\db\Migration;

/**
 * Class m191229_023131_alter_opd_add_parent
 */
class m191229_023131_alter_opd_add_parent extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%opd}}', 'induk_id', $this->integer());
        $this->addForeignKey('{{%fk-opd-induk}}', '{{%opd}}', 'induk_id', '{{%opd}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-opd-induk}}', '{{%opd}}');
        $this->dropColumn('{{%opd}}', 'induk_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191229_023131_alter_opd_add_parent cannot be reverted.\n";

        return false;
    }
    */
}
