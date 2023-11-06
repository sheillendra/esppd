<?php

namespace common\grid;

use Yii;
use yii\helpers\Html;
use yii\helpers\Inflector;
use common\models\OpdExt;
use common\models\PangkatGolonganExt;
use common\models\PegawaiExt;

class DataColumn extends \yii\grid\DataColumn {

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index) {
        if ($this->content === null) {
            if (method_exists($this, $this->format . 'Content')) {
                return $this->{$this->format . 'Content'}($model, $key, $index);
            }
            return $this->grid->formatter->format(
                            $this->getDataCellValue($model, $key, $index)
                            , $this->format);
        }

        return parent::renderDataCellContent($model, $key, $index);
    }

    public function toviewContent($model, $key, $index) {
        /* @var $model \common\models\WilayahExt */
        $params = is_array($key) ? $key : ['id' => (string) $key];
        $params[0] = 'view';
        return Html::a($this->getDataCellValue($model, $key, $index), $params);
    }

    /**
     * {@inheritdoc}
     */
    protected function renderFilterCellContent() {
        if (is_string($this->filter)) {
            return $this->filter;
        }

        $model = $this->grid->filterModel;


        if ($model->hasErrors($this->attribute)) {
            Html::addCssClass($this->filterOptions, 'has-error');
            $error = ' ' . Html::error($model, $this->attribute
                            , $this->grid->filterErrorOptions);
        } else {
            $error = '';
        }

        if (is_array($this->filter)) {
            $options = array_merge(['prompt' => ''], $this->filterInputOptions);
            return Html::activeDropDownList($model, $this->attribute
                            , $this->filter, $options) . $error;
        } elseif (method_exists($this, $this->format . 'Filter')) {
            return $this->{$this->format . 'Filter'}($model, $error);
        }

        if ($this->filter !== false && $model instanceof Model &&
                $this->attribute !== null &&
                $model->isAttributeActive($this->attribute)) {
            return Html::activeTextInput($model, $this->attribute
                            , $this->filterInputOptions) . $error;
        }
        return parent::renderFilterCellContent();
    }

    public function activeFilter($model, $error) {
        $attribute = $this->attribute;
        if ($attribute === 'status') {
            $attribute .= '_active';
        }

        $options = array_merge($this->filterInputOptions, [
            'id' => $attribute, 'prompt' => 'Pilih semua']);
        $this->pjaxReinit($attribute);
        return Html::activeDropDownList($model, $this->attribute
                        , $this->grid->formatter->activeFormat
                        , $options) . $error;
    }

    public function booleanFilter($model, $error) {
        $options = array_merge($this->filterInputOptions, [
            'id' => $this->attribute, 'prompt' => 'Pilih semua']);
        $this->pjaxReinit();
        return Html::activeDropDownList($model, $this->attribute, [
                    1 => $this->grid->formatter->booleanFormat[1],
                    0 => $this->grid->formatter->booleanFormat[0],
                        ], $options) . $error;
    }

    public function eselonFilter($model, $error) {
        $options = array_merge($this->filterInputOptions, [
            'id' => $this->attribute, 'prompt' => 'Pilih semua']);
        $this->pjaxReinit();
        return Html::activeDropDownList($model, $this->attribute
                        , \common\models\EselonExt::dataList()
                        , $options) . $error;
    }

    public function genderFilter($model, $error) {
        $options = array_merge($this->filterInputOptions, [
            'id' => $this->attribute, 'prompt' => 'Pilih semua']);
        $this->pjaxReinit();
        return Html::activeDropDownList($model, $this->attribute
                        , $this->grid->formatter->genderFormat
                        , $options) . $error;
    }
    
    public function jabatanDaerahFilter($model, $error) {
        $options = array_merge(
                $this->filterInputOptions
                , [
            'id' => $this->attribute,
            'prompt' => 'Semua Jabatan'
            , 'data' => ['live-search' => 'true']
                //, 'options' => PegawaiExt::dataListOptions()
        ]);

        $this->ajaxBootstrapSelect([
            'name' => 'jabatan-daerah',
            'searchField' => 'nama',
        ]);

        $defaultData = [];
        $id = $model->{$this->attribute};
        if ($model->{$this->attribute}) {
            $defaultData = [$id => $this->grid->formatter->asJabatanDaerah($id)];
        }
        return Html::activeDropDownList($model
                        , $this->attribute, $defaultData, $options) . $error;
    }
    
    public function jabatanStrukturalFilter($model, $error) {
        $options = array_merge(
                $this->filterInputOptions
                , [
            'id' => $this->attribute,
            'prompt' => 'Semua Jabatan'
            , 'data' => ['live-search' => 'true']
                //, 'options' => PegawaiExt::dataListOptions()
        ]);

        $this->ajaxBootstrapSelect([
            'name' => 'jabatan-struktural',
            'searchField' => 'nama',
        ]);

        $defaultData = [];
        $id = $model->{$this->attribute};
        if ($model->{$this->attribute}) {
            $defaultData = [$id => $this->grid->formatter->asJabatanStruktural($id)];
        }
        return Html::activeDropDownList($model
                        , $this->attribute, $defaultData, $options) . $error;
    }

    public function kategoriWilayahFilter($model, $error) {
        $options = array_merge($this->filterInputOptions
                , ['id' => $this->attribute, 'prompt' => 'Pilih semua']);
        $this->pjaxReinit();
        return Html::activeDropDownList($model, $this->attribute
                        , \common\models\WilayahExt::LABEL_KATEGORI
                        , $options) . $error;
    }

    public function opdFilter($model, $error) {
        $options = array_merge(
                $this->filterInputOptions
                , [
            'id' => $this->attribute,
            'prompt' => 'Semua OPD'
            , 'data' => ['live-search' => 'true']
            , 'options' => OpdExt::dataListOptions()
        ]);
        $this->pjaxReinit();
        return Html::activeDropDownList($model, $this->attribute
                        , OpdExt::dataList(), $options) . $error;
    }

    public function pangkatFilter($model, $error) {
        $options = array_merge($this->filterInputOptions, [
            'id' => $this->attribute, 'prompt' => 'Semua pangkat']);
        $this->pjaxReinit();
        return Html::activeDropDownList($model, $this->attribute
                        , PangkatGolonganExt::dataList()
                        , $options) . $error;
    }

    public function pendudukFilter($model, $error) {
        $options = array_merge(
                $this->filterInputOptions
                , [
            'id' => $this->attribute,
            'prompt' => 'Semua Penduduk'
            , 'data' => ['live-search' => 'true']
                //, 'options' => PegawaiExt::dataListOptions()
        ]);

        $this->ajaxBootstrapSelect([
            'name' => 'penduduk',
            'searchField' => 'nama_tanpa_gelar',
        ]);

        $defaultData = [];
        $id = $model->{$this->attribute};
        if ($model->{$this->attribute}) {
            $defaultData = [$id => $this->grid->formatter->asPenduduk($id)];
        }
        return Html::activeDropDownList($model
                        , $this->attribute, $defaultData, $options) . $error;
    }

    public function pegawaiFilter($model, $error) {
        $options = array_merge(
                $this->filterInputOptions
                , [
            'id' => $this->attribute,
            'prompt' => 'Semua Pegawai'
            , 'data' => ['live-search' => 'true']
                //, 'options' => PegawaiExt::dataListOptions()
        ]);

        $this->ajaxBootstrapSelect([
            'name' => 'pegawai',
            'searchField' => 'nama_tanpa_gelar',
        ]);
        
        $defaultData = [];
        $id = $model->{$this->attribute};
        if ($model->{$this->attribute}) {
            $defaultData = [$id => $this->grid->formatter->asPegawai($id)];
        }
        return Html::activeDropDownList($model
                        , $this->attribute, $defaultData, $options) . $error;
    }

    public function tahunAnggaranFilter($model, $error) {
        $this->pjaxReinit();
        return Html::activeDropDownList($model, $this->attribute
                        , \common\models\TahunAnggaranExt::dataList()
                        , $this->filterInputOptions) . $error;
    }

    protected function pjaxReinit($attribute = null) {
        if (empty($attribute)) {
            $attribute = $this->attribute;
        }
        $this->grid->getView()->registerJs(<<<JS
            $(document).on('pjax:success', function(){
                $('#{$attribute}').selectpicker();
            });
JS
        );
    }

    protected function ajaxBootstrapSelect($options = []) {
        $name = Inflector::id2camel($options['name']);
        $word = Inflector::camel2words(Inflector::id2camel($options['name']));

        $url = Yii::$app->urlManagerApi->createAbsoluteUrl(['/v1/' . $options['name'],
            'access-token' => Yii::$app->user->identity->access_token
                ], '');
        $this->grid->getView()->registerJsFile(
                '@web/js/ajax-bootstrap-select.min.js'
                , [
            'depends' => [
                'sheillendra\alpino\assets\BootstrapSelectAsset']
                ]
        );
        $this->grid->getView()->registerJs(<<<JS
            function init{$name}Filter(){
                $('#{$this->attribute}').selectpicker({
                    liveSearch: true
                }).ajaxSelectPicker({
                    ajax: {
                        url: '{$url}',
                        type: 'get',
                        dataType: 'json',
                        data: function () {
                            var params = {
                                {$options['searchField']}: '{{{q}}}'
                            };
                            return params;
                        }
                    },
                    locale: {
                        emptyTitle: 'Mencari data {$word}...'
                    },
                    preprocessData: function(data){
                        var items = [];
                        var len = data.length;
                        for(var i = 0; i < len; i++){
                            var curr = data[i];
                            items.push(
                                {
                                    value: curr.id,
                                    text: curr.{$options['searchField']},
                                    data: {
                                        icon: 'icon-person',
                                        //subtext: curr.pangkat_golongan_id
                                    },
                                    disabled: false
                                }
                            );
                        }
                        return items;
                    },
                    preserveSelected: true
                });
            };

            init{$name}Filter();
            $(document).on('pjax:success', function(){
                init{$name}Filter();
            });
JS
        );
    }

}
