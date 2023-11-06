<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\caching\TagDependency;
use common\models\SppdExt;

/**
 * SppdSearch represents the model behind the search form of `common\models\SppdExt`.
 */
class SppdSearch extends SppdExt {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'anggaran_id', 'pelaksana_tugas_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['nomor', 'tanggal', 'wilayah_berangkat', 'wilayah_tujuan', 'tanggal_berangkat', 'tanggal_kembali', 'alat_angkutan', 'keterangan', 'PelaksanaTugas.SuratTugas.nomor'], 'safe'],
            [['total_biaya'], 'number'],
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
        $query = SppdExt::find()
                ->alias('t0')
                ->leftJoin('{{%pelaksana_tugas}} t1', 't0.pelaksana_tugas_id = t1.id');

        // add conditions that should always apply here

        $opdAdmin = Yii::$app->user->identity->getOpdAdmin();
        if ($opdAdmin) {
            $query->leftJoin('{{%anggaran}} t2', 't0.anggaran_id = t2.id')
                    ->leftJoin('{{%pegawai}} t3', 't1.pegawai_id = t3.id')
                    ->andWhere(['or', ['t2.opd_id' => $opdAdmin], ['t3.opd_id' => $opdAdmin]]);
            //echo $query->createCommand()->rawSql;exit;
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
            't0.anggaran_id' => $this->anggaran_id,
            't0.pelaksana_tugas_id' => $this->pelaksana_tugas_id,
            't0.tanggal' => $this->tanggal,
            't0.tanggal_berangkat' => $this->tanggal_berangkat,
            't0.tanggal_kembali' => $this->tanggal_kembali,
            't0.total_biaya' => $this->total_biaya,
            't0.status' => $this->status,
            't0.created_at' => $this->created_at,
            't0.created_by' => $this->created_by,
            't0.updated_at' => $this->updated_at,
            't0.updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 't0.nomor', $this->nomor])
                ->andFilterWhere(['ilike', 't0.wilayah_berangkat', $this->wilayah_berangkat])
                ->andFilterWhere(['ilike', 't0.wilayah_tujuan', $this->wilayah_tujuan])
//                ->andFilterWhere(['ilike', 't0.alat_angkutan', $this->alat_angkutan])
//                ->andFilterWhere(['ilike', 't0.keterangan', $this->keterangan])
        ;

        Yii::$app->db->cache(function() use ($dataProvider) {
            $dataProvider->prepare();
        }, 0, new TagDependency(['tags' => 'sppd']));
        return $dataProvider;
    }

    public function getTotal($models, $column) {
        $total = 0;
        foreach ($models as $model) {
            $total = $model[$column];
        }
        return $total;
    }

}
