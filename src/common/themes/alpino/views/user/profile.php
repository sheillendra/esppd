<?php

use yii\helpers\Html;
use common\widgets\ActiveForm;
use sheillendra\alpino\assets\AlpinoProfileAsset;
use sheillendra\cropper\Cropper;

/* @var $this \yii\web\View */

$assets = AlpinoProfileAsset::register($this);
$this->params['assets'] = $assets;

$this->title = 'Profil';
$this->params['selectedMenu'] = 'profile';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->params['contentClass'] = 'profile-page';
?>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="body bg-dark profile-header">
                <div class="row">
                    <div class="col-md-12">
                        <img src="<?php echo Yii::$app->user->identity->photoProfileUrl ?: $assets->baseUrl . '/images/profile_av.jpg' ?>" class="user_pic rounded img-raised" alt="User">
                        <div class="detail">
                            <div class="u_name">
                                <h4><strong><?php echo $nama ?></strong></h4>
                                <span><?php echo $jabatan ?></span>
                            </div>
                            <div style="min-height: 200px"></div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav nav-tabs profile_tab">
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#photoprofile">Photo profil</a></li>
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#usersettings">Setting</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane" id="photoprofile">
                <div class="card">
                    <div class="header">
                        <h2><strong>Photo</strong> profil</h2>
                    </div>
                    <div class="body">
                        <?php
                        $form = ActiveForm::begin([
                            'action' => ['/user/change-profile-photo'],
                            'options' => [
                                'autocomplete' => 'off'
                            ]
                        ]);
                        ?>
                        <?php
                        echo $form->field($profileForm, 'cropper')->widget(Cropper::class, [
                            'serviceName' => 'local',
                            'hiddenUrlInput' => false,
                            'options' => ['class' => 'form-control']
                        ]);
                        ?>
                        <div class="form-group">
                            <?php echo Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane active" id="usersettings">
                <div class="card">
                    <div class="header">
                        <h2>Setting <strong>Keamanan</strong></h2>
                    </div>
                    <div class="body">
                        <?php
                        $form = ActiveForm::begin([
                            'action' => ['/user/change-password'],
                            'options' => [
                                'autocomplete' => 'off'
                            ]
                        ]);
                        ?>

                        <?php echo $form->field($changePasswordForm, 'oldPassword')->passwordInput() ?>
                        <?php echo $form->field($changePasswordForm, 'newPassword')->passwordInput() ?>
                        <?php echo $form->field($changePasswordForm, 'repeatPassword')->passwordInput() ?>

                        <div class="form-group">
                            <?php echo Html::submitButton('Simpan perubahan', ['class' => 'btn btn-success']) ?>
                        </div>
                        <!--                        <div class="form-group">
                                                    <input type="password" class="form-control" placeholder="Current Password" name="current-password" >
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control" placeholder="New Password" name="new-password">
                                                </div>
                                                <button class="btn btn-info btn-round">Save Changes</button>                               -->
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJsVar(
    'uploadUrl',
    Yii::$app->urlManagerApi->createAbsoluteUrl(['/v1/user/upload-profile-photo', 'access-token' => Yii::$app->user->identity->access_token], '')
);

$this->registerCss(<<<CSS
.cropper-crop-box, .cropper-view-box {
    border-radius: 50%;
}
.cropper-view-box {
    box-shadow: 0 0 0 1px #39f;
    outline: 0;
}
.cropper-face {
  background-color:inherit !important;
}

.cropper-dashed, .cropper-line {
  display:none !important;
}
.cropper-view-box {
  outline:inherit !important;
}

.cropper-point.point-se {
  top: calc(85% + 1px);
  right: 14%;
  width: 5px;
  height: 5px;
}
.cropper-point.point-sw {
  top: calc(85% + 1px);
  left: 14%;
}
.cropper-point.point-nw {
  top: calc(15% - 5px);
  left: 14%;
}
.cropper-point.point-ne {
  top: calc(15% - 5px);
  right: 14%;
}
CSS);
