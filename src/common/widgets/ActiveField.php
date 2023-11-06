<?php

namespace common\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use common\models\OpdExt;
use common\models\PangkatGolonganExt;
use common\models\EselonExt;
use common\models\JabatanKeuanganExt;
use common\models\JabatanDaerahExt;
use common\models\WilayahExt;

/**
 * {@inheritdoc}
 */
class ActiveField extends \sheillendra\alpino\widgets\ActiveField {

    /**
     * 
     * @param array $options
     * @return $this
     */
    public function anggaranDropdownList($options = []) {
        $options['data'] = ['live-search' => 'true'];
        $this->ajaxBootstrapSelect([
            'id' => 'anggaran',
            'searchField' => 'nama',
        ]);
        return $this->dropDownList($this->model->{$this->attribute} ?
                        [$this->model->{$this->attribute} => $this->model->anggaran->nama] : [], $options);
    }

    /**
     * 
     * @param array $options
     * @return $this
     */
    public function dateInput($options = []) {
        $minDate = '';
        if (isset($options['minDate'])) {
            $minDate = 'minDate: \'' . $options['minDate'] . '\',';
            unset($options['minDate']);
        }

        $maxDate = '';
        if (isset($options['maxDate'])) {
            $maxDate = 'maxDate: \'' . $options['maxDate'] . '\',';
            unset($options['maxDate']);
        }

        $this->form->view->registerAssetBundle('sheillendra\alpino\assets\DatetimePickerAsset');
        $this->form->view->registerJs(<<<JS
            $('#{$this->getInputId()}').bootstrapMaterialDatePicker({
                format: 'YYYY-MM-DD',
                clearButton: true,
                weekStart: 1,
                time: false,
                {$minDate}
                {$maxDate}
            });
JS
        );
        return $this->textInput($options);
    }

    /**
     * 
     * @param array $options
     * @return $this
     */
    public function hiddenInput($options = []) {
        return parent::hiddenInput($options)->label(false);
    }

    /**
     * 
     * @param array $options
     * @return $this
     */
    public function jabatanKeuanganDropdownList($options = []) {
        $options['data'] = ['live-search' => 'true'];
        //$options['options'] = JabatanKeuanganExt::dataListOptions();
        return $this->dropDownList(JabatanKeuanganExt::dataList(), $options);
    }

    /**
     * 
     * @param array $options
     * @return $this
     */
    public function jabatanDaerahDropdownList($options = []) {
        $options['data'] = ['live-search' => 'true'];
        //$options['options'] = JabatanKeuanganExt::dataListOptions();
        return $this->dropDownList(JabatanDaerahExt::dataList(), $options);
    }
    
    /**
     * 
     * @param array $options
     * @return $this
     */
    public function kategoriWilayahDropdownList($options = []) {
        $options['data'] = ['live-search' => 'true'];
        return $this->dropDownList(WilayahExt::LABEL_KATEGORI, $options);
    }
    
    /**
     * 
     * @param array $options
     * @return $this
     */
    public function levelWilayahDropdownList($options = []) {
        $options['data'] = ['live-search' => 'true'];
        return $this->dropDownList(WilayahExt::LABEL_LEVEL, $options);
    }

    /**
     * 
     * @param array $options
     * @return $this
     */
    public function opdDropdownList($options = []) {
        $options['data'] = ['live-search' => 'true'];
        $options['options'] = OpdExt::dataListOptions();
        return $this->dropDownList(OpdExt::dataList(), $options);
    }

    /**
     * 
     * @param array $options
     * @return $this
     */
    public function pangkatGolonganDropdownList($options = []) {
        $options['data'] = ['live-search' => 'true'];
        //$options['options'] = PangkatGolonganExt::dataListOptions();
        return $this->dropDownList(PangkatGolonganExt::dataList(), $options);
    }

    /**
     * 
     * @param array $options
     * @return $this
     */
    public function eselonDropdownList($options = []) {
        $options['data'] = ['live-search' => 'true'];
        //$options['options'] = EselonExt::dataListOptions();
        return $this->dropDownList(EselonExt::dataList(), $options);
    }

