<?php

namespace backend\controllers;

use Yii;
use common\models\PegawaiExt;
use common\models\UserExt;
use backend\models\PegawaiSearch;
use backend\models\SppdSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PegawaiController implements the CRUD actions for PegawaiExt model.
 */
class PegawaiController extends Controller {

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
                        'roles' => ['adminopd'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all PegawaiExt models.
     * @return mixed
     */
    public function actionIndex() {
        return $this->render('index');
    }

//     /**
//      * Lists all PegawaiExt models.
//      * @return mixed
//      */
//     public function actionIndex() {
//         $searchModel = new PegawaiSearch();
//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//         return $this->render('index', [
//                     'searchModel' => $searchModel,
//                     'dataProvider' => $dataProvider,
//         ]);
//     }

//     /**
//      * Displays a single PegawaiExt model.
//      * @param integer $id
//      * @return mixed
//      * @throws NotFoundHttpException if the model cannot be found
//      */
//     public function actionView($id) {
//         $sppdSearchModel = new SppdSearch();
//         $sppdDataProvider = $sppdSearchModel
//                 ->search(Yii::$app->request->queryParams);
//         $sppdDataProvider->query
//                 ->andWhere(['t1.pegawai_id' => $id]);

//         $get = Yii::$app->request->get();
//         unset($get['id']);
//         return $this->render('view', [
//                     'model' => $this->findModel($id),
//                     'sppdSearchModel' => $sppdSearchModel,
//                     'sppdDataProvider' => $sppdDataProvider,
//                     'get' => $get,
//         ]);
//     }

//     /**
//      * Creates a new PegawaiExt model.
//      * If creation is successful, the browser will be redirected to the 'view' page.
//      * @return mixed
//      */
//     public function actionCreate() {
//         $model = new PegawaiExt();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         }

//         return $this->render('create', [
//                     'model' => $model,
//         ]);
//     }

//     /**
//      * Updates an existing PegawaiExt model.
//      * If update is successful, the browser will be redirected to the 'view' page.
//      * @param integer $id
//      * @return mixed
//      * @throws NotFoundHttpException if the model cannot be found
//      */
//     public function actionUpdate($id) {
//         $model = $this->findModel($id);

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         }

//         return $this->render('update', [
//                     'model' => $model,
//         ]);
//     }

//     /**
//      * Deletes an existing PegawaiExt model.
//      * If deletion is successful, the browser will be redirected to the 'index' page.
//      * @param integer $id
//      * @return mixed
//      * @throws NotFoundHttpException if the model cannot be found
//      */
//     public function actionDelete($id) {
//         $this->findModel($id)->delete();

//         return $this->redirect(['index']);
//     }

//     /**
//      * Finds the PegawaiExt model based on its primary key value.
//      * If the model is not found, a 404 HTTP exception will be thrown.
//      * @param integer $id
//      * @return PegawaiExt the loaded model
//      * @throws NotFoundHttpException if the model cannot be found
//      */
//     protected function findModel($id) {
//         if (($model = PegawaiExt::findOne($id)) !== null) {
//             return $model;
//         }

//         throw new NotFoundHttpException('The requested page does not exist.');
//     }

//     public function actionGenerateUser($id) {
//         $model = $this->findModel($id);
//         if ($model->user && !$model->user->can(UserExt::ROLE_ASN)) {
//             $model->user->assign(UserExt::ROLE_ASN);
//             Yii::$app->session->setFlash('success', 'Akun pegawai ini sudah diberi akses ASN.');
//         } else {
//             $user = UserExt::findOne(['username' => $model->nip]);
//             if ($user) {
//                 $process = $model->existingUser($user);
//             } else {
//                 $process = $model->generateNewUser();
//             }
//         }
//         return $this->redirect(Yii::$app->request->referrer);
//     }

// //
// //    public function actionGenerateUser($id) {
// //        $model = $this->findModel($id);
// //        if ($model->user && !$model->user->can(UserExt::ROLE_ASN)) {
// //            $model->user->assign(UserExt::ROLE_ASN);
// //            Yii::$app->session->setFlash('success', 'Akun pegawai ini sudah diberi akses ASN.');
// //        } else {
// //            $user = UserExt::findOne(['username' => $model->nip]);
// //            if ($user) {
// //                $this->existingUser($model, $user);
// //            } else {
// //                $this->newUser($model);
// //            }
// //        }
// //        $get = Yii::$app->request->get();
// //        return $this->redirect(array_merge(['index'], $get));
// //    }
// //
// //    /**
// //     * 
// //     * @param \common\models\PegawaiExt $model
// //     * @param \common\models\UserExt $user
// //     */
// //    protected function existingUser($model, $user) {
// //        $model->user_id = $user->id;
// //        if ($model->save()) {
// //            $this->assignAsn($user);
// //            Yii::$app->session->setFlash('success'
// //                    , 'Pegawai ini sudah mempunyai akun, akun dan pegawai'
// //                    . ' sudah terhubung kembali.');
// //        }
// //    }
// //
// //    /**
// //     * 
// //     * @param \common\models\PegawaiExt $model
// //     */
// //    protected function newUser($model) {
// //        $password = rand(111111, 999999);
// //        $user = new UserExt();
// //        $user->username = $model->nip;
// //        $user->email = $model->nip . '@haltim.go.id';
// //        $user->setPassword($password);
// //        $user->status = UserExt::STATUS_ACTIVE;
// //        $user->created_at = time();
// //        $user->updated_at = time();
// //        $user->generateAuthKey();
// //        if ($user->save()) {
// //            $model->user_id = $user->id;
// //            $model->save();
// //            $this->assignAsn($user);
// //            Yii::$app->session->setFlash('success'
// //                    , 'Generate akun sukses NIP <kbd>' . $model->nip .
// //                    '</kbd> sebagai username dan password: <kbd>' . $password .
// //                    '</kbd>');
// //        } else {
// //            Yii::$app->session->setFlash('error', $user->getFirstErrors());
// //        }
// //    }
// //
// //    /**
// //     * 
// //     * @param \common\models\UserExt $user
// //     */
// //    protected function assignAsn($user) {
// //        if (!$user->can(UserExt::ROLE_ASN)) {
// //            $authManager = Yii::$app->authManager;
// //            $asn = $authManager->getRole(UserExt::ROLE_ASN);
// //            $authManager->assign($asn, $user->id);
// //            $authManager->invalidateCache();
// //        }
// //    }
}
