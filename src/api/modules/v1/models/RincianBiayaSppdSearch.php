<?php

namespace api\modules\v1\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\RincianBiayaSppdExt;

/**
 * RincianBiayaSppdSearch represents the model behind the search form of `api\modules\v1\models\RincianBiayaSppdExt`.
 */
class RincianBiayaSppdSearch extends RincianBiayaSppdExt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sppd_id', 'jenis_biaya_id', 'kategori_biaya_id', 'satuan_id', 'riil', 'urutan', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['tanggal', 'uraian', 'pdf_bukti', 'keterangan', 'detail'], 'safe'],
            [['volume', 'harga', 'total', 'total_bukti'], 'number'],
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
            'total_bukti' => $this->total_bukti,
            'riil' => $this->riil,
            'urutan' => $this->urutan,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'uraian', $this->uraian])
            ->andFilterWhere(['ilike', 'pdf_bukti', $this->pdf_bukti])
            ->andFilterWhere(['ilike', 'keterangan', $this->keterangan])
            ->andFilterWhere(['ilike', 'detail', $this->detail]);

        return $dataProvider;
    }
}
