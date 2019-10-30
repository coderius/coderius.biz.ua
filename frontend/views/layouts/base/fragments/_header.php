<?php

/**
 * @file _header.php created 06.02.2018 17:59:13
 *
 * @copyright Copyright (C) 2018 Sergio Codev <codev>
 * @license This program is free software: GNU General Public License
 */

//use yii;
use yii\helpers\Url;
use common\components\rbac\Rbac;
use yii\web\Cookie;
use yii\db\ActiveRecord;

$row = Yii::$app->db->createCommand('SELECT ba.*, bc.title AS category_title FROM `blogArticles` AS ba 
    LEFT JOIN `blogCategories` AS bc ON ba.idCategory = bc.id')
             ->queryOne();

$rowCat = array('title' => $row['category_title']);

var_dump($row);

/*
public static function instantiate($row)
{
    switch ($row['type']) {
        case SportCar::TYPE:
            return new SportCar();
        case HeavyCar::TYPE:
            return new HeavyCar();
        default:
           return new self;
    }
}
*/
$recordArt = \frontend\models\blog\articles\BlogArticles::instantiate($row);
$recordCat = \frontend\models\blog\categories\BlogCategories::instantiate($row);

$recordArtClass = get_class($recordArt);
$recordCatClass = get_class($recordCat);

$recordArtClass::populateRecord($recordArt, $row);
$recordCatClass::populateRecord($recordCat, $rowCat);


var_dump($recordArt);
var_dump($recordCat);

// $cName = isset($params['counter_cookie_name']) ? $params['counter_cookie_name'] : 'test_cookie';
//         //Если имя куки не передано, значит и не назначено в приложении. Или если имя
//         //передано, но куки не установлены - сделаем это тут...
//         $counter = Yii::$app->request->cookies->getValue($cName, 0);
//         Yii::$app->response->cookies->remove($cName);
//         Yii::$app->response->cookies->add(new Cookie([
//             'name' => $cName,
//             'value' => ++$counter,//eny
//             'expire' => time() + 86400 * 365,
//         ]));
//         echo $counter;
// var_dump(\Yii::$app->authManager->getDefaultRoles());

?>

<!------------------------------------------------------------------------------
                            header
--------------------------------------------------------------------------------
-->
<header>
    <div class="row header_line">
        
   <?php if (!\Yii::$app->user->isGuest): ?> 
        <div class="front-user-bar">
            <span class="color-wite">Привет,</span> <strong class="color-wite"><?= \Yii::$app->user->identity->username; ?></strong>
            <?php 
            if (\Yii::$app->user->can(Rbac::PERMISSION_ADMIN_PANEL)): ?>
                <?php echo $this->render('_admin-panel'); ?>
            <?php endif; ?>
        </div>    
    <?php endif; ?>
        
        <div class="col-lg-2 col-md-3 col-sm-5 col-xs-5 col-xxs-12 logo bg-darkRed">
            <a href="<?= Url::home(true); ?>">
                <span id="logo_word_1">CODER</span><!--  
                --><span class="fa fa-magic"></span><!--
                --><span id="logo_word_2">IUS</span>
            </a>
        </div>

        <div class="serviceLinks-top col-xs-7 visible-xs col-xxs-12">
            <ul>
                <?php if (\Yii::$app->user->isGuest): ?> 
                    <li><a title="Вход" href="<?= Url::toRoute(['/login']); ?>"><span class="fa fa-sign-in"></span></a></li>   
                
                    <?php else: ?>
                    
                    <li><a data-method="POST" title="Выход" href="<?= Url::toRoute(['/logout']); ?>"><span class="fa fa-sign-out"></span></a></li>   
                    
                <?php endif; ?>
                
            </ul>
        </div>

        <div class="col-xs-12 visible-xs bg-darkRed">
            <div class="row">
                <!--для мобильного меню-->
                <div class="menu_ico col-xs-4">
                    <i class="fa fa-bars menu--open"></i>
                    <i class="fa fa-times menu_ico--hide"></i>
                </div>

                <div style="height: 54px" class="search_form col-xs-7 col-xs-offset-1">
                    <?= $this->render('//layouts/base/fragments/_searchform'); ?>
                </div>
            </div>
        </div>

        <div class="col-sm-7 visible-sm">
            <div class="row">
                <div class="search_form col-sm-9">
                    <?= $this->render('//layouts/base/fragments/_searchform'); ?>
                </div>


                <div class="serviceLinks-top col-sm-3">
                    <ul>
                        <?php if (\Yii::$app->user->isGuest): ?> 
                            <li><a title="Вход" href="<?= Url::toRoute(['/login']); ?>"><span class="fa fa-sign-in"></span></a></li>   

                            <?php else: ?>

                            <li><a data-method="POST" title="Выход" href="<?= Url::toRoute(['/logout']); ?>"><span class="fa fa-sign-out"></span></a></li>   

                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

<!------------------------------------------------------------------------------------>        
<!--menu-->
        <nav class="col-lg-7 col-md-6 col-sm-12 col-xs-12 topNav">
            <ul>
                <?php if (isset($nav)): ?>
                <?php foreach ($nav as $item): ?>
                <?php if ($item->isActive()): ?>
                <li class="pMenu">
                    <a class="<?= \Yii::$app->fragmentHeader->isCurrentUrl($item->url) ? 'activeItem' : ''; ?>" href="<?php echo Url::toRoute($item->url); ?>"><?php echo $item->title; ?></a>
                    
                    <!--subMenu_moby_show включаем в js для моби версии-->
                    <?php if ($item->hasChildren()): ?>
                    <i class="fa fa-chevron-right toggleChevron"></i>
                    <ul class="subMenu">
                        <?php foreach ($item->children as $subItem): ?>
                            <li><a class="<?= \Yii::$app->fragmentHeader->isCurrentUrl($subItem->url) ? 'activeSubItem' : ''; ?>" href="<?php echo Url::toRoute($subItem->url); ?>"><?php echo $subItem->title; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </li> 
                <?php endif; ?>
                
                <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </nav>
<!--menu-->
<!--================================================================================-->

        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm">
            <div class="row">
                <div class="search_form col-md-9">
                    <?= $this->render('//layouts/base/fragments/_searchform'); ?>
                </div>


                <div class="serviceLinks-top col-md-3">
                    <ul>
                        <?php if (\Yii::$app->user->isGuest): ?> 
                            <li><a title="Вход" href="<?= Url::toRoute(['/login']); ?>"><span class="fa fa-sign-in"></span></a></li>   

                        <?php else: ?>

                            <li><a data-method="POST" title="Выход" href="<?= Url::toRoute(['/logout']); ?>"><span class="fa fa-sign-out"></span></a></li>   

                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
