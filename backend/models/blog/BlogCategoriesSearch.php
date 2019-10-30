<?php

namespace backend\models\blog;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\blog\BlogCategories;

/**
 * BlogCategoriesSearch represents the model behind the search form of `backend\models\blog\BlogCategories`.
 */
class BlogCategoriesSearch extends BlogCategories
{
    
    public $countArtGrid;//выбранное число в поиске GridView
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sort_order'], 'integer'],
            [[  'alias',
                'metaTitle', 
                'metaDesc', 
                'title', 
                'countArtGrid',
                'cntArticles'// alias суммы постов в категории
                
            ], 'safe'],
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
        $query = BlogCategories::find()
                ->select([
                        BlogCategories::tableName().'.*',
                        "COUNT(".BlogArticles::tableName().".id) AS cntArticles"
                    ]);
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

        $query->joinWith( BlogArticles::tableName() );
        $query->groupBy( [BlogCategories::tableName().'.id'] );

        $dataProvider->sort->attributes['countArtGrid'] = [
            'asc' => ['cntArticles' => SORT_ASC],
            'desc' => ['cntArticles' => SORT_DESC],
        ];
        
        $dataProvider->sort->defaultOrder = [
            'id'=> SORT_DESC,
        ];
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sort_order' => $this->sort_order,
        ]);

        $query->andFilterWhere(['like', BlogCategories::tableName().'.alias', $this->alias])
            ->andFilterWhere(['like', BlogCategories::tableName().'.metaTitle', $this->metaTitle])
            ->andFilterWhere(['like', BlogCategories::tableName().'.metaDesc', $this->metaDesc])
            ->andFilterWhere(['like', BlogCategories::tableName().'.title', $this->title]);
        
        //выбираем категории с кол-вом материалов <= выставленного в форме поиска колонки
        if($this->countArtGrid){
            $query->andHaving(['<=', 'cntArticles', $this->countArtGrid]);
        }
        
        return $dataProvider;
    }
}
