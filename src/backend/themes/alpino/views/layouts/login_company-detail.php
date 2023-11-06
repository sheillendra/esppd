<?php

use yii\helpers\Html;
use sheillendra\alpino\widgets\Menu;
use sheillendra\alpino\assets\AlpinoLoginAsset;

$assets = AlpinoLoginAsset::register($this);
?>
<div class="company_detail">
    <h4 class="logo"><img src="<?php echo Yii::getAlias('@web') ?>/images/logo-putih.png" alt=""> <?php echo Yii::$app->name?></h4>
    <h3><?php echo Html::encode($this->params['title']) ?></h3>
    <p><?php echo nl2br(Html::encode($this->params['description'])) ?></p>
    <div class="footer">
        <?php
        echo Menu::widget([
            'encodeLabels' => false,
            'items' => [
                [
                    'label' => '<i class="zmdi zmdi-collection-item-1"></i> Portal',
                    'url' => Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/'])
                ],
                [
                    'label' => '<i class="zmdi zmdi-collection-item-2"></i> Penduduk',
                    'url' => Yii::$app->urlManagerPenduduk->createAbsoluteUrl(['/'])
                ],
                [
                    'label' => '<i class="zmdi zmdi-collection-item-3"></i> ASN',
                    'url' => Yii::$app->urlManagerAsn->createAbsoluteUrl(['/'])
                ],
                [
                    'label' => '<i class="zmdi zmdi-collection-item-4"></i> Pejabat',
                    'url' => Yii::$app->urlManagerPejabat->createAbsoluteUrl(['/'])
                ],
            ]
        ])
        ?>
    </div>
</div>                    