<?php

namespace backend\models\blog;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\blog\BlogArticles;

/**
 * BlogArticlesSearch represents the model behind the search form of `backend\models\blog\BlogArticles`.
 */
class BlogArticlesSearch extends BlogArticles
{
    public $category;
    public $tagsArtGrid;
    public $seriesArtGrid;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idCategory', 'flagActive', 'createdBy', 'updatedBy', 'viewCount'], 'integer'],
            [['alias', 'metaTitle', 'metaDesc', 'title', 'text', 'faceImg', 'faceImgAlt', 'createdAt', 'updatedAt', 'category', 'tagsArtGrid', 'seriesArtGrid', 'searchAliasTags', 'searchAliasSeries'], 'safe'],
            
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
        $query = BlogArticles::find()
                ->select([
                    self::tableName().'.*',
                    //добавляем имена тегов из связей и канкатенируем их в одну строку для кажд. записи
                    //по этой строке будем производить поиск
                    "GROUP_CONCAT(DISTINCT ".BlogTags::tableName().".title ORDER BY ".BlogTags::tableName().".id ASC SEPARATOR ', ') AS searchAliasTags",
                    "GROUP_CONCAT(DISTINCT ".BlogSeries::tableName().".title ORDER BY ".BlogSeries::tableName().".id ASC SEPARATOR ', ') AS searchAliasSeries"
                    
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

        $query->joinWith('category');
        $query->joinWith('blogTags');
        $query->joinWith('series');
        
        $query->groupBy( [BlogArticles::tableName().'.id'] );
        
        $dataProvider->setSort(['defaultOrder' => ['createdAt'=> SORT_DESC]]);
        
        $dataProvider->sort->attributes['category'] = [
            'asc' => [BlogCategories::tableName().'.title' => SORT_ASC],
            'desc' => [BlogCategories::tableName().'.title' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['seriesArtGrid'] = [
            'asc'  => ['searchAliasSeries' => SORT_ASC],
            'desc' => ['searchAliasSeries' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['tagsArtGrid'] = [
            'asc'  => ['searchAliasTags' => SORT_ASC],
            'desc' => ['searchAliasTags' => SORT_DESC],
        ];
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'idCategory' => $this->idCategory,
            'flagActive' => $this->flagActive,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'createdBy' => $this->createdBy,
            'updatedBy' => $this->updatedBy,
            'viewCount' => $this->viewCount,
        ]);

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'metaTitle', $this->metaTitle])
            ->andFilterWhere(['like', 'metaDesc', $this->metaDesc])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'faceImg', $this->faceImg])
            ->andFilterWhere(['like', 'faceImgAlt', $this->faceImgAlt]);

        $query->andFilterWhere(['like', BlogCategories::tableName().'.title', $this->category]);
        
        //поиск по тегам
        if($this->tagsArtGrid){
            $query->andHaving(['like', 'searchAliasTags', $this->tagsArtGrid]);
        }
        
        //поиск по сериям
        //$this->seriesArtGrid - сюда попадает искомая фраза из формы в grid view
        //searchAliasSeries - алиас на сформированную строку названий серий из запроса
        //Having - позволяет искать с использованием алиасов
        if($this->seriesArtGrid){
            $query->andHaving(['like', 'searchAliasSeries', $this->seriesArtGrid]);
        }
        
        return $dataProvider;
    }
}
