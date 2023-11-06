<?php

use yii\db\Migration;

/**
 * Class m200113_024250_alter_session_add_user_id_in_session
 */
class m200113_024250_alter_session_add_user_id_in_session extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%session}}', 'user_id', $this->integer());
        $this->addColumn('{{%session}}', 'last_write', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%session}}', 'user_id');
        $this->dropColumn('{{%session}}', 'last_write');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200113_024250_alter_session_add_user_id_in_session cannot be reverted.\n";

        return false;
    }
    */
}
