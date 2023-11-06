<?php

namespace backend\controllers;

use Yii;
use common\models\PejabatDaerahExt;
use backend\models\PejabatDaerahSearch;
use backend\models\SppdSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PejabatDaerahController implements the CRUD actions for PejabatDaerahExt model.
 */
class PejabatDaerahController extends Controller {

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
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'generate-user' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PejabatDaerahExt models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PejabatDaerahSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PejabatDaerahExt model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $sppdSearchModel = new SppdSearch();
        $sppdDataProvider = $sppdSearchModel->search(Yii::$app->request->queryParams);
        $sppdDataProvider->query
                ->andWhere(['t1.penduduk_id' => $id]);
        
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'sppdSearchModel' => $sppdSearchModel,
                    'sppdDataProvider' => $sppdDataProvider,
        ]);
    }

    /**
     * Creates a new PejabatDaerahExt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PejabatDaerahExt();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing PejabatDaerahExt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PejabatDaerahExt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PejabatDaerahExt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PejabatDaerahExt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PejabatDaerahExt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGenerateUser($id) {
        $model = $this->findModel($id);
        $process = $model->generateUser();
        Yii::$app->session->setFlash($process['success'] ? 'success' : 'error'
                , $process['message']);
        return $this->redirect(['/pejabat-daerah']);
    }

}
