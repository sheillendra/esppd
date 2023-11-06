<?php

namespace backend\controllers;

use common\models\UserExt;
use backend\components\web\Controller;

class SettingController extends Controller
{

    public $allowRoles = UserExt::ROLE_SUPERADMIN;

    public function actionInitialData()
    {
        return $this->render('initial-data');
    }
}
