<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PejabatStrukturalExt;

/**
 * PejabatStrukturalSearch represents the model behind the search form of `common\models\PejabatStrukturalExt`.
 */
class PejabatStrukturalSearch extends PejabatStrukturalExt {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'jabatan_struktural_id', 'pegawai_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['tanggal_mulai', 'tanggal_selesai', 'dasar_hukum', 'keterangan'], 'safe'],
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
        $query = PejabatStrukturalExt::find()
                ->alias('t0');

        $opdAdmin = Yii::$app->user->identity->getOpdAdmin();
        if ($opdAdmin) {
            $query->leftJoin('{{%jabatan_struktural}} t1', 't0.jabatan_struktural_id = t1.id')
                    ->andWhere(['t1.opd_id' => $opdAdmin])
            ;
        }

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
            'jabatan_struktural_id' => $this->jabatan_struktural_id,
            'pegawai_id' => $this->pegawai_id,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'dasar_hukum', $this->dasar_hukum])
                ->andFilterWhere(['ilike', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }

}
