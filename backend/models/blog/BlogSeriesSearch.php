<?php

namespace backend\models\blog;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\blog\BlogSeries;

/**
 * BlogSeriesSearch represents the model behind the search form of `backend\models\blog\BlogSeries`.
 */
class BlogSeriesSearch extends BlogSeries
{
    public $countArtGrid;//выбранное число в поиске GridView
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [[  'alias', 
                'metaTitle', 
                'metaDesc', 
                'title',
                'countArtGrid',
                'cntArticles'// alias суммы постов в категории
            ], 
                'safe'],
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
        $query = BlogSeries::find()->select([
                        BlogSeries::tableName().'.*',
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

        $query->joinWith( 'articles' );
        $query->groupBy( [BlogSeries::tableName().'.id'] );

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
        ]);

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'metaTitle', $this->metaTitle])
            ->andFilterWhere(['like', 'metaDesc', $this->metaDesc])
            ->andFilterWhere(['like', 'title', $this->title]);

//        выбираем категории с кол-вом материалов <= выставленного в форме поиска колонки
        if($this->countArtGrid){
            $query->andHaving(['<=', 'cntArticles', $this->countArtGrid]);
        }
        
        return $dataProvider;
    }
}
