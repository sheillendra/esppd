<?php

namespace api\modules\v1\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\SppdExt;

/**
 * SppdSearch represents the model behind the search form of `api\modules\v1\models\SppdExt`.
 */
class SppdSearch extends SppdExt
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'produk_hukum_id', 'pelaksana_tugas_id', 'bendahara_pengeluaran_id', 'pelaksana_teknik_kegiatan_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['kode_anggaran', 'nomor', 'tanggal', 'wilayah_berangkat', 'wilayah_tujuan', 'tanggal_berangkat', 'tanggal_kembali', 'tanggal_rampung', 'alat_angkutan', 'keterangan', 'fix_tingkat_sppd', 'fix_anggaran_opd', 'fix_anggaran_opd_singkatan', 'fix_pa_nama', 'fix_pa_nip', 'fix_bendahara_nama', 'fix_bendahara_nip', 'fix_teknik_nama', 'fix_teknik_nip', 'fix_penatausahaan_nama', 'fix_penatausahaan_nip', 'fix_kategori_wilayah', 'pdf_filename_sppd_blank', 'pdf_filename_sppd_barcode', 'pdf_filename_sppd_ttd', 'pdf_filename_visum_blank', 'pdf_filename_visum_barcode', 'pdf_filename_visum_ttd', 'pdf_filename_biaya_blank', 'pdf_filename_biaya_barcode', 'pdf_filename_biaya_ttd', 'pdf_filename_kwitansi_blank', 'pdf_filename_kwitansi_barcode', 'pdf_filename_kwitansi_ttd', 'pdf_filename_riil_blank', 'pdf_filename_riil_barcode', 'pdf_filename_rill_ttd', 'pdf_filename_rampung_blank', 'pdf_filename_rampung_barcode', 'pdf_filename_rampung_ttd', 'pdf_url_sppd_ttd'], 'safe'],
            [['total_biaya', 'saldo_awal', 'saldo_akhir', 'total_bukti'], 'number'],
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
        $query = SppdExt::find();

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
            'produk_hukum_id' => $this->produk_hukum_id,
            'pelaksana_tugas_id' => $this->pelaksana_tugas_id,
            'bendahara_pengeluaran_id' => $this->bendahara_pengeluaran_id,
            'pelaksana_teknik_kegiatan_id' => $this->pelaksana_teknik_kegiatan_id,
            'tanggal' => $this->tanggal,
            'tanggal_berangkat' => $this->tanggal_berangkat,
            'tanggal_kembali' => $this->tanggal_kembali,
            'tanggal_rampung' => $this->tanggal_rampung,
            'total_biaya' => $this->total_biaya,
            'saldo_awal' => $this->saldo_awal,
            'saldo_akhir' => $this->saldo_akhir,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'total_bukti' => $this->total_bukti,
        ]);

        $query->andFilterWhere(['ilike', 'kode_anggaran', $this->kode_anggaran])
            ->andFilterWhere(['ilike', 'nomor', $this->nomor])
            ->andFilterWhere(['ilike', 'wilayah_berangkat', $this->wilayah_berangkat])
            ->andFilterWhere(['ilike', 'wilayah_tujuan', $this->wilayah_tujuan])
            ->andFilterWhere(['ilike', 'alat_angkutan', $this->alat_angkutan])
            ->andFilterWhere(['ilike', 'keterangan', $this->keterangan])
            ->andFilterWhere(['ilike', 'fix_tingkat_sppd', $this->fix_tingkat_sppd])
            ->andFilterWhere(['ilike', 'fix_anggaran_opd', $this->fix_anggaran_opd])
            ->andFilterWhere(['ilike', 'fix_anggaran_opd_singkatan', $this->fix_anggaran_opd_singkatan])
            ->andFilterWhere(['ilike', 'fix_pa_nama', $this->fix_pa_nama])
            ->andFilterWhere(['ilike', 'fix_pa_nip', $this->fix_pa_nip])
            ->andFilterWhere(['ilike', 'fix_bendahara_nama', $this->fix_bendahara_nama])
            ->andFilterWhere(['ilike', 'fix_bendahara_nip', $this->fix_bendahara_nip])
            ->andFilterWhere(['ilike', 'fix_teknik_nama', $this->fix_teknik_nama])
            ->andFilterWhere(['ilike', 'fix_teknik_nip', $this->fix_teknik_nip])
            ->andFilterWhere(['ilike', 'fix_penatausahaan_nama', $this->fix_penatausahaan_nama])
            ->andFilterWhere(['ilike', 'fix_penatausahaan_nip', $this->fix_penatausahaan_nip])
            ->andFilterWhere(['ilike', 'fix_kategori_wilayah', $this->fix_kategori_wilayah])
            ->andFilterWhere(['ilike', 'pdf_filename_sppd_blank', $this->pdf_filename_sppd_blank])
            ->andFilterWhere(['ilike', 'pdf_filename_sppd_barcode', $this->pdf_filename_sppd_barcode])
            ->andFilterWhere(['ilike', 'pdf_filename_sppd_ttd', $this->pdf_filename_sppd_ttd])
            ->andFilterWhere(['ilike', 'pdf_filename_visum_blank', $this->pdf_filename_visum_blank])
            ->andFilterWhere(['ilike', 'pdf_filename_visum_barcode', $this->pdf_filename_visum_barcode])
            ->andFilterWhere(['ilike', 'pdf_filename_visum_ttd', $this->pdf_filename_visum_ttd])
            ->andFilterWhere(['ilike', 'pdf_filename_biaya_blank', $this->pdf_filename_biaya_blank])
            ->andFilterWhere(['ilike', 'pdf_filename_biaya_barcode', $this->pdf_filename_biaya_barcode])
            ->andFilterWhere(['ilike', 'pdf_filename_biaya_ttd', $this->pdf_filename_biaya_ttd])
            ->andFilterWhere(['ilike', 'pdf_filename_kwitansi_blank', $this->pdf_filename_kwitansi_blank])
            ->andFilterWhere(['ilike', 'pdf_filename_kwitansi_barcode', $this->pdf_filename_kwitansi_barcode])
            ->andFilterWhere(['ilike', 'pdf_filename_kwitansi_ttd', $this->pdf_filename_kwitansi_ttd])
            ->andFilterWhere(['ilike', 'pdf_filename_riil_blank', $this->pdf_filename_riil_blank])
            ->andFilterWhere(['ilike', 'pdf_filename_riil_barcode', $this->pdf_filename_riil_barcode])
            ->andFilterWhere(['ilike', 'pdf_filename_rill_ttd', $this->pdf_filename_rill_ttd])
            ->andFilterWhere(['ilike', 'pdf_filename_rampung_blank', $this->pdf_filename_rampung_blank])
            ->andFilterWhere(['ilike', 'pdf_filename_rampung_barcode', $this->pdf_filename_rampung_barcode])
            ->andFilterWhere(['ilike', 'pdf_filename_rampung_ttd', $this->pdf_filename_rampung_ttd])
            ->andFilterWhere(['ilike', 'pdf_url_sppd_ttd', $this->pdf_url_sppd_ttd]);

        return $dataProvider;
    }
}
