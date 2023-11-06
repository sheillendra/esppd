<?php

namespace backend\controllers;

use Yii;
use common\models\UserExt;
use common\models\ChangePasswordForm;
use common\models\ProfileForm;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for UserExt model.
 */
class UserController extends Controller {

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
                    'reset-password' => ['POST'],
                    'change-password' => ['POST'],
                    'assign' => ['POST'],
                    'change-profile-photo' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserExt models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserExt model.
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
     * Creates a new UserExt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new UserExt();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserExt model.
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
     * Deletes an existing UserExt model.
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
     * Finds the UserExt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserExt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = UserExt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionProfile() {
        /* @var $user \common\models\UserExt */
        $user = Yii::$app->user->getIdentity();
        $jabatan = '-';
        if ($user->pegawaiAsProfile) {
            $nama = $user->pegawaiAsProfile->nama;
            if ($user->pegawaiAsProfile->pejabatStruktural) {
                $jabatan = $user->pegawaiAsProfile->pejabatStruktural->jabatanStruktural->nama_2;
            }
        } elseif ($user->pendudukAsProfile) {
            $nama = $user->pendudukAsProfile->nama;
            if ($user->pendudukAsProfile->pejabatDaerah) {
                $jabatan = $user->pendudukAsProfile->pejabatDaerah->jabatanDaerah->nama_2;
            }
        } else {
            $nama = $user->username;
        }

        $profileForm = new ProfileForm();
        //$profileForm->load($user->profile, '');
        return $this->render('profile', [
                    'nama' => $nama,
                    'jabatan' => $jabatan,
                    'profileForm' => $profileForm,
                    'changePasswordForm' => new ChangePasswordForm(),
        ]);
    }

    public function actionResetUsername($id) {
        $model = $this->findModel($id);
        $oldUsername = $model->username;
        if($model->pegawaiAsProfile){
            $model->username = $model->pegawaiAsProfile->nip;
        }elseif($model->pendudukAsProfile){
            $model->username = $model->pendudukAsProfile->nik;
        }else{
            Yii::$app->session->setFlash('error', 'User bukan pegawai atau penduduk');
            return $this->redirect(Yii::$app->request->referrer);    
        }
        
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'NIP/NIK <kbd>' .
                    $oldUsername . '</kbd> berhasil diganti dengan : <kbd>' .
                    $model->username . '</kbd>');
        } else {
            Yii::$app->session->setFlash('error', $model->getFirstErrors());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionResetPassword($id) {
        $model = $this->findModel($id);
        $password = rand(111111, 999999);
        $model->setPassword($password);
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Reset password <kbd>' .
                    $model->username . '</kbd> berhasil dengan password baru: <kbd>' .
                    $password . '</kbd>');
        } else {
            Yii::$app->session->setFlash('error', $model->getFirstErrors());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionChangePassword() {
        $model = new ChangePasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->change()) {
            Yii::$app->user->logout();
            Yii::$app->getSession()->setFlash('success', 'Ganti password berhasil, silahkan login kembali');
        }
        return $this->redirect(['/user/profile']);
    }

    public function actionAssign($id, $revoke = false) {
        $model = $this->findModel($id);
        $roleName = Yii::$app->request->post('role');
        if ($roleName) {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($roleName);
            if ($role) {
                if ($revoke) {
                    $auth->revoke($role, $model->id);
                    Yii::$app->session->setFlash('success', 'Revoke sukses');
                } else {
                    $auth->assign($role, $model->id);
                    Yii::$app->session->setFlash('success', 'Assign sukses');
                }
                $auth->invalidateCache();
            } else {
                Yii::$app->session->setFlash('error', 'Assign Gagal');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Assign Gagal');
        }
        return $this->redirect(['/user/view', 'id' => $id]);
    }

    public function actionChangeProfilePhoto() {
        $model = new ProfileForm();
        $process = $model->change();
        if ($process['success']) {
            Yii::$app->session->setFlash('success', 'Sukses update photo profile');
        } else {
            Yii::$app->session->setFlash('error', $process['message']);
        }
        return $this->redirect(['/user/profile']);
    }

}
