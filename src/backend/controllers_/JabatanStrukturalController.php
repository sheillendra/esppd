<?php

namespace backend\controllers;

use Yii;
use common\models\JabatanStrukturalExt;
use backend\models\JabatanStrukturalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JabatanStrukturalController implements the CRUD actions for JabatanStrukturalExt model.
 */
class JabatanStrukturalController extends Controller {

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
     * Lists all JabatanStrukturalExt models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new JabatanStrukturalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single JabatanStrukturalExt model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $get = Yii::$app->request->get();
        unset($get['id']);
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'get' => $get
        ]);
    }

    /**
     * Creates a new JabatanStrukturalExt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $get = Yii::$app->request->get();

        $model = new JabatanStrukturalExt();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(array_merge(['view', 'id' => $model->id], $get));
        }

        if (isset($get['opd_id'])) {
            $model->opd_id = $get['opd_id'];
        }
        return $this->render('create', [
                    'model' => $model,
                    'get' => $get
        ]);
    }

    /**
     * Updates an existing JabatanStrukturalExt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $get = Yii::$app->request->get();
        unset($get['id']);
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(array_merge(['view', 'id' => $model->id], $get));
        }

        return $this->render('update', [
                    'model' => $model,
                    'get' => $get
        ]);
    }

    /**
     * Deletes an existing JabatanStrukturalExt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        $get = Yii::$app->request->get();
        unset($get['index']);
        return $this->redirect(array_merge(['index'], $get));
    }

    /**
     * Finds the JabatanStrukturalExt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return JabatanStrukturalExt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = JabatanStrukturalExt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
