<?php

namespace backend\controllers;

use Yii;
use common\models\AnggaranExt;
use common\models\TahunAnggaranExt;
use backend\models\AnggaranSearch;
use backend\models\AnggaranRevisiSearch;
use backend\models\SppdSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AnggaranController implements the CRUD actions for AnggaranExt model.
 */
class AnggaranController extends Controller {

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
                ],
            ],
        ];
    }

    /**
     * Lists all AnggaranExt models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AnggaranSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AnggaranExt model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $sppdSearchModel = new SppdSearch();
        $sppdDataProvider = $sppdSearchModel->search(Yii::$app->request->queryParams);
        $sppdDataProvider->query
                ->andWhere(['t0.anggaran_id' => $id])
                ->andWhere(['>', 't0.status', SppdSearch::STATUS_TERBIT])
                ->orderBy('t0.created_at DESC');

        $revisiSearchModel = new AnggaranRevisiSearch();
        $revisiDataProvider = $revisiSearchModel->search(Yii::$app->request->queryParams);
        $revisiDataProvider->query->andWhere(['anggaran_id' => $id])
                ->orderBy('created_at DESC');
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'sppdSearchModel' => $sppdSearchModel,
                    'sppdDataProvider' => $sppdDataProvider,
                    'revisiSearchModel' => $revisiSearchModel,
                    'revisiDataProvider' => $revisiDataProvider,
        ]);
    }

    /**
     * Creates a new AnggaranExt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new AnggaranExt();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->tahun_anggaran_id = TahunAnggaranExt::getTahunBerjalan();
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing AnggaranExt model.
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
     * Deletes an existing AnggaranExt model.
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
     * Finds the AnggaranExt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AnggaranExt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AnggaranExt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
