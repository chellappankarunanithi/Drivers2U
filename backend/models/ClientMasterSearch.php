<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ClientMaster;

/**
 * ClientMasterSearch represents the model behind the search form about `backend\models\ClientMaster`.
 */
class ClientMasterSearch extends ClientMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mobile_no', 'pincode', 'user_id'], 'integer'],
            [['company_name', 'client_name', 'UserType','Landmark','address','status', 'email_id', 'website', 'created_at', 'modified_at', 'updated_ipaddress'], 'safe'],
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
        // echo "<pre>"; print_r($params); die;
        $query = ClientMaster::find(); 
        // add conditions that should always apply here
        //echo $query->createCommand()->getRawSql(); die; 
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => 20,
            ],
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
          //  'mobile_no' => $this->mobile_no,
          //  'pincode' => $this->pincode,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'client_name', $this->client_name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'pincode', $this->pincode])
            ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
            ->andFilterWhere(['like', 'email_id', $this->email_id])
            ->andFilterWhere(['like', 'Landmark', $this->Landmark]) 
            ->andFilterWhere(['like', 'UserType', $this->UserType]) 
            ->andFilterWhere(['like', 'status', $this->status]) 
            ->andFilterWhere(['like', 'updated_ipaddress', $this->updated_ipaddress]);

        return $dataProvider;
    }
}
