<?php

use yii\db\Migration;

/**
 * Class m191227_152618_alter_user_add_access_token
 */
class m191227_152618_alter_user_add_access_token extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'access_token', $this->string());
        $this->addColumn('{{%user}}', 'photoProfile', $this->text());
        $this->createIndex('{{%idx-user-un}}', '{{%user}}', 'username');
        $this->createIndex('{{%idx-user-at}}', '{{%user}}', 'access_token');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('{{%idx-user-at}}', '{{%user}}');
        $this->dropIndex('{{%idx-user-un}}', '{{%user}}');
        $this->dropColumn('{{%user}}', 'access_token');
        $this->dropColumn('{{%user}}', 'photoProfile');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191227_152618_alter_user_add_access_token cannot be reverted.\n";

        return false;
    }
    */
}
