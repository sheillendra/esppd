<?php

namespace backend\controllers;

use Yii;
use common\models\AnggaranRevisiExt;
use backend\models\AnggaranRevisiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AnggaranRevisiController implements the CRUD actions for AnggaranRevisiExt model.
 */
class AnggaranRevisiController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'actions' => ['update', 'delete',],
                        'allow' => false,
                    ],
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
                ],
            ],
        ];
    }

    /**
     * Lists all AnggaranRevisiExt models.
     * 
     * @param int $ai Anggaran ID
     * @return mixed
     */
    public function actionIndex($ai) {
        $searchModel = new AnggaranRevisiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['anggaran_id' => $ai])
                ->orderBy('created_at DESC');

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AnggaranRevisiExt model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AnggaranRevisiExt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param int $ai Anggaran ID
     * @return mixed
     */
    public function actionCreate($ai) {
        $model = new AnggaranRevisiExt();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($model->hasErrors()){
                Yii::error($model->getFirstErrors());
            }
            return $this->redirect(['/anggaran/view', 'id' => $ai]);
        }

        $model->anggaran_id = $ai;
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing AnggaranRevisiExt model.
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
     * Deletes an existing AnggaranRevisiExt model.
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
     * Finds the AnggaranRevisiExt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AnggaranRevisiExt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AnggaranRevisiExt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
