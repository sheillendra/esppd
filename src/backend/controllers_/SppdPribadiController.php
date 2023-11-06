<?php

namespace backend\controllers;

use yii\web\Controller;

/**
 * SppdPribadiController implements the CRUD actions for SppdExt model.
 */
class SppdPribadiController extends Controller
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
     * Lists all SppdExt models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
