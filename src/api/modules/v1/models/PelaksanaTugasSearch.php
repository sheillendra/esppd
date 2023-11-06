<?php

namespace api\modules\v1\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\PelaksanaTugasExt;
use Yii;

/**
 * PelaksanaTugasSearch represents the model behind the search form of `common\models\PelaksanaTugasExt`.
 */
class PelaksanaTugasSearch extends PelaksanaTugasExt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'surat_tugas_id', 'pegawai_id', 'status', 'urutan', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['keterangan'], 'safe'],
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
        $query = PelaksanaTugasExt::find();

        // add conditions that should always apply here
        $query->alias('t0')
            ->leftJoin('{{surat_tugas}} t1', 't0.surat_tugas_id = t1.id');

        if (isset($params['pribadi']) && $params['pribadi'] == '1') {
            $this->selfRecordQuery($query);
        } else {
            if (Yii::$app->user->can(UserExt::ROLE_ADMIN_OPD)) {
            } else {
                $this->selfRecordQuery($query);
            }
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
            //'id' => $this->id,
            't0.surat_tugas_id' => $this->surat_tugas_id,
            't0.pegawai_id' => $this->pegawai_id,
            't0.status' => $this->status,
            't0.urutan' => $this->urutan,
            't0.created_at' => $this->created_at,
            't0.created_by' => $this->created_by,
            't0.updated_at' => $this->updated_at,
            't0.updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 't0.keterangan', $this->keterangan]);
        return $dataProvider;
    }
}
