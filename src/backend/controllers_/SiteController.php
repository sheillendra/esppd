<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use common\models\SppdExt;
use common\models\PegawaiExt;
use common\models\WilayahExt;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        return $this->redirect(['/pegawai']);
        
        $sppdBulanLalu = SppdExt::getTotalSppd(
                        strtotime('first day of previous month')
                        , strtotime('last day of previous month')
        );

        $sppdBulanIni = SppdExt::getTotalSppd(
                        strtotime('first day of this month')
                        , strtotime('last day of this month')
        );

        $sppdDdBulanLalu = SppdExt::getTotalSppd(
                        strtotime('first day of previous month')
                        , strtotime('last day of previous month')
                        , WilayahExt::KATEGORI_DALAM_DAERAH
        );

        $sppdDdBulanIni = SppdExt::getTotalSppd(
                        strtotime('first day of this month')
                        , strtotime('last day of this month')
                        , WilayahExt::KATEGORI_DALAM_DAERAH
        );

        if ($sppdBulanIni > $sppdBulanLalu) {
            $selisih = $sppdBulanIni - $sppdBulanLalu;
            $percentSppd = 'Meningkat ' . ($selisih / $sppdBulanIni * 100) . '%';
        } elseif ($sppdBulanIni < $sppdBulanLalu) {
            $selisih = $sppdBulanLalu - $sppdBulanIni;
            $percentSppd = 'Menurun ' . ($selisih / $sppdBulanLalu * 100) . '%';
        } else {
            $percentSppd = 'Sama dengan bulan lalu';
        }

        return $this->render('index', [
                    'totalPegawai' => PegawaiExt::getTotalPegawai(),
                    'totalSppd' => SppdExt::getTotalSppd(),
                    'totalSppdDd' => SppdExt::getTotalSppd(null, null, WilayahExt::KATEGORI_DALAM_DAERAH),
                    'percentSppd' => $percentSppd,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
