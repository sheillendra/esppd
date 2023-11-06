<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\caching\TagDependency;
use common\models\PegawaiExt;

/**
 * PegawaiSearch represents the model behind the search form of `common\models\PegawaiExt`.
 */
class PegawaiSearch extends PegawaiExt {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'opd_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['nama_tanpa_gelar', 'gelar_depan', 'gelar_belakang', 'nip', 'pangkat_golongan_id', 'eselon_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $query = PegawaiExt::find();

        // add conditions that should always apply here
        $opdAdmin = Yii::$app->user->identity->getOpdAdmin();
        if ($opdAdmin) {
            $query->andWhere(['opd_id' => $opdAdmin]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['nama_tanpa_gelar' => SORT_ASC]
            ]
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
            'opd_id' => $this->opd_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'nama_tanpa_gelar', $this->nama_tanpa_gelar])
                ->andFilterWhere(['ilike', 'gelar_depan', $this->gelar_depan])
                ->andFilterWhere(['ilike', 'gelar_belakang', $this->gelar_belakang])
                ->andFilterWhere(['ilike', 'nip', $this->nip])
                ->andFilterWhere(['ilike', 'pangkat_golongan_id', $this->pangkat_golongan_id])
                ->andFilterWhere(['ilike', 'eselon_id', $this->eselon_id]);

        Yii::$app->db->cache(function() use ($dataProvider) {
            $dataProvider->prepare();
        }, 0, new TagDependency(['tags' => 'pegawai']));
        return $dataProvider;
    }

}
