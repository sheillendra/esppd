<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserExt;

/**
 * UserSearch represents the model behind the search form of `common\models\UserExt`.
 */
class UserSearch extends UserExt {

    public $roles;
    public $nama_lengkap;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [
                [
                    'username', 'auth_key', 'password_hash',
                    'password_reset_token', 'email', 'verification_token',
                    'roles', 'nama_lengkap',
                ],
                'safe'
            ],
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
        $query = $this::find()
                ->alias('t0')
                ->select(['t0.*', 't1.roles', 't1.max_level', 'COALESCE(t2.nama_tanpa_gelar, t3.nama_tanpa_gelar) AS nama_lengkap'])
                ->leftJoin($this->authAssigmentWithRoles() . ' t1', 't1.user_id = t0.id')
                ->leftJoin('{{%pegawai}} t2', 't2.user_id=t0.id')
                ->leftJoin('{{%penduduk}} t3', 't3.user_id=t0.id')
        ;

        if (Yii::$app->user->can($this::ROLE_SUPERADMIN)) {
            if (Yii::$app->user->id > 1) {
                $query->where(['>', 't0.id', 2]);
            }
        } else {
            $query->where(['>', 't1.max_level', Yii::$app->user->identity->maxLevel])
                    ->orWhere(['t1.roles' => null]);
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

        // grid filtering conditions
        $query->andFilterWhere([
            //'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'username', $this->username])
                //->andFilterWhere(['ilike', 'auth_key', $this->auth_key])
                //->andFilterWhere(['ilike', 'password_hash', $this->password_hash])
                //->andFilterWhere(['ilike', 'password_reset_token', $this->password_reset_token])
                //->andFilterWhere(['ilike', 'email', $this->email])
                //->andFilterWhere(['ilike', 'verification_token', $this->verification_token])
                ->andFilterWhere(['ilike', 'roles', $this->roles])
                ->andFilterWhere(['or', ['ilike', 't2.nama_tanpa_gelar', $this->nama_lengkap], ['ilike', 't3.nama_tanpa_gelar', $this->nama_lengkap]])
        ;

        return $dataProvider;
    }

}
