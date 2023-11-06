<?php

namespace api\modules\v1\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\BesaranBiayaSppdExt;

/**
 * BesaranBiayaSppdSearch represents the model behind the search form of `api\modules\v1\models\BesaranBiayaSppdExt`.
 */
class BesaranBiayaSppdSearch extends BesaranBiayaSppdExt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jabatan_daerah_id', 'jabatan_struktural_id', 'jabatan_fungsional_id', 'kategori_wilayah', 'jenis_biaya_sppd_id', 'produk_hukum_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['pangkat_golongan_id', 'eselon_id', 'wilayah_id', 'keterangan'], 'safe'],
            [['jumlah'], 'number'],
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
        $query = BesaranBiayaSppdExt::find();

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
            'jabatan_struktural_id' => $this->jabatan_struktural_id,
            'jabatan_fungsional_id' => $this->jabatan_fungsional_id,
            'kategori_wilayah' => $this->kategori_wilayah,
            'jenis_biaya_sppd_id' => $this->jenis_biaya_sppd_id,
            'jumlah' => $this->jumlah,
            'produk_hukum_id' => $this->produk_hukum_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'pangkat_golongan_id', $this->pangkat_golongan_id])
            ->andFilterWhere(['ilike', 'eselon_id', $this->eselon_id])
            ->andFilterWhere(['ilike', 'wilayah_id', $this->wilayah_id])
            ->andFilterWhere(['ilike', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
