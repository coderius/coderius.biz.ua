<?php

namespace modules\comments\models;

use modules\comments\models\Comments;
use modules\comments\Module;
use yii\base\Model;
use yii\data\ActiveDataProvider;
/**
 * CommentsSearch represents the model behind the search form of `modules\comments\models\Comments`.
 */
class CommentsSearch extends Comments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'entityId', 'parentId', 'level', 'like_count', 'createdBy', 'updatedBy', 'status'], 'integer'],
            [['entity', 'content', 'creatorType', 'said_name', 'said_email', 'ip', 'createdAt', 'updatedAt'], 'safe'],
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
    public function search($params, $formName = '')
    {
        $query = Comments::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            \Yii::debug(__CLASS__.': validation fails in', Module::moduleName);
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'entityId' => $this->entityId,
            'parentId' => $this->parentId,
            'level' => $this->level,
            'like_count' => $this->like_count,
            'createdBy' => $this->createdBy,
            'updatedBy' => $this->updatedBy,
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);
//var_dump($dataProvider->getTotalCount()); die;
        $query->andFilterWhere(['like', 'entity', $this->entity])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'creatorType', $this->creatorType])
            ->andFilterWhere(['like', 'said_name', $this->said_name])
            ->andFilterWhere(['like', 'said_email', $this->said_email])
            ->andFilterWhere(['like', 'ip', $this->ip]);
    
        return $dataProvider;
    }
}
