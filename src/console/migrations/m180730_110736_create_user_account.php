<?php

use yii\db\Migration;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;
use common\models\UserExt;

/**
 * Class m180730_110736_create_user_account
 */
class m180730_110736_create_user_account extends Migration {

    /**
     * @throws yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager() {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }

        return $authManager;
    }

    // Use up()/down() to run migration code without a transaction.
    public function safeUp() {
        $authManager = $this->getAuthManager();

        $superadmin = $authManager->createRole(UserExt::ROLE_SUPERADMIN);
        $superadmin->description = 'Superadmin';
        $superadmin->data = ['level' => UserExt::ROLE_SUPERADMIN_LEVEL];
        $authManager->add($superadmin);

        $admin = $authManager->createRole(UserExt::ROLE_ADMIN);
        $admin->description = 'Administrator';
        $admin->data = ['level' => UserExt::ROLE_ADMIN_LEVEL];
        $authManager->add($admin);

        $asn = $authManager->createRole(UserExt::ROLE_ASN);
        $asn->description = 'ASN';
        $asn->data = ['level' => UserExt::ROLE_ASN_LEVEL];
        $authManager->add($asn);

        $adminOpd = $authManager->createRole(UserExt::ROLE_ADMIN_OPD);
        $adminOpd->description = 'Admin tingkat OPD';
        $adminOpd->data = ['level' => UserExt::ROLE_ADMIN_OPD_LEVEL];
        $authManager->add($adminOpd);

        $bendahara = $authManager->createRole(UserExt::ROLE_BENDAHARA_PENGELUARAN);
        $bendahara->description = 'Bendahara Pengeluaran';
        $bendahara->data = ['level' => UserExt::ROLE_BENDAHARA_PENGELUARAN_LEVEL];
        $authManager->add($bendahara);

        $pejabat = $authManager->createRole(UserExt::ROLE_PEJABAT_DAERAH);
        $pejabat->description = 'Pejabat Daerah';
        $pejabat->data = ['level' => UserExt::ROLE_PEJABAT_DAERAH_LEVEL];
        $authManager->add($pejabat);

        $penduduk = $authManager->createRole(UserExt::ROLE_PENDUDUK);
        $penduduk->description = 'Masyarakat umum';
        $penduduk->data = ['level' => UserExt::ROLE_PENDUDUK_LEVEL];
        $authManager->add($penduduk);

        $authManager->addChild($superadmin, $admin);
        $authManager->addChild($superadmin, $asn);
        $authManager->addChild($superadmin, $adminOpd);
        $authManager->addChild($superadmin, $bendahara);
        $authManager->addChild($superadmin, $pejabat);
        $authManager->addChild($superadmin, $penduduk);

        $authManager->addChild($admin, $adminOpd);
        $authManager->addChild($bendahara, $asn);
        $authManager->addChild($pejabat, $penduduk);

        $user = new UserExt();
        $user->id = 1;
        $user->username = 'superadmin';
        $user->email = 'superadmin@example.com';
        $user->setPassword('123456');
        $user->status = UserExt::STATUS_ACTIVE;
        $user->created_at = time();
        $user->updated_at = time();
        $user->generateAuthKey();
        $user->save();

        $authManager->assign($superadmin, $user->id);

        $system = new UserExt();
        $system->id = 2;
        $system->username = 'system';
        $system->email = 'system@example.com';
        $system->setPassword('123456');
        $system->status = UserExt::STATUS_ACTIVE;
        $system->created_at = time();
        $system->updated_at = time();
        $system->generateAuthKey();
        $system->save();
        
        Yii::$app->db->createCommand()->resetSequence('{{%user}}', 3)->execute();
        
        $authManager->assign($superadmin, $system->id);
        $authManager->invalidateCache();
    }

    public function safeDown() {
        $authManager = $this->getAuthManager();
        $authManager->removeAllAssignments();
        $authManager->removeAllRoles();
        $authManager->removeAllPermissions();

        $this->truncateTable('{{%user}}');
    }

}
