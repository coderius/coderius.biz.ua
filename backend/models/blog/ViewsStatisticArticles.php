<?php

namespace backend\models\blog;

use Yii;

/**
 * This is the model class for table "viewsStatisticArticles".
 *
 * @property int $id
 * @property int $idArticle
 * @property int $idUser
 * @property string $ip
 * @property string $actionAt
 *
 * @property BlogArticles $article
 */
class ViewsStatisticArticles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'viewsStatisticArticles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idArticle', 'ip', 'actionAt'], 'required'],
            [['idArticle', 'idUser'], 'integer'],
            [['actionAt'], 'safe'],
            [['ip'], 'string', 'max' => 255],
            [['idArticle'], 'unique'],
            [['idArticle'], 'exist', 'skipOnError' => true, 'targetClass' => BlogArticles::className(), 'targetAttribute' => ['idArticle' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'idArticle' => Yii::t('app', 'Id Article'),
            'idUser' => Yii::t('app', 'Id User'),
            'ip' => Yii::t('app', 'Ip'),
            'actionAt' => Yii::t('app', 'Action At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(BlogArticles::className(), ['id' => 'idArticle']);
    }

    /**
     * @inheritdoc
     * @return ViewsStatisticArticlesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ViewsStatisticArticlesQuery(get_called_class());
    }
}
