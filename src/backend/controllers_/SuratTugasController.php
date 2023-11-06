<?php

namespace backend\controllers;

use Yii;
use common\models\SuratTugasExt;
use backend\models\SuratTugasSearch;
use backend\models\PelaksanaTugasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SuratTugasController implements the CRUD actions for SuratTugasExt model.
 */
class SuratTugasController extends Controller {

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
                    'siap-disahkan' => ['POST'],
                    'olah-kembali' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SuratTugasExt models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SuratTugasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SuratTugasExt model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $searchModel = new PelaksanaTugasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['surat_tugas_id' => $id]);

        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new SuratTugasExt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new SuratTugasExt();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing SuratTugasExt model.
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

        if ($model->pejabat_daerah_id) {
            $model->perintahDari = $model->pejabat_daerah_id;
        } elseif ($model->pejabat_struktural_id) {
            $model->perintahDari = $model->pejabat_struktural_id + 500;
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SuratTugasExt model.
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
     * Finds the SuratTugasExt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SuratTugasExt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = SuratTugasExt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 
     * @param int $id
     * @return Respond
     */
    public function actionSiapDisahkan($id) {
        $model = $this->findModel($id);
        $siapDisahkan = $model->siapDisahkan();
        if ($siapDisahkan['success']) {
            Yii::$app->session->setFlash('success', 'Status Surat Tugas berhasil diubah menjadi SIAP DISAHKAN');
        } else {
            Yii::$app->session->setFlash('error', $siapDisahkan['message']);
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionOlahKembali($id) {
        $model = $this->findModel($id);
        $prosesKembali = $model->prosesKembali();
        if ($prosesKembali['success']) {
            Yii::$app->session->setFlash('success', 'Status Surat Tugas berhasil dikembalikan menjadi SEDANG PROSES');
        } else {
            Yii::$app->session->setFlash('error', $prosesKembali['message']);
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionTerbitkan($id) {
        $model = $this->findModel($id);
        if ($model->status === $model::STATUS_PENGESAHAN) {
            $model->status = $model::STATUS_TERBIT;
            $model->save();
            Yii::$app->session->setFlash('success', 'Status Surat Tugas berhasil diubah menjadi TERBIT');
        } else {
            Yii::$app->session->setFlash('warning', 'Surat Tugas harus disiapkan untuk disahkan terlebih dahulu');
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionUploadTtd($id) {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_UPLOAD_TTD;
        if ($model->load(Yii::$app->request->post())) {
            $process = $model->uploadTtd();
            if ($process['success']) {
                Yii::$app->session->setFlash('success', $process['message']);
                return $this->redirect(['view', 'id' => $id]);
            } else {
                Yii::$app->session->setFlash('warning', $process['message']);
            }
        }
        return $this->render('upload-ttd', ['model' => $model]);
    }

    protected function goToViewAfterProcess($id, $process) {
        if ($process['success']) {
            Yii::$app->session->setFlash('success', $process['message']);
        } else {
            Yii::$app->session->setFlash('warning', $process['message']);
        }
        return $this->redirect(['view', 'id' => $id]);
    }

}
