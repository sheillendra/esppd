<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\SppdExt;
use common\models\RincianBiayaSppdExt;
use backend\models\SppdSearch;
use backend\models\SppdRegisterForm;

/**
 * SppdController implements the CRUD actions for SppdExt model.
 */
class SppdController extends Controller {

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
                'class' => 'yii\filters\VerbFilter',
                'actions' => [
                    'delete' => ['POST'],
                    'hitung-biaya' => ['POST'],
                    'hapus-biaya' => ['POST'],
                    'hitung-kembali' => ['POST'],
                    'siap-disahkan' => ['POST'],
                    'terbitkan' => ['POST'],
                    'hitung-rampung' => ['GET', 'POST'],
                    'batal-rampung' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SppdExt models.
     * @param string $rf
     * @param string $time for unique URL if force generate file not cached
     * @return mixed
     */
    public function actionIndex($rf = null, $time = null) {
        $searchModel = new SppdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'rf' => $rf,
                    'time' => $time,
        ]);
    }

    /**
     * Displays a single SppdExt model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $model = $this->findModel($id);

        return $this->render('view', [
                    'model' => $model,
                    'items' => RincianBiayaSppdExt::findBiayaBySppd($id),
        ]);
    }

    /**
     * Creates a new SppdExt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        Yii::$app->session->setFlash('warning'
                , 'SPPD digenerate dari daftar pelaksana surat tugas');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Updates an existing SppdExt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SppdExt model.
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
     * Finds the SppdExt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SppdExt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = SppdExt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 
     * @param int $ptid Pelaksana Tugas ID
     */
    public function actionGenerate($ptid) {
        $sppd = new SppdExt();
        $process = $sppd->generateSppd($ptid);
        if ($process['success']) {
            Yii::$app->session->setFlash('success', $process['message']);
            return $this->redirect(['view', 'id' => $sppd->id]);
        }
        Yii::$app->session->setFlash('error', $process['message']);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionHitungBiaya($id) {
        $model = $this->findModel($id);
        return $this->goToViewAfterProcess($id, $model->hitungBiaya());
    }

    public function actionHapusBiaya($id) {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_HITUNG_BIAYA;
        if ($model->validate()) {
            $model->total_biaya = 0;
            $model->status = $model::STATUS_SEDANG_PROSES;
            $model->fix_tingkat_sppd = null;
            $model->fix_anggaran_opd = null;
            $model->save();
            RincianBiayaSppdExt::deleteAll(['sppd_id' => $id]);
            Yii::$app->session->setFlash('success', 'Hapus biaya SPPD berhasil.');
        } else {
            Yii::$app->session->setFlash('warning', $model->getFirstErrors());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionHitungKembali($id) {
        $model = $this->findModel($id);
        if ($model->status < $model::STATUS_HITUNG_RAMPUNG) {
            $model->total_biaya = 0;
            $model->pdf_filename_biaya_blank = null;
            $model->pdf_filename_biaya_barcode = null;
            $model->pdf_filename_kwitansi_blank = null;
            $model->pdf_filename_kwitansi_barcode = null;
            $model->status = $model::STATUS_HITUNG_BIAYA;
            $model->save();
            Yii::$app->session->setFlash('success', 'Status SPPD berhasil diubah menjadi HITUNG BIAYA');
        } else {
            Yii::$app->session->setFlash('warning', 'Status SPPD harus SIAP DISAHKAN');
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionSiapDisahkan($id) {
        $model = $this->findModel($id);
        return $this->goToViewAfterProcess($id, $model->siapDisahkan());
    }

    public function actionUploadTtd($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            return $this->goToViewAfterProcess($id, $model->uploadTtd());
        }
        return $this->render('upload-ttd', ['model' => $model]);
    }

    public function actionTerbitkan($id) {
        $model = $this->findModel($id);
        return $this->goToViewAfterProcess($id, $model->terbitkan());
    }

    public function actionHitungRampung($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            return $this->goToViewAfterProcess($id, $model->hitungRampung());
        }

        return $this->render('hitung-rampung', ['model' => $model]);
    }

    public function actionBatalRampung($id) {
        $model = $this->findModel($id);
        return $this->goToViewAfterProcess($id, $model->batalRampung());
    }

    public function actionRegister() {
        $model = new SppdRegisterForm();
        //$model->opd_id = 49;
        //$model->dari_tanggal = '2019-12-03';
        //$model->sampai_tanggal = '2020-01-31';
        if ($model->load(Yii::$app->request->post())) {
            $process = $model->generateExcel();
            if ($process['success']) {
                Yii::$app->session->setFlash('success', $process['message']);
                return $this->redirect(['/sppd', 'rf' => $process['registerFile'], 'time' => $process['time']]);
            }
            Yii::$app->session->setFlash('error', $process['message']);
        }
        $model->opd_id = Yii::$app->user->identity->opdAdmin;
        return $this->render('register', [
                    'model' => $model
        ]);
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
