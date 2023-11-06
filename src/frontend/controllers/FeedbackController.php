<?php
namespace frontend\controllers;

use yii\web\Controller;

/**
 * Feedback controller
 */
class FeedbackController extends Controller
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
