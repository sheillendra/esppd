<?php

exit("This file should not be included, only analyzed by your IDE");

class Yii extends \yii\BaseYii {

    /**
     *
     * @var \local\Application
     */
    public static $app;

}

namespace yii\web {

    /**
     * @property \alexandernst\devicedetect\DeviceDetect $devicedetect Device detect
     * @property \common\components\helpers\DieHelper $debug Debug local tools
     * @property \yii\rbac\DbManager $authManager authManager use dbManager
     * @property \yii\web\UrlManager $urlManagerAdmin URL Manager for AdminApp
     * @property \yii\web\UrlManager $urlManagerApi URL Manager for ApiApp
     * @property \yii\web\UrlManager $urlManagerAsn URL Manager for AsnApp
     * @property \yii\web\UrlManager $urlManagerFrontend URL Manager for FrontendApp
     * @property \yii\web\UrlManager $urlManagerPejabat URL Manager for PejabatApp
     * @property \yii\web\UrlManager $urlManagerPenduduk URL Manager for PendudukApp
     * 
     */
    class Application extends \yii\base\Application {

        public function handleRequest($request) {
            
        }

    }
    
    /**
     * @property \common\models\UserExt $identity Description
     */
    class User extends \yii\web\User {
        
    }
}
