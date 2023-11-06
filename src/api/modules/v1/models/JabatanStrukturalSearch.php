<?php

namespace api\modules\v1\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\JabatanStrukturalExt;

/**
 * JabatanStrukturalSearch represents the model behind the search form of `common\models\JabatanStrukturalExt`.
 */
class JabatanStrukturalSearch extends JabatanStrukturalExt
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'opd_id', 'status', 'urutan', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['nama', 'nama_2', 'singkatan', 'tingkat_sppd', 'keterangan'], 'safe'],
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
    public function formName()
    {
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
        $query = JabatanStrukturalExt::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // add conditions that should always apply here

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'opd_id' => $this->opd_id,
            'status' => $this->status,
            'urutan' => $this->urutan,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        if ($this->nama && $this->nama_2 && $this->singkatan) {
            $query->andFilterWhere([
                'or',
                ['ilike', 'nama', $this->nama],
                ['ilike', 'nama_2', $this->nama_2],
                ['ilike', 'singkatan', $this->singkatan]
            ]);
        } else {
            $query->andFilterWhere(['ilike', 'nama', $this->nama])
                ->andFilterWhere(['ilike', 'nama_2', $this->nama_2])
                ->andFilterWhere(['ilike', 'singkatan', $this->singkatan])
                ->andFilterWhere(['ilike', 'tingkat_sppd', $this->tingkat_sppd])
                ->andFilterWhere(['ilike', 'keterangan', $this->keterangan]);
        }
        return $dataProvider;
    }
}
