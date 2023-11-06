<?php

use yii\helpers\Html;
?>
<li>
    <div class="user-info m-b-20">
        <div class="image">
            <?php echo Html::a(Html::img(Yii::$app->user->identity->getPhotoProfileUrl('thumbnail')?:$assets->baseUrl . '/images/profile_av.jpg', ['alt' => 'User']), ['/user/profile']) ?>
        </div>
        <div class="detail">
            <h6>
                <?php echo Yii::$app->user->identity->username ?>
            </h6>
            <p class="m-b-0"><?php echo Yii::$app->user->identity->allRolesWithLabel ?></p>
<!--            <a href="javascript:void(0);" title="" class=" waves-effect waves-block"><i class="zmdi zmdi-facebook-box"></i></a>
            <a href="javascript:void(0);" title="" class=" waves-effect waves-block"><i class="zmdi zmdi-linkedin-box"></i></a>
            <a href="javascript:void(0);" title="" class=" waves-effect waves-block"><i class="zmdi zmdi-instagram"></i></a>
            <a href="javascript:void(0);" title="" class=" waves-effect waves-block"><i class="zmdi zmdi-twitter-box"></i></a>                            -->
        </div>
    </div>
</li>