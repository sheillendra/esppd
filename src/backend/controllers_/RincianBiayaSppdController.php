<?php

namespace backend\controllers;

use Yii;
use common\models\RincianBiayaSppdExt;
use backend\models\RincianBiayaSppdSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * RincianBiayaSppdController implements the CRUD actions for RincianBiayaSppdExt model.
 */
class RincianBiayaSppdController extends Controller {

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
                    'biaya-riil' => ['POST'],
                    'biaya-non-riil' => ['POST'],
                    'update-total-bukti' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all RincianBiayaSppdExt models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new RincianBiayaSppdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RincianBiayaSppdExt model.
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
     * Creates a new RincianBiayaSppdExt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($sid, $kid) {
        $model = new RincianBiayaSppdExt();

        if ($model->load(Yii::$app->request->post())) {
            $process = $model->tambah();
            if ($process['success']) {
                Yii::$app->session->setFlash('success', $process['message']);
                return $this->redirect(['/sppd/view', 'id' => $sid]);
            }
            Yii::$app->session->setFlash('error', $process['message']);
        } else {
            $model->sppd_id = $sid;
            $model->kategori_biaya_id = $kid;
            $model->volume = 1;
            if ($kid == 1) {
                $model->satuan_id = 5;
            } elseif ($kid == 3 || $kid == 4) {
                $model->satuan_id = 2;
            } elseif ($kid == 5) {
                $model->satuan_id = 3;
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing RincianBiayaSppdExt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/sppd/view', 'id' => $model->sppd_id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RincianBiayaSppdExt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Hapus biaya sukses.');
        } else {
            Yii::$app->session->setFlash('error', $model->getFirstErrors());
        }
        return $this->redirect(['/sppd/view', 'id' => $model->sppd_id]);
    }

    /**
     * Finds the RincianBiayaSppdExt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RincianBiayaSppdExt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = RincianBiayaSppdExt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Set biaya sebagai biaya riil
     * 
     * @param int $id
     */
    public function actionBiayaRiil($id) {
        $model = $this->findModel($id);
        if ($model) {
            $model->riil = 1;
            $model->save();
            Yii::$app->session->setFlash('success', 'Biaya ini sudah menjadi biaya riil');
            return $this->redirect(['/sppd/view', 'id' => $model->sppd_id]);
        }
    }

    /**
     * Set biaya sebagai biaya riil
     * 
     * @param int $id
     */
    public function actionBiayaNonRiil($id) {
        $model = $this->findModel($id);
        if ($model) {
            $model->riil = null;
            $model->save();
            Yii::$app->session->setFlash('success', 'Biaya ini sudah TIDAK menjadi biaya RIIL');
            return $this->redirect(['/sppd/view', 'id' => $model->sppd_id]);
        }
    }

    public function actionUploadBukti($id) {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_UPLOAD_BUKTI;
        if ($model->load(Yii::$app->request->post())) {
            $model->pdfBuktiFile = UploadedFile::getInstance($model, 'pdfBuktiFile');
            if ($model->upload()) {
                Yii::$app->session->setFlash('success', 'Bukti berhasil diupload');
                return $this->redirect(['/sppd/view', 'id' => $model->sppd_id]);
            }
        }

        return $this->render('upload-bukti', ['model' => $model]);
    }

    public function actionUpdateTotalBukti($id) {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_UPDATE_TOTAL_BUKTI;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Update total bukti success');
            } else {
                Yii::$app->session->setFlash('error', $model->getFirstErrors());
            }
            return $this->redirect(['/sppd/view', 'id' => $model->sppd_id]);
        }
        Yii::$app->session->setFlash('error', 'Rincian Biaya tidak ditemukan');
        return $this->redirect(Yii::$app->request->referrer);
    }

}
