<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AnggaranExt;
use common\models\TahunAnggaranExt;

/**
 * AnggaranSearch represents the model behind the search form of `common\models\AnggaranExt`.
 */
class AnggaranSearch extends AnggaranExt {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'opd_id', 'tahun_anggaran_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['kode_rekening', 'keterangan'], 'safe'],
            [['jumlah', 'saldo'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * {@inheritdoc}
     */
    public function formName() {
        return '';
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = AnggaranExt::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // add conditions that should always apply here
        $opdAdmin = Yii::$app->user->identity->getOpdAdmin();
        if ($opdAdmin) {
            $this->opd_id = $opdAdmin;
        }
        
        if (empty($this->tahun_anggaran_id)){
            $this->tahun_anggaran_id = TahunAnggaranExt::getTahunBerjalan();
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            //'id' => $this->id,
            'opd_id' => $this->opd_id,
            'tahun_anggaran_id' => $this->tahun_anggaran_id,
            'jumlah' => $this->jumlah,
            'saldo' => $this->saldo,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'kode_rekening', $this->kode_rekening])
                ->andFilterWhere(['ilike', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }

}
