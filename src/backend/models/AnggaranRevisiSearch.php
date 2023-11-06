<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AnggaranRevisiExt;

/**
 * AnggaranRevisiSearch represents the model behind the search form of `common\models\AnggaranRevisiExt`.
 */
class AnggaranRevisiSearch extends AnggaranRevisiExt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'anggaran_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['uraian'], 'safe'],
            [['saldo_awal', 'revisi', 'saldo_akhir'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = AnggaranRevisiExt::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            //'id' => $this->id,
            'anggaran_id' => $this->anggaran_id,
            'saldo_awal' => $this->saldo_awal,
            'revisi' => $this->revisi,
            'saldo_akhir' => $this->saldo_akhir,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'uraian', $this->uraian]);

        return $dataProvider;
    }
}
