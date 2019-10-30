<?php

namespace backend\models\fragments;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\fragments\NavigationTop;
use yii\helpers\ArrayHelper;
/**
 * NavigationTopSearch represents the model behind the search form of `backend\models\fragments\NavigationTop`.
 */
class NavigationTopSearch extends NavigationTop
{
    public $parentTitleGrid;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parentId', 'orderByNum', 'status'], 'integer'],
            [['url', 'title', 'parentTitleGrid'], 'safe'],
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
        $query = NavigationTop::find();

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
            'parentId' => $this->parentId,
            'orderByNum' => $this->orderByNum,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'title', $this->title]);

        $query->andFilterWhere(['like', 'parentId', $this->parentTitleGrid]);
        
        return $dataProvider;
    }
}
