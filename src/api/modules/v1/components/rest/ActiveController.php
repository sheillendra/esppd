<?php

namespace api\modules\v1\components\rest;

class ActiveController extends \yii\rest\ActiveController
{

    public $allowRoles = '@';
    public $searchModelClass;
    public function behaviors()
    {

        return array_merge(parent::behaviors(), [
            'authenticator' => [
                'class' => \yii\filters\auth\QueryParamAuth::class,
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [$this->allowRoles],
                    ],
                ]
            ],
            'corsFilter' => \yii\filters\Cors::class
        ]);
    }

    protected function verbs()
    {
        $verbs = parent::verbs();
        $verbs['update'][] = 'POST';
        $verbs['delete'][] = 'POST';
        return $verbs;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider() {
        $searchModel = new $this->searchModelClass();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
