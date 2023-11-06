<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\themes\basic\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">

<head>
    <meta charset="<?php echo Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo $this->registerLinkTag(['href' => Yii::getAlias('@web') . '/images/favicon.png', 'rel' => 'icon', 'sizes' => '32x32', 'type' => 'image/png']) ?>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?php echo Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => Html::img(Yii::getAlias('@web') . '/favicon.png', ['style' => 'float: left; margin-top: -5px;']) . Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        $menuItems = [
            ['label' => 'Beranda', 'url' => ['/site/index']],
            ['label' => 'Profil', 'url' => ['/profile']],
            ['label' => 'Kontak', 'url' => ['/site/contact']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = [
                'label' => 'Login',
                'options' => ['class' => 'bg-red'],
                'url' => ['/akun']
            ];
        } else {
            $menuItems[] = [
                'label' => 'Akun',
                'options' => ['class' => 'bg-red'],
                'url' => ['/akun']
            ];
            $menuItems[] = '<li>'
                . Html::beginForm(['/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>';
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>

        <div class="container">
            <?php
            echo
            Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ])
            ?>
            <?php echo Alert::widget() ?>
            <?php echo $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; <?php echo Html::encode(Yii::$app->name) ?> <?php echo date('Y') ?></p>

            <p class="pull-right"><?php // echo Yii::powered()   
                                    ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>