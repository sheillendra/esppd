<?php

namespace api\modules\v1\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\SuratTugasExt;

/**
 * SuratTugasSearch represents the model behind the search form of `common\models\SuratTugasExt`.
 */
class SuratTugasSearch extends SuratTugasExt {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'pejabat_daerah_id', 'pejabat_struktural_id', 'jumlah_hari', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['tanggal_terbit', 'tanggal_mulai', 'nomor', 'maksud', 'keterangan'], 'safe'],
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
        $query = SuratTugasExt::find()
                ->alias('t0');

        $opdAdmin = Yii::$app->user->identity->getOpdAdmin();
        if ($opdAdmin) {
            $query->leftJoin('{{%pejabat_struktural}} t1', 't0.pejabat_struktural_id = t1.id')
                    ->leftJoin('{{%jabatan_struktural}} t2', 't1.jabatan_struktural_id = t2.id')
                    ->leftJoin('{{%pejabat_daerah}} t3', 't0.pejabat_daerah_id = t3.id')
                    ->leftJoin('{{%jabatan_daerah}} t4', 't3.jabatan_daerah_id = t4.id')
                    ->andWhere(['or', ['t2.opd_id' => $opdAdmin], ['t4.opd_id' => $opdAdmin]]);
            //echo $query->createCommand()->rawSql;exit;
        }
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

        if ((int) $this->pejabat_daerah_id > 500) {
            $query->andFilterWhere([
                'pejabat_struktural_id' => (int) $this->pejabat_daerah_id - 500,
            ]);
        } else {
            $query->andFilterWhere([
                'pejabat_daerah_id' => $this->pejabat_daerah_id,
            ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tanggal_terbit' => $this->tanggal_terbit,
            'tanggal_mulai' => $this->tanggal_mulai,
            'jumlah_hari' => $this->jumlah_hari,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'nomor', $this->nomor])
                ->andFilterWhere(['ilike', 'maksud', $this->maksud])
                ->andFilterWhere(['ilike', 'keterangan', $this->keterangan]);
        return $dataProvider;
    }

}
