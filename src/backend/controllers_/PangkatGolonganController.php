<?php

namespace backend\controllers;

use Yii;
use common\models\PangkatGolonganExt;
use backend\models\PangkatGolonganSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PangkatGolonganController implements the CRUD actions for PangkatGolonganExt model.
 */
class PangkatGolonganController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
     * Lists all PangkatGolonganExt models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
