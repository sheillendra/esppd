<?php

namespace api\modules\v1\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\PejabatDaerahExt;

/**
 * PejabatDaerahSearch represents the model behind the search form of `common\models\PejabatDaerahExt`.
 */
class PejabatDaerahSearch extends PejabatDaerahExt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jabatan_daerah_id', 'penduduk_id', 'produk_hukum_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['keterangan'], 'safe'],
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
        $query = PejabatDaerahExt::find();

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
            'id' => $this->id,
            'jabatan_daerah_id' => $this->jabatan_daerah_id,
            'penduduk_id' => $this->penduduk_id,
            'produk_hukum_id' => $this->produk_hukum_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
