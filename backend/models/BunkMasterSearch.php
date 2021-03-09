<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BunkMaster;

/**
 * BunkMasterSearch represents the model behind the search form about `backend\models\BunkMaster`.
 */
class BunkMasterSearch extends BunkMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mobile_no'], 'integer'],
            [['bunk_agency_name', 'bunk_company', 'manager_name', 'email_id', 'address', 'user_name', 'password', 'authkey', 'created_at', 'modified_at', 'updated_ipaddress', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = BunkMaster::find();

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
            'mobile_no' => $this->mobile_no,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'bunk_agency_name', $this->bunk_agency_name])
            ->andFilterWhere(['like', 'bunk_company', $this->bunk_company])
            ->andFilterWhere(['like', 'manager_name', $this->manager_name])
            ->andFilterWhere(['like', 'email_id', $this->email_id])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'authkey', $this->authkey])
            ->andFilterWhere(['like', 'updated_ipaddress', $this->updated_ipaddress])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
