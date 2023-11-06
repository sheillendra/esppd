<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use sheillendra\alpino\assets\AlpinoAsset;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $models yii2tech\config\Item[] */

$this->title = 'General';
$this->params['breadcrumbs'][] = $this->title;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;
$this->params['selectedMenu'] = 'setting-general';
$this->render('@app/views/layouts/menus/setting', ['assets' => $assets]);
$this->params['contentClass'] = 'setting-general';
?>
<?php $form = ActiveForm::begin(); ?>

<?php foreach ($models as $key => $model): ?>
    <?php
    $field = $form->field($model, "[{$key}]value");
    $inputType = ArrayHelper::remove($model->inputOptions, 'type');
    switch ($inputType) {
        case 'checkbox':
            $field->checkbox();
            break;
        case 'textarea':
            $field->textarea();
            break;
        case 'dropDown':
            $field->dropDownList($model->inputOptions['items']);
            break;
    }
    echo $field;
    ?>
<?php endforeach; ?>

<div class="form-group">
    <?php
    echo Html::a('Restore defaults', ['default'], [
        'class' => 'btn btn-danger',
        'data-confirm' => 'Are you sure you want to restore default values?'
    ]);
    ?>
    &nbsp;
    <?php echo Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
</div>

<?php
ActiveForm::end();
