<?php

namespace backend\controllers;

use Yii;
use common\models\PejabatKeuanganExt;
use backend\models\PejabatKeuanganSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PejabatKeuanganController implements the CRUD actions for PejabatKeuanganExt model.
 */
class PejabatKeuanganController extends Controller {

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
     * Lists all PejabatKeuanganExt models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PejabatKeuanganSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PejabatKeuanganExt model.
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
     * Creates a new PejabatKeuanganExt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PejabatKeuanganExt();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing PejabatKeuanganExt model.
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
     * Deletes an existing PejabatKeuanganExt model.
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
     * Finds the PejabatKeuanganExt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PejabatKeuanganExt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PejabatKeuanganExt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGenerateUser($id) {
        $model = $this->findModel($id);
        if ($model->pegawai->user_id) {
            if ($model->user->can(UserExt::ROLE_ASN)) {
                Yii::$app->session->setFlash('error', 'Pegawai ini sudah mempunyai akun dan dalam kondisi normal');
            } else {
                $this->assignAsn($model->user);
                Yii::$app->session->setFlash('success', 'Pegawai ini sudah mempunyai akun, akun sudah normal kembali.');
            }
        } else {
            $user = UserExt::findOne(['username' => $model->nip]);
            if ($user) {
                $this->existingUser($model, $user);
            } else {
                $this->newUser($model);
            }
        }
        $get = Yii::$app->request->get();
        return $this->redirect(array_merge(['index'], $get));
    }

    /**
     * 
     * @param \common\models\PegawaiExt $model
     * @param \common\models\UserExt $user
     */
    protected function existingUser($model, $user) {
        $model->user_id = $user->id;
        if ($model->save()) {
            if (!$user->can(UserExt::ROLE_ASN)) {
                $this->assignAsn($user);
            }
            Yii::$app->session->setFlash('success', 'Pegawai ini sudah mempunyai akun, akun dan pegawai sudah terhubung kembali.');
        }
    }

    

    protected function assignAsn($user) {
        $authManager = Yii::$app->authManager;
        $asn = $authManager->getRole(UserExt::ROLE_ASN);
        $authManager->assign($asn, $user->id);
        $authManager->invalidateCache();
    }

}
