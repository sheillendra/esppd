<?php

namespace common\grid;

class GridView extends \yii\grid\GridView {

    public $pager = [
        'pageCssClass' => 'btn btn-sm btn-neutral',
        'activePageCssClass' => 'font-weight-bold',
        'disabledPageCssClass' => 'btn btn-sm btn-neutral',
        'prevPageCssClass' => 'btn btn-sm btn-neutral',
        'nextPageCssClass' => 'btn btn-sm btn-neutral',
    ];
    public $dataColumnClass = 'common\grid\DataColumn';

}
