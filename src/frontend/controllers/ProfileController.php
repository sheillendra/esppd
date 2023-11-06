<?php
namespace frontend\controllers;

use yii\web\Controller;

/**
 * Feedback controller
 */
class ProfileController extends Controller
{
    /**
     * Displays feedback.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}
