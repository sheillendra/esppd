<?php

namespace backend\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\caching\TagDependency;
use common\models\InitialDataForm;

class SettingController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['superadmin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'default' => ['POST'],
                    'reset-data' => ['GET', 'POST'],
                    'invalidate-dependency' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Performs batch updated of application configuration records.
     */
    public function actionIndex() {
        /* @var $configManager \yii2tech\config\Manager */
        $configManager = Yii::$app->get('configManager');

        $models = $configManager->getItems();

        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            $configManager->saveValues();
            Yii::$app->session->setFlash('success', 'Configuration updated.');
            return $this->refresh();
        }

        return $this->render('index', [
                    'models' => $models,
        ]);
    }

    /**
     * Restores default values for the application configuration.
     */
    public function actionDefault() {
        /* @var $configManager \yii2tech\config\Manager */
        $configManager = Yii::$app->get('configManager');
        $configManager->clearValues();
        Yii::$app->session->setFlash('success', 'Default values restored.');
        return $this->redirect(['index']);
    }

    public function actionInitialData() {
        $model = new InitialDataForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->fileInit = UploadedFile::getInstance($model, 'fileInit');
            $model->upload();
            return $this->redirect(['/setting/initial-data']);
        }
        return $this->render('initial-data', [
                    'model' => $model,
        ]);
    }

    public function actionResetData() {
        $table = Yii::$app->request->post('table');
        if ($table) {
            try {
                Yii::$app->db->createCommand(strtr('TRUNCATE {{%table}} CASCADE;', ['table' => $table]))->execute();
                Yii::$app->session->setFlash('success', strtr('Reset {table} berhasil', ['{table}' => $table]));
            } catch (\Exception $ex) {
                Yii::$app->session->setFlash('error', $ex->getMessage());
            }
            return $this->redirect(['/setting/reset-data']);
        }
        return $this->render('reset-data');
    }

    public function actionClearTagCache() {
        return $this->render('clear-tag-cache');
    }

    public function actionInvalidateDependency() {
        $tag = Yii::$app->request->post('tag');
        if ($tag) {
            TagDependency::invalidate(Yii::$app->cache, $tag);
            Yii::$app->session->setFlash('success', 'Invalidate dependency with tag ' . 
                    $tag . ' is success');
        } else {
            Yii::$app->session->setFlash('error', 'Tag tidak boleh kosong.');
        }
        return $this->redirect(['/setting/clear-tag-cache']);
    }

    public function actionClearSchemaCache() {
        Yii::$app->getDb()->getSchema()->refresh();
        Yii::$app->session->setFlash('success', 'Refresh / Clear Schema Cache is success');
        return $this->redirect(['/setting/clear-tag-cache']);
    }

    public function actionFlush() {
        $success = Yii::$app->cache->flush();
        if ($success) {
            Yii::$app->session->setFlash('success', 'Flush cache is success');
        } else {
            Yii::$app->session->setFlash('error', 'Flush cache is fail');
        }
        return $this->redirect(['/setting/clear-tag-cache']);
    }

}
