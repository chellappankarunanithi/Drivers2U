<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CustomerDetails;

/**
 * CustomerDetailsSearch represents the model behind the search form of `backend\models\CustomerDetails`.
 */
class CustomerDetailsSearch extends CustomerDetails
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['company_name', 'contact_person', 'contact_person_designation','clientname', 'company_contact_no', 'company_email', 'company_address', 'personal_contact_no', 'personal_email', 'personal_address', 'company_pincode', 'personal_pincode', 'created_at', 'updated_at', 'updated_ipaddress'], 'safe'],
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
        // echo "<pre>";print_r($params);die;
        $query = CustomerDetails::find()->joinWith(['client']);

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'contact_person', $this->contact_person])
            ->andFilterWhere(['like', 'contact_person_designation', $this->contact_person_designation])
            ->andFilterWhere(['like', 'company_contact_no', $this->company_contact_no])
            ->andFilterWhere(['like', 'company_email', $this->company_email])
            ->andFilterWhere(['like', 'company_address', $this->company_address])
            ->andFilterWhere(['like', 'personal_contact_no', $this->personal_contact_no])
            ->andFilterWhere(['like', 'personal_email', $this->personal_email])
            ->andFilterWhere(['like', 'personal_address', $this->personal_address])
            ->andFilterWhere(['like', 'company_pincode', $this->company_pincode])
            ->andFilterWhere(['like', 'personal_pincode', $this->personal_pincode])
            ->andFilterWhere(['like', 'client_master.company_name', $this->clientname])
            ->andFilterWhere(['like', 'updated_ipaddress', $this->updated_ipaddress]);

        return $dataProvider;
    }
}
