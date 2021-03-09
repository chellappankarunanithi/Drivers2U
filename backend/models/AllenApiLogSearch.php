<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AllenApiLog;

/**
 * AllenApiLogSearch represents the model behind the search form of `backend\models\AllenApiLog`.
 */
class AllenApiLogSearch extends AllenApiLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['autoid', 'branch_id'], 'integer'],
            [['event_key', 'data', 'event', 'response', 'created_at'], 'safe'],
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
        $query = AllenApiLog::find()->orderBy(['autoid'=>SORT_DESC]);

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
            'autoid' => $this->autoid,
            'branch_id' => $this->branch_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'event_key', $this->event_key])
            ->andFilterWhere(['like', 'data', $this->data])
            ->andFilterWhere(['like', 'event', $this->event])
            ->andFilterWhere(['like', 'response', $this->response]);

        return $dataProvider;
    }
}
