<?php
use yii\helpers\Html;
use yii\helpers\Url;
use modules\comments\Module;

//isDesibled()

?>

<?php if($model->isActive() || Yii::$app->getUser()->can(Module::instance()->adminRbac)): ?>
    <a name="<?= $model->id; ?>"></a>
    <li class="<?= $model->hasChildren() ? 'has-child': ''; ?><?= $model->isDesibled() ? ' isDesibled': ''; ?>" >
        <div class="comment-wrap">
        <!--Avatar--> 
        <div class="comment-avatar"><?php echo Html::img($model->getAvatar(), ['alt' => $model->getAuthorName()]); ?></div>
        <!--Contenedor del Comentario--> 
            <div class="comment-box">
                <div class="comment-head">
                    <h6 class="comment-name <?= $model->isMaterialAuthor($materialAuthorId) ? 'by-author' : ''; ?>"><a href=""><?= $model->getAuthorName();?></a></h6>
                    <span><?= Yii::$app->formatter->asDatetime($model->createdAt, 'php:l d-F-Y в H:i:s'); ?></span>
                    <div class="comment-action-bar">
                        <?php echo Html::a("#".$model->id, "#".$model->id, []); ?>

                        <?php echo Html::a("<i class=\"glyphicon glyphicon-share-alt\"></i>", '#', ['class' => 'reply-comment-btn', 'data' => ['action' => 'reply', 'comment-id' => $model->id]]); ?>

                        <?php 
                            $options_i_glyphicon_heart = ['class'=>'glyphicon glyphicon-heart'];
                            if($model->isSelfLikedComment()){
                                Html::addCssClass($options_i_glyphicon_heart, 'add-color-green');
                            }
                            $i_glyphicon_heart = Html::tag('i', '', $options_i_glyphicon_heart ); 
                        ?>

                        <?php echo Html::a($i_glyphicon_heart . "  <small class='comment-like-count'>$model->like_count</small>", '#', ['class' => 'like-comment-btn', 'data' => ['action' => 'like', 'comment-id' => $model->id] ]); ?>

                        <?php if (Yii::$app->getUser()->can(Module::instance()->adminRbac)) : ?>

                        <?php echo Html::a('<i class="glyphicon glyphicon-ban-circle'. ($model->isDesibled() ? " add-color-red": "") .'"></i>', Url::toRoute(['/comments/default/desibled-comment']), ['id' => 'desibled-comment-btn', 'data' => ['comment-id' => $model->id] ]); ?>
                        <?php echo Html::a('<i class="glyphicon glyphicon-ok-circle'. ($model->isActive() ? " add-color-green": "") .'"></i>', Url::toRoute(['/comments/default/active-comment']), ['id' => 'active-comment-btn', 'data' => ['comment-id' => $model->id] ]); ?>

                        <?php endif; ?>
                    </div>

                </div>
                <div class="comment-content">
                    <?= $model->content; ?>
                </div>
            </div>
        </div> 




    <?php if ($model->hasChildren()) : ?>
        <ul class="comments-list reply-list level-<?= $index += 1; ?>">

            <?php foreach ($model->getChildren() as $children) : ?>
                <?php echo $this->render('_list', ['model' => $children, 'maxLevel' => $maxLevel, 'index' => $index, 'materialAuthorId' => $materialAuthorId]); ?>
            <?php endforeach; ?>

        </ul>
    <?php endif; ?>
    </li>
<?php endif; ?>