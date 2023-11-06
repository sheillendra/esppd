<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RincianBiayaSppdExt;

/**
 * RincianBiayaSppdSearch represents the model behind the search form of `common\models\RincianBiayaSppdExt`.
 */
class RincianBiayaSppdSearch extends RincianBiayaSppdExt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sppd_id', 'jenis_biaya_id', 'kategori_biaya_id', 'satuan_id', 'urutan', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['tanggal', 'uraian', 'keterangan'], 'safe'],
            [['volume', 'harga', 'total'], 'number'],
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
        $query = RincianBiayaSppdExt::find();

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
            'sppd_id' => $this->sppd_id,
            'jenis_biaya_id' => $this->jenis_biaya_id,
            'kategori_biaya_id' => $this->kategori_biaya_id,
            'tanggal' => $this->tanggal,
            'volume' => $this->volume,
            'satuan_id' => $this->satuan_id,
            'harga' => $this->harga,
            'total' => $this->total,
            'urutan' => $this->urutan,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'uraian', $this->uraian])
            ->andFilterWhere(['ilike', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
