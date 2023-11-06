<?php

namespace backend\controllers;

use Yii;
use common\models\PelaksanaTugasExt;
use backend\models\PelaksanaTugasSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\SuratTugasExt;

/**
 * PelaksanaTugasController implements the CRUD actions for PelaksanaTugasExt model.
 */
class PelaksanaTugasController extends Controller {

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
     * Lists all PelaksanaTugasExt models.
     * @return mixed
     */
    public function actionIndex($stid) {
        $searchModel = new PelaksanaTugasSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['surat_tugas_id' => $stid]);

        $this->layout = '//frame';

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'stid' => $stid,
                    'suratTugas' => SuratTugasExt::findOne(['id' => $stid]),
        ]);
    }

    /**
     * Creates a new PelaksanaTugasExt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($stid) {
        $model = new PelaksanaTugasExt();

        if ($model->load(Yii::$app->request->post())) {
            $process = $model->tambah();
            if ($process['success']) {
                Yii::$app->session->setFlash('success', $process['message']);
                return $this->redirect(['/surat-tugas/view', 'id' => $model->surat_tugas_id]);
            }
            Yii::$app->session->setFlash('error', $process['message']);
        }

        $model->surat_tugas_id = $stid;
        return $this->render('create', ['model' => $model]);
    }

    /**
     * Deletes an existing PelaksanaTugasExt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Hapus pelaksana tugas berhasil');
        } else {
            Yii::$app->session->setFlash('error', 'Hapus pelaksana tugas gagal');
            Yii::error($model->getFirstErrors());
        }
        return $this->redirect(['/surat-tugas/view', 'id' => $model->suratTugas->id]);
    }

    /**
     * Finds the PelaksanaTugasExt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PelaksanaTugasExt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PelaksanaTugasExt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
