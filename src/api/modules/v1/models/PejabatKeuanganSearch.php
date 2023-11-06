<?php

namespace api\modules\v1\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PejabatKeuanganExt;

/**
 * PejabatKeuanganSearch represents the model behind the search form of `common\models\PejabatKeuanganExt`.
 */
class PejabatKeuanganSearch extends PejabatKeuanganExt {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'opd_id', 'jabatan_keuangan_id', 'pegawai_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
        $query = PejabatKeuanganExt::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $opdAdmin = Yii::$app->user->identity->getOpdAdmin();
        if ($opdAdmin) {
            $this->opd_id = $opdAdmin;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'opd_id' => $this->opd_id,
            'jabatan_keuangan_id' => $this->jabatan_keuangan_id,
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