    /**
     * 
     * @param array $options
     * @return $this
     */
    public function jabatanStrukturalDropdownList($options = []) {
        $options['data'] = ['live-search' => 'true'];
        $this->ajaxBootstrapSelect([
            'id' => 'jabatan-struktural',
            'searchField' => 'nama',
        ]);
        return $this->dropDownList($this->model->{$this->attribute} ?
                        [$this->model->{$this->attribute} => $this->model->jabatanStruktural->nama] : [], $options);
    }
    
    /**
     * 
     * @param array $options
     * @return $this
     */
    public function jenis_rute($options = []) {
        $options['id'] = 'jenis-rute';
        return $this->dropDownList([1 => 'Berangkat', 2 => 'Kembali'], $options)
                ->label('Jenis Rute');
    }

    /**
     * 
     * @param array $options
     * @return $this
     */
    public function pendudukDropdownList($options = []) {
        $this->ajaxBootstrapSelect([
            'id' => 'penduduk',
            'searchField' => 'nama_tanpa_gelar',
        ]);
        $options['data'] = ['live-search' => 'true'];
        return $this->dropDownList($this->model->{$this->attribute} ?
                        [$this->model->{$this->attribute} => $this->model->penduduk->nama_tanpa_gelar] : [], $options);
    }

    /**
     * 
     * @param array $options
     * @return $this
     */
    public function pegawaiDropdownList($options = []) {
        $this->ajaxBootstrapSelect([
            'id' => 'pegawai',
            'searchField' => 'nama_tanpa_gelar',
        ]);
        $options['data'] = ['live-search' => 'true'];
        return $this->dropDownList($this->model->{$this->attribute} ?
                        [$this->model->{$this->attribute} => $this->model->pegawai->nama_tanpa_gelar] : [], $options);
    }

    /**
     * 
     * @param array $options
     * @return $this
     */
    public function statusActiveDropdownList($options = []) {
        $options['id'] = 'status_active';
        return $this->dropDownList([1 => 'Aktif', 0 => 'Tidak aktif'], $options);
    }

    /**
     * 
     * @param array $options
     * @return $this
     */
    public function statusTahunAnggaranDropdownList($options = []) {
        return $this->dropDownList(\common\models\TahunAnggaranExt::STATUS_LABEL, $options);
    }

    /**
     * 
     * @param array $options
     * @return $this
     */
    public function tahunAnggaranDropdownList($options = []) {
        return $this->dropDownList(\common\models\TahunAnggaranExt::dataList(), $options);
    }

    /**
     * 
     * @param array $options
     * @return $this
     */
    public function wilayahDropdownList($options = []) {
        $options['data'] = ['live-search' => 'true'];
        $this->ajaxBootstrapSelect([
            'id' => 'wilayah',
            'searchField' => 'nama',
        ]);
        return $this->dropDownList($this->model->{$this->attribute} ?
                        [$this->model->{$this->attribute} => $this->model->nama] : [], $options);
    }
    
    protected function ajaxBootstrapSelect($options) {
        $word = Inflector::camel2words(Inflector::id2camel($options['id']));

        $url = Yii::$app->urlManagerApi->createAbsoluteUrl(['/v1/' . $options['id'], 'access-token' => Yii::$app->user->identity->access_token], '');
        $this->form->view->registerJsFile('@web/js/ajax-bootstrap-select.min.js', ['depends' => ['sheillendra\alpino\assets\BootstrapSelectAsset']]);
        $this->form->view->registerJs(<<<JS
            function initAjaxSelect(el, url, data, id, text, word){
                $(el).selectpicker({
                    liveSearch: true
                }).ajaxSelectPicker({
                    ajax: {
                        url: url,
                        type: 'get',
                        dataType: 'json',
                        data: data
                    },
                    locale: {
                        emptyTitle: 'Ketik nama ' + word + ' yang dicari...'
                    },
                    preprocessData: function(data){
                        var items = [];
                        var len = data.length;
                        for(var i = 0; i < len; i++){
                            var curr = data[i];
                            items.push(
                                {
                                    value: curr[id],
                                    text: curr[text],
                                    disabled: false
                                }
                            );
                        }
                        return items;
                    },
                    preserveSelected: true
                });
            };

            initAjaxSelect(
                '#{$this->getInputId()}', '{$url}'
                , function(){
                    var params = {
                        {$options['searchField']}: '{{{q}}}',
                        stid: $('.{$this->getInputId()}-ref').val()
                    };
                    return params;
                }
                , 'id'
                , '{$options['searchField']}'
                , '{$word}'
            );
JS
        );
    }

}
