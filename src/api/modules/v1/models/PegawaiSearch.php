<?php

namespace api\modules\v1\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\PegawaiExt;

/**
 * PegawaiSearch represents the model behind the search form of `api\modules\v1\models\PegawaiExt`.
 */
class PegawaiSearch extends PegawaiExt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'opd_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['nip', 'pangkat_golongan_id', 'eselon_id', 'nama_tanpa_gelar', 'gelar_depan', 'gelar_belakang'], 'safe'],
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
        $query = PegawaiExt::find();

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
            'user_id' => $this->user_id,
            'opd_id' => $this->opd_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'nip', $this->nip])
            ->andFilterWhere(['ilike', 'pangkat_golongan_id', $this->pangkat_golongan_id])
            ->andFilterWhere(['ilike', 'eselon_id', $this->eselon_id])
            ->andFilterWhere(['ilike', 'nama_tanpa_gelar', $this->nama_tanpa_gelar])
            ->andFilterWhere(['ilike', 'gelar_depan', $this->gelar_depan])
            ->andFilterWhere(['ilike', 'gelar_belakang', $this->gelar_belakang]);

        return $dataProvider;
    }
}
