<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\helpers\BaseStringHelper;
use yii\widgets\LinkPager;//для пагинации
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

//$this->title = 'Страницы сайта';
$this->params['breadcrumbs'][] = $h1;

?>
<div class="wrap">
    <header class="container-fluid">
        <div class="row header">
            <div class="col-xs-3">
                <div class="header__logo">
                    <span class="header__logo__slogan">Serg</span>
                    <span class="header__logo__slogan">@</span>
                    <span class="header__logo__slogan">Wizard</span>
                    <span class="header__logo__slogan">:</span>
                    <span class="header__logo__slogan">~</span>
                    <span class="header__logo__slogan">$</span>
                    <span class="header__logo__slogan cursorblick"></span>
                </div>
                
            </div>
            
            <div class="col-xs-4 header__menu">
                <div class="search_form">
                    <form action="/search" method="get">    
                        <input type="text" name="search" placeholder = "Поиск...">
                        <button type="submit"><i class="fa fa-search"></i></button>

                    </form>
                </div>
            </div>
            
            <div class="col-xs-5 header__socicons">

            </div>
            
            
            
        </div>
        
        <div class="row topmenu">
            <div class="col-xs-3">
                <div class="topmenu__slogan">
                    <span><i class="fa fa-globe"></i>Блог о веб разработке</span>
                </div>
                
            </div>
            
            <div class="col-xs-9 topmenu__nav">
                <nav>
                  <ul>
                        <li><a href="">Блог</a></li> 
                        <li><a href="">Обо мне</a></li>
                        <li><a href="">Услуги</a></li>
                        <li><a href="">Контакты</a></li> 
                  </ul>
                </nav>
            </div>
            
        </div>
        
        
    </header>

    <div class="container">
        <?= Breadcrumbs::widget([
            'homeLink' => [ 
                      'label' => Yii::t('blog-main', 'Home'),
                      'url' => Yii::$app->homeUrl,
                 ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        
    </div>
    
    <div class="container centerblock">
        <div class="row">
            <div class="col-xs-9  centerblock__content">
                <h1 class="headind-style-1"><span class="marker-heading"><span class="glyphicon glyphicon-education"></span></span>Статьи.</h1>
                
                <div class="row margin-b-20 box-style">
                    <div class="col-xs-12 centerblock__content__block">
                        <h3>
                            <span class="glyphicon glyphicon-book"></span>
                            <a href="/DBUnit.html">DBUnit - тестирование php-методов работающих с базой данных.</a>	
                        </h3>
                        
                        <div class="centerblock__content__block__postmeta">
                            <span class="centerblock__content__block__postmeta__author">Автор: Сергей</span>
                            <span class="centerblock__content__block__postmeta__date">Дата публикации: 18.10.2017</span>
                            <span class="centerblock__content__block__postmeta__comment">Комментариев: 0</span>
                        </div>

                        <div class="row centerblock__content__block__article">
                            <div class="centerblock__content__block__article-img col-sm-5">			
                                <a href="/DBUnit.html">
                                    <?php echo Html::img('@img-web-blog-posts/1/4.jpg', ['alt'=>'Картинка поста', 'class'=>'img-gum']);?>
                                </a>			
                            </div>

                            <div class="centerblock__content__block__article-text col-sm-7">
                                <!--Если отсутствует анонс поста - берем из контента первые слова-->
                                В данной статье рассмотрено дополнение к фреймворку для тестирования PHPUnit - DBUnit, которое упрощает тестирование методов работающих с базой данных. 
                                В данной статье рассмотрено дополнение к фреймворку для тестирования PHPUnit - DBUnit, которое упрощает тестирование методов работающих с базой данных. 


                            </div>
                        </div>
                        
                        <div class="centerblock__content__block-count_look text-right">
                            <p class="centerblock__content__block__article-text-read_more">
                                <a class="button-squere" href="/DBUnit.html">Читать далее</a>			
                            </p>
                            <span class="glyphicon glyphicon-eye-open brown"></span>
                            <span class="small-italic lite-grey">Просмотров:</span> 
                            <span class="post-info-look lite-grey-bold">44</span>

                        </div>
                        
                        <div class="centerblock__content__block-post-info">
                            <div class="listarea">			
                                <span class="glyphicon glyphicon-folder-open brown"></span>
                                <span class="post-info-category">Категория: <a class="trans" href="/category/php">PHP</a></span>
                                <span class="padding-l-10"></span>
                                <span class="glyphicon glyphicon-tags brown"></span>
                                <span class="post-info-tags">			
                                    <a class="trans" href="/tag/MySQL">БД MySQL</a>, <a class="trans" href="/tag/phpunit">PHPUnit</a>				
                                </span>

                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="row margin-b-20 box-style">
                    <div class="col-xs-12 centerblock__content__block">
                        <h3>
                            <span class="glyphicon glyphicon-book"></span>
                            <a href="/DBUnit.html">DBUnit - тестирование php-методов работающих с базой данных.</a>	
                        </h3>
                        
                        <div class="centerblock__content__block__postmeta">
                            <span class="centerblock__content__block__postmeta__author">Автор: Сергей</span>
                            <span class="centerblock__content__block__postmeta__date">Дата публикации: 18.10.2017</span>
                            <span class="centerblock__content__block__postmeta__comment">Комментариев: 0</span>
                        </div>

                        <div class="row centerblock__content__block__article">
                            <div class="centerblock__content__block__article-img col-sm-5">			
                                <a href="/DBUnit.html">
                                    <?php echo Html::img('@img-web-blog-posts/1/4.jpg', ['alt'=>'Картинка поста', 'class'=>'img-gum']);?>
                                </a>			
                            </div>

                            <div class="centerblock__content__block__article-text col-sm-7">
                                <!--Если отсутствует анонс поста - берем из контента первые слова-->
                                В данной статье рассмотрено дополнение к фреймворку для тестирования PHPUnit - DBUnit, которое упрощает тестирование методов работающих с базой данных. 
                                В данной статье рассмотрено дополнение к фреймворку для тестирования PHPUnit - DBUnit, которое упрощает тестирование методов работающих с базой данных. 


                            </div>
                        </div>
                        
                        <div class="centerblock__content__block-count_look text-right">
                            <p class="centerblock__content__block__article-text-read_more">
                                <a class="button-squere" href="/DBUnit.html">Читать далее</a>			
                            </p>
                            <span class="glyphicon glyphicon-eye-open brown"></span>
                            <span class="small-italic lite-grey">Просмотров:</span> 
                            <span class="post-info-look lite-grey-bold">44</span>

                        </div>
                        
                        <div class="centerblock__content__block-post-info">
                            <div class="listarea">			
                                <span class="glyphicon glyphicon-folder-open brown"></span>
                                <span class="post-info-category">Категория: <a class="trans" href="/category/php">PHP</a></span>
                                <span class="padding-l-10"></span>
                                <span class="glyphicon glyphicon-tags brown"></span>
                                <span class="post-info-tags">			
                                    <a class="trans" href="/tag/MySQL">БД MySQL</a>, <a class="trans" href="/tag/phpunit">PHPUnit</a>				
                                </span>

                            </div>
                        </div>
                        
                    </div>
                </div>
        
            </div> 
            
            <div class="col-xs-3 centerblock__sidebar">
                <div class="box-style margin-b-20">
                    <div class="row ">
                        <div class="col-xs-12">
                            <div class="centerblock__sidebar-heading">
                                <h4>Рубрики</h4>
                            </div>
                        </div>
                        <div class="col-xs-12 centerblock__sidebar-content">
                            <ul class="centerblock__sidebar-content__categoty-list">
                                <li class="active"><a href="">Yii2</a></li>
                                <li><a href="">PHP</a></li>
                                <li><a href="">Html + Css</a></li>
                                <li><a href="">Javascript</a></li>
                                <li><a href="">Jquery</a></li>
                            </ul>
                        </div>
                        
                    </div>
                </div>
                
                <div class="box-style margin-b-20">
                    <div class="row ">
                        <div class="col-xs-12">
                            <div class="centerblock__sidebar-heading">
                                <h4>Темы</h4>
                            </div>
                        </div>
                        <div class="col-xs-12 centerblock__sidebar-content">
                            <ul class="centerblock__sidebar-content__tag-list">
                                <li class="active"><a href="">Yii2</a></li>
                                <li><a href="">PHP</a></li>
                                <li><a href="">Html + Css</a></li>
                                <li><a href="">Javascript</a></li>
                                <li><a href="">Jquery</a></li>
                            </ul>
                        </div>
                        
                    </div>
                </div>
                
                <div class="box-style margin-b-20">
                    <div class="row ">
                        <div class="col-xs-12">
                            <div class="centerblock__sidebar-heading">
                                <h4>Популярные посты</h4>
                            </div>
                        </div>
                        <div class="col-xs-12 centerblock__sidebar-content">
                            <ul class="centerblock__sidebar-content__posts-list">
                                <li>
                                    <p class="centerblock__sidebar-content__posts-list_head">
                                        Использование событий в PHP.
                                    </p>
                                    <div class="centerblock__sidebar-content__posts-list_content">
                                        Приведены примеры создания и использования событий в php.
                                        Приведены примеры создания и использования событий в php.
                                    </div>
                                    <p class="centerblock__sidebar-content__posts-list_head_button">
                                        <a href="">Читать</a>
                                    </p>
                                </li>
                                
                                <li>
                                    <p class="centerblock__sidebar-content__posts-list_head">
                                        Использование событий в PHP.
                                    </p>
                                    <div class="centerblock__sidebar-content__posts-list_content">
                                        Приведены примеры создания и использования событий в php.
                                        Приведены примеры создания и использования событий в php.
                                    </div>
                                    <p class="centerblock__sidebar-content__posts-list_head_button">
                                        <a href="">Читать</a>
                                    </p>
                                </li>
                                
                            </ul>
                        </div>
                        
                    </div>
                </div>
                
                <div class="box-style margin-b-20">
                    <div class="row ">
                        <div class="col-xs-12">
                            <div class="centerblock__sidebar-heading">
                                <h4>Новые посты</h4>
                            </div>
                        </div>
                        <div class="col-xs-12 centerblock__sidebar-content">
                            <ul class="centerblock__sidebar-content__new-posts">
                                <li><a href="">Использование событий в PHP.</a></li>
                                <li><a href="">Перед изучением каких-либо готовых .</a></li>
                                <li><a href="">Использование событий в PHP.</a></li>
                            </ul>
                        </div>
                        
                    </div>
                </div>
                
            </div> 
        </div> 
    </div>  
  
    
    <footer class="container-fluid">
        <div class="row footer">
            <div class="col-xs-9">
                <div class="row">
                    <div class="col-xs-12 footer__menu padding-b-20">
                        <nav>
                            <ul>
                                <li><a href="">Блог</a></li> 
                                <li><a href="">Обо мне</a></li>
                                <li><a href="">Услуги</a></li>
                                <li><a href="">Контакты</a></li> 
                            </ul>
                        </nav>
                    </div>
                    
                    <div class="col-xs-4 footer__copy margin-t-20">
                        <p><strong>Serg Wizard</strong> &copy; My Company <?= date('Y') ?></p>
                        <p class="copy-rule">Копирование материалов сайта разрешено только при наличии активной ссылки.</p>
                    </div>
                    <div class="col-xs-8 footer__about margin-t-20">
                        <div class="row">
                            <div class="col-xs-1 footer__about-avatarbox">
                                <a href="/DBUnit.html">
                                    <?php echo Html::img('@img-web-users/1/123.jpeg', ['alt'=>'Аватарка админа', 'class'=>'footer-avatar']);?>
                                </a>
                            </div>
                            <div class="col-xs-11">
                                <strong>Блог профессионального веб разработчика.</strong>
                                <p><i>Принимаю заказы на создание сайтов любой сложности.</i></p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-3 footer__contacts">
                <p class="footer__contacts__heading">
                    Мои контакты
                </p>
                <ul class="footer__contacts-icons">
                    <li id="twitter-icon"><a href=""></a></li> 
                    <li id="facebook-icon"><a href=""></a></li>
                    <li id="google-icon"><a href=""></a></li>
                    <li id="youtube-icon"><a href=""></a></li> 
                </ul>
                
            </div>




        </div>

    </footer>
    
</div>