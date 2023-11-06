<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OpdExt;

/**
 * OpdSearch represents the model behind the search form of `common\models\OpdExt`.
 */
class OpdSearch extends OpdExt {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'induk_id', 'kode_urusan', 'kode_bidang', 'kode_unit', 'kode_sub', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['nama', 'singkatan', 'baris_kop_1', 'baris_kop_2', 'keterangan'], 'safe'],
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
        $query = OpdExt::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'induk_id' => $this->induk_id,
            'kode_urusan' => $this->kode_urusan,
            'kode_bidang' => $this->kode_bidang,
            'kode_unit' => $this->kode_unit,
            'kode_sub' => $this->kode_sub,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'nama', $this->nama])
                ->andFilterWhere(['ilike', 'singkatan', $this->singkatan])
                ->andFilterWhere(['ilike', 'baris_kop_1', $this->baris_kop_1])
                ->andFilterWhere(['ilike', 'baris_kop_2', $this->baris_kop_2])
                ->andFilterWhere(['ilike', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
