<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JenisBiayaSppdExt;

/**
 * JenisBiayaSppdSearch represents the model behind the search form of `common\models\JenisBiayaSppdExt`.
 */
class JenisBiayaSppdSearch extends JenisBiayaSppdExt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kategori_biaya_sppd_id', 'satuan_id', 'pembuktian', 'pergi_pulang', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['nama', 'keterangan'], 'safe'],
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
        $query = JenisBiayaSppdExt::find();

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
            'kategori_biaya_sppd_id' => $this->kategori_biaya_sppd_id,
            'satuan_id' => $this->satuan_id,
            'pembuktian' => $this->pembuktian,
            'pergi_pulang' => $this->pergi_pulang,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'nama', $this->nama])
            ->andFilterWhere(['ilike', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
