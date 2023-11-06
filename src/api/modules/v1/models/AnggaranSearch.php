<?php

namespace api\modules\v1\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\AnggaranExt;

/**
 * AnggaranSearch represents the model behind the search form of `api\modules\v1\models\AnggaranExt`.
 */
class AnggaranSearch extends AnggaranExt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'kode_induk', 'kode_rekening', 'keterangan'], 'safe'],
            [['produk_hukum_id', 'opd_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['jumlah', 'saldo'], 'number'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
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

        // grid filtering conditions
        $query->andFilterWhere([
            'produk_hukum_id' => $this->produk_hukum_id,
            'opd_id' => $this->opd_id,
            'jumlah' => $this->jumlah,
            'saldo' => $this->saldo,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'kode', $this->kode])
            ->andFilterWhere(['ilike', 'kode_induk', $this->kode_induk])
            ->andFilterWhere(['ilike', 'kode_rekening', $this->kode_rekening])
            ->andFilterWhere(['ilike', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
