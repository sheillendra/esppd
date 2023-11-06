<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PangkatGolonganExt;

/**
 * PangkatGolonganSearch represents the model behind the search form of `common\models\PangkatGolonganExt`.
 */
class PangkatGolonganSearch extends PangkatGolonganExt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'pangkat', 'golongan', 'ruang', 'tingkat_sppd', 'keterangan'], 'safe'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
        $query = PangkatGolonganExt::find();

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'kode', $this->kode])
            ->andFilterWhere(['ilike', 'pangkat', $this->pangkat])
            ->andFilterWhere(['ilike', 'golongan', $this->golongan])
            ->andFilterWhere(['ilike', 'ruang', $this->ruang])
            ->andFilterWhere(['ilike', 'tingkat_sppd', $this->tingkat_sppd])
            ->andFilterWhere(['ilike', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
    
}
