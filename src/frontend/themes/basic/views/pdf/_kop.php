<?php
/* @var $model \common\models\SuratTugasExt */
?>
<table cellpadding="0" cellspacing="0" style="width: 100%">
    <?php if ($model->fix_opd_kop_1 === Yii::$app->params['namaKepalaPemerintahan1']): ?>
        <style>
            body {
                font-family: TimesNewRoman, "Times New Roman", Times, Tahoma, sans-serif;
                margin: 5cm 0cm 0cm 0cm;
                text-align: justify;
                background-position: right bottom;
                background-repeat: no-repeat;
            }
        </style>
        <tr>
            <td style="text-align: center"><img width="100" src="<?php echo Yii::$app->urlManager->createAbsoluteUrl('/images/garuda.png') ?>"></td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align: center; text-transform: uppercase"><?php echo $model->fix_opd_kop_1 ?></td>
        </tr>
        <tr>
            <td style="text-align: center; text-transform: uppercase"><?php echo $model->fix_opd_kop_2 ?></td>
        </tr>
        <tr>
            <td style="border-bottom: 2px solid"></td>
        </tr>
    <?php else: ?>
        <tr>
            <td rowspan="6" style="width: 100px; text-align: center"><img width="60" src="<?php echo Yii::$app->urlManager->createAbsoluteUrl('/images/logo.png') ?>"></td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align: center; text-transform: uppercase; font-size: 16px;"><?php echo Yii::$app->params['pemerintah'] ?></td>
        </tr>
        <tr>
            <td style="text-align: center; text-transform: uppercase; font-weight: bold; font-size: 18px;"><?php echo $model->fix_opd_nama ?></td>
        </tr>
        <tr>
            <td style="text-align: center;"><?php echo $model->fix_opd_kop_1 ?></td>
        </tr>
        <tr>
            <td style="text-align: center;"><?php echo $model->fix_opd_kop_2 ?></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td style="border-bottom: 2px solid; font-size: 14px">&nbsp;</td>
            <td style="border-bottom: 2px solid"></td>
        </tr>
    <?php endif; ?>
</table>