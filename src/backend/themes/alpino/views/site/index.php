<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use sheillendra\alpino\assets\AlpinoAsset;

$assets = AlpinoAsset::register($this);
$this->params['assets'] = $assets;

$this->params['selectedMenu'] = 'dashboard';
$this->render('@app/views/layouts/menus/dashboard', ['assets' => $assets]);
$this->title = 'Dashboard';
$this->params['contentClass'] = 'home';
$this->params['breadcrumbs'][] = $this->title;

$totalSppdLd = $totalSppd - $totalSppdDd;
?>

<div class="row clearfix">
    <div class="col-lg-3 col-md-6">
        <div class="card text-center">
            <div class="body">
                <p class="m-b-20"><i class="zmdi zmdi-assignment-account zmdi-hc-3x col-amber"></i></p>
                <span>Total Pegawai</span>
                <h3 class="m-b-10">
                    <span class="number count-to" data-from="0"
                          data-to="<?php echo $totalPegawai ?>"
                          data-speed="2000"
                          data-fresh-interval="700">
                              <?php echo $totalPegawai ?>
                    </span>
                </h3>
                <small class="text-muted"><?php echo Html::a('Selengkapnya...', ['/pegawai']) ?></small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card text-center">
            <div class="body">
                <p class="m-b-20"><i class="zmdi zmdi-flag zmdi-hc-3x col-blue"></i></p>
                <span>Total SPPD</span>
                <h3 class="m-b-10 number count-to"
                    data-from="0"
                    data-to="<?php echo $totalSppd ?>"
                    data-speed="2000"
                    data-fresh-interval="700">
                        <?php echo Yii::$app->formatter->asInteger($totalSppd) ?>
                </h3>
                <small class="text-muted"><?php echo Html::a($percentSppd, ['/sppd']) ?></small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card text-center">
            <div class="body">
                <p class="m-b-20"><i class="zmdi zmdi-flag zmdi-hc-3x"></i></p>
                <span>Total Dalam Daerahs</span>
                <h3 class="m-b-10 number count-to"
                    data-from="0" data-to="<?php echo $totalSppdDd ?>"
                    data-speed="2000" data-fresh-interval="700">
                        <?php echo Yii::$app->formatter->asInteger($totalSppdDd) ?>
                </h3>
                <small class="text-muted">Menurun 8%</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card text-center">
            <div class="body">
                <p class="m-b-20"><i class="zmdi zmdi-flag zmdi-hc-3x col-green"></i></p>
                <span>Total Luar Daerah</span>
                <h3 class="m-b-10 number count-to"
                    data-from="0" data-to="<?php echo $totalSppdLd ?>" data-speed="2000"
                    data-fresh-interval="700"><?php echo $totalSppdLd ?></h3>
                <small class="text-muted">Naik 7%</small>
            </div>
        </div>
    </div>
</div>