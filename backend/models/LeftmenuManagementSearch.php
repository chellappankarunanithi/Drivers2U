<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\LeftmenuManagement;

/**
 * LeftmenuManagementSearch represents the model behind the search form of `backend\models\LeftmenuManagement`.
 */
class LeftmenuManagementSearch extends LeftmenuManagement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menuId', 'groupId', 'sortOrder'], 'integer'],
            [['menuTpe', 'Name', 'userUrl', 'groupCode','menuFor', 'faIcon', 'activeStatus', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = LeftmenuManagement::find();

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
            'menuId' => $this->menuId,
            'groupId' => $this->groupId,
            'sortOrder' => $this->sortOrder,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'menuTpe', $this->menuTpe])
            ->andFilterWhere(['like', 'Name', $this->Name])
            ->andFilterWhere(['like', 'userUrl', $this->userUrl])
            ->andFilterWhere(['like', 'groupCode', $this->groupCode])
            ->andFilterWhere(['like', 'faIcon', $this->faIcon])
            ->andFilterWhere(['like', 'menuFor', $this->menuFor])
            ->andFilterWhere(['like', 'activeStatus', $this->activeStatus]);

        return $dataProvider;
    }
}
