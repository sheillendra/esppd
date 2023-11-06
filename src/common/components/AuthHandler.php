<?php

namespace common\components;

use common\models\AuthExt;
use common\models\UserExt;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use yii\caching\TagDependency;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler {

    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client) {
        $this->client = $client;
    }

    public function handle() {
        $attributes = $this->client->getUserAttributes();
        $email = ArrayHelper::getValue($attributes, 'email');
        $id = ArrayHelper::getValue($attributes, 'id');
        $nickname = ArrayHelper::getValue($attributes, 'login', $email);

        /* @var AuthExt $auth */
        $auth = AuthExt::find()->where([
                    'source' => $this->client->getId(),
                    'source_id' => $id,
                ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) {
                // login
                /* @var UserExt $user */
                $user = $auth->user;
                //$this->updateUserInfo($user);
                Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
            } else {
                // signup
                if ($email !== null && UserExt::find()->where(['email' => $email])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $this->client->getTitle()]),
                    ]);
                } else {
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new UserExt([
                        'username' => $nickname,
                        //'github' => $nickname,
                        'email' => $email,
                        'password' => $password,
                        'status' => UserExt::STATUS_ACTIVE
                    ]);
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();

                    $transaction = UserExt::getDb()->beginTransaction();

                    if ($user->save()) {
                        $auth = new AuthExt([
                            'user_id' => $user->id,
                            'source' => $this->client->getId(),
                            'source_id' => (string) $id,
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            TagDependency::invalidate(Yii::$app->cache, 'user');
                            TagDependency::invalidate(Yii::$app->authManager->cache, Yii::$app->authManager->cacheKey);
                            Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
                        } else {
                            Yii::$app->getSession()->setFlash('error', [
                                Yii::t('app', 'Unable to save {client} account: {errors}', [
                                    'client' => $this->client->getTitle(),
                                    'errors' => json_encode($auth->getErrors()),
                                ]),
                            ]);
                        }
                    } else {
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', 'Unable to save user: {errors}', [
                                'client' => $this->client->getTitle(),
                                'errors' => json_encode($user->getErrors()),
                            ]),
                        ]);
                    }
                }
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = new AuthExt([
                    'user_id' => Yii::$app->user->id,
                    'source' => $this->client->getId(),
                    'source_id' => (string) $attributes['id'],
                ]);
                if ($auth->save()) {
                    /** @var UserExt $user */
                    $user = $auth->user;
                    //$this->updateUserInfo($user);
                    Yii::$app->getSession()->setFlash('success', [
                        Yii::t('app', 'Linked {client} account.', [
                            'client' => $this->client->getTitle()
                        ]),
                    ]);
                } else {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', 'Unable to link {client} account: {errors}', [
                            'client' => $this->client->getTitle(),
                            'errors' => json_encode($auth->getErrors()),
                        ]),
                    ]);
                }
            } else { // there's existing auth
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app', 'Unable to link {client} account. There is another user using it.', ['client' => $this->client->getTitle()]),
                ]);
            }
        }
    }

    /**
     * @param UserExt $user
     */
    private function updateUserInfo(UserExt $user) {
        $attributes = $this->client->getUserAttributes();
        $github = ArrayHelper::getValue($attributes, 'login');
        if ($user->github === null && $github) {
            $user->github = $github;
            $user->save();
        }
    }

}
