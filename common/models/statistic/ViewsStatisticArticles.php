<?php

namespace common\models\statistic;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use frontend\models\blog\articles\BlogArticles;
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
            [['idArticle', 'ip'], 'required'],
            [['idArticle', 'idUser'], 'integer'],
            [['actionAt'], 'safe'],
            [['ip'], 'string', 'max' => 255],
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

        public function behaviors()
    {
        return [
//            [
//                'class' => SluggableBehavior::className(),
//                'attribute' => 'title',
//                 'slugAttribute' => 'alias',
//                'immutable' => true,//неизменный
//                'ensureUnique'=>true,
//            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'idUser',
                'updatedByAttribute' => null,
                'defaultValue' => function ($event) {
                    return (\Yii::$app->user->isGuest) ? 0 : Yii::$app->user->identity->id;
                }
            ],
            'timestamp' => [//Использование поведения TimestampBehavior ActiveRecord
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['actionAt'],
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_UPDATE => null,

                ],
                'value' => function(){
                                return gmdate("Y-m-d H:i:s");
                },
//                'value' => new \yii\db\Expression('NOW()'),

            ],
//            'purify' => [
//                'class' => PurifyBehavior::className(),
//                'attributes' => ['message']
//            ]
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
