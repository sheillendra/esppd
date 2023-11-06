<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PendudukExt;

/**
 * PendudukSearch represents the model behind the search form of `common\models\PendudukExt`.
 */
class PendudukSearch extends PendudukExt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jenis_kelamin', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['nik', 'nama_tanpa_gelar', 'gelar_depan', 'gelar_belakang', 'keterangan'], 'safe'],
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
        $query = PendudukExt::find();

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
            'jenis_kelamin' => $this->jenis_kelamin,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'nik', $this->nik])
            ->andFilterWhere(['ilike', 'nama_tanpa_gelar', $this->nama_tanpa_gelar])
            ->andFilterWhere(['ilike', 'gelar_depan', $this->gelar_depan])
            ->andFilterWhere(['ilike', 'gelar_belakang', $this->gelar_belakang])
            ->andFilterWhere(['ilike', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
