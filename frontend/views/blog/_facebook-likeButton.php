<?php

/**
 * Facebook like button
 */
?>
<!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v3.1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

  <!-- Your like button code -->
  <div class="fb-like" 
    data-href="<?= Yii::$app->seo->currentFacebookOgUrl; ?>" 
    data-layout="button" 
    data-action="like" 
    data-size="large" 
    data-share="false" 
    data-show-faces="false">
  </div>
  
  <div class="fb-share-button" 
       data-href="<?= Yii::$app->seo->currentFacebookOgUrl; ?>" 
       data-layout="button_count" 
       data-size="large" 
       data-mobile-iframe="true">
      <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Поделиться</a>
  </div>
