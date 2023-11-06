<?php

use yii\db\Migration;

/**
 * Class m191231_230038_alter_user_rename_column
 */
class m191231_230038_alter_user_rename_column extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%user}}', 'profile', $this->json());

        $users = \common\models\UserExt::find()->from('{{%user}}')->all();
        if ($users) {
            foreach ($users as $user) {
                $user->profile = unserialize($user->photoProfile);
                $user->save();
            }
        }

        $this->dropColumn('{{%user}}', 'photoProfile');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->addColumn('{{%user}}', 'photoProfile', $this->text());
        $users = \common\models\UserExt::find()->from('{{%user}}')->all();
        if ($users) {
            foreach ($users as $user) {
                $user->photoProfile = serialize($user->profile);
                $user->save();
            }
        }
        $this->dropColumn('{{%user}}', 'profile');
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m191231_230038_alter_user_rename_column cannot be reverted.\n";

      return false;
      }
     */
}
