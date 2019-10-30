$(function() {
    //settings plugin advansed textarea tools
    $('#comment-form_content').trumbowyg(
            {
                lang: 'ru',
                btns: [
                    ['preformatted'],
                    ['strong', 'em'],
                    ['link'],
                    ['insertImage'],
                    ['unorderedList', 'orderedList'],
                    ['undo', 'redo'],
                    ['fullscreen']
                ],
                imageWidthModalEdit: true,
                autogrow: true
                
            }
    );
    
    //gorizontal line in comments tree to line parent comment
    function line(){
        var after = $('<div class="jsLiAfter"></div>');
        $('.reply-list li').append(after);
        $('li .jsLiAfter').each(function(index,element){
            var pic = $(element).closest('li').find('.comment-avatar');
            var fatnessSize = $(element).css('height');
            var positionTop = pic.height()/2 + parseInt(fatnessSize) ;
            $(element).css("top", positionTop );
            console.log(parseInt(fatnessSize));
        });
    };
    
    line();
    
    $(window).resize(function(){
        line();
    }); 
    
    
    //hendler button reply in comment window
    var dataActionReply = 'reply',
        $commentsContainer = $('.comments-container'),
        $commentsList = $('#comments-list'),
        $commenFormContainer =  $('.comment-form-container'),
        $hiddenInputParentId = $commenFormContainer.find('[data-comment="parent-id"]'),
        $cancelReply = $commenFormContainer.find('#cancel-reply');
    
    
    var $buttonsReply = $commentsList.find('[data-action="' + dataActionReply + '"]');
    
    $( document ).on('click', '[data-action="' + dataActionReply + '"]', function(e){
        
        e.preventDefault();
        var $modelId = $(this).data("comment-id"),
            $commenFormContainer =  $('.comment-form-container'),
            $hiddenInputParentId = $commenFormContainer.find('[data-comment="parent-id"]');
        
        //remove to comment block
        var $commentContent = $(this).closest('.comment-box').find('.comment-content');
        $commenFormContainer.appendTo($commentContent);
        
        //set model id in form hidden input (parent comment)
        $hiddenInputParentId.val($modelId);
        
        $(this).find('i').addClass('add-color-green');
        
//        console.log($commentContent.text());
    });
    
    
    //cencel  reply
    $( document ).on('click', '#cancel-reply', function(e){
        
        e.preventDefault();
        var $modelId = $(this).data("comment-id"),
            $commenFormContainer =  $('.comment-form-container'),
            $hiddenInputParentId = $commenFormContainer.find('[data-comment="parent-id"]');
            $(this).closest('.comment-box').find('[data-action="' + dataActionReply + '"]').find('i').removeClass('add-color-green');
        //remove to comments Container 
        $commenFormContainer.appendTo($commentsContainer);
        
        //reset model id in form hidden input (parent comment)
        $hiddenInputParentId.val('');
        
        
//        console.log($(this).closest('.comment-box').find('[data-action="' + dataActionReply + '"]'));
    });
    
   
    //comment likes hendler
    var $buttonsLikecomment = $commentsList.find('.like-comment-btn');
    
    $( document ).on('click','.like-comment-btn',  function(e){
        e.preventDefault();
        var $modelId = $(this).data("comment-id");
        var $commentLikeCount = $(this).find('.comment-like-count');
            $(this).find('i').toggleClass('add-color-green');
            $.ajax({
                    'type' : 'POST',
                    'url' : '/comments/default/ajax-like',
                    'dataType' : 'json',
                    'data' : {commentId: $modelId},
                    'success' : function(data){
                        if(data.status === 'success'){
                            $commentLikeCount.text(data.like);
                            
                        }else{
                            console.log(data);
                        }
                        
                        
                        
                    },
                    'error' : function(request, status, error){
                            console.log('ошибка');
                            console.log(status);
                            console.log(error);
                    }
            });
            
    });
    var $googleRecaptcha = $("#google-recaptcha").clone();
    console.log($googleRecaptcha);
    //desibled comment button
    $( document ).on('click', '#desibled-comment-btn', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var $modelId = $(this).data("comment-id");
        $.ajax({
                'type' : 'POST',
                'url' : url,//'/comments/default/desibled-comment'
                'dataType' : 'json',
                'data' : {commentId: $modelId},
                'success' : function(data){
                    if(data.status === 'success'){
                        console.log(data);
                        var url  = window.location.href; 
                        $( "#ajax-comments-container" ).load( url + " #ajax-comments-container > *", function(responseText) {
                            $('#comment-form').find("input[type=text], textarea").val("");
//                            console.log($('#comment-form').find("input[type=text], textarea"));
                                $('#comment-form_content').trumbowyg(//чтобы работало после загрузки
                                        {
                                            lang: 'ru',
                                            btns: [
                                                ['preformatted'],
                                                ['strong', 'em'],
                                                ['link'],
                                                ['insertImage'],
                                                ['unorderedList', 'orderedList'],
                                                ['undo', 'redo'],
                                                ['fullscreen']
                                            ],
                                            imageWidthModalEdit: true,
                                            autogrow: true

                                        }
                                );
//                        console.log($(responseText).find("#google-recaptcha"));
//                        $(responseText).find("#google-recaptcha").after($googleRecaptcha).remove();
//                            $.getScript("https://www.google.com/recaptcha/api.js?onload=onloadCallback&amp;render=explicit", function(data, textStatus){alert("Скрипт выполнен.");});    
                        } );

                    }else{
                        console.log(data);
                    }



                },
                'error' : function(request, status, error){
                        console.log('ошибка');
                        console.log(status);
                        console.log(error);
                }
            });
        
    });
    
    //active comment button
    $( document ).on('click', '#active-comment-btn', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var $modelId = $(this).data("comment-id");
        $.ajax({
                'type' : 'POST',
                'url' : url,//'/comments/default/desibled-comment'
                'dataType' : 'json',
                'data' : {commentId: $modelId},
                'success' : function(data){
                    if(data.status === 'success'){
                        console.log(data);
                        var url  = window.location.href; 
//                        $.getScript("https://www.google.com/recaptcha/api.js?onload=onloadCallback&amp;render=explicit", function(data, textStatus){alert("Скрипт выполнен.");});    
                        $( "#ajax-comments-container" ).load( url + " #ajax-comments-container > *", function(responseText) {
                            $('#comment-form').find("input[type=text], textarea").val("");
//                            console.log($('#comment-form').find("input[type=text], textarea"));
                                $('#comment-form_content').trumbowyg(//чтобы работало после загрузки
                                        {
                                            lang: 'ru',
                                            btns: [
                                                ['preformatted'],
                                                ['strong', 'em'],
                                                ['link'],
                                                ['insertImage'],
                                                ['unorderedList', 'orderedList'],
                                                ['undo', 'redo'],
                                                ['fullscreen']
                                            ],
                                            imageWidthModalEdit: true,
                                            autogrow: true

                                        }
                                );
//                        console.log($(responseText).find("#google-recaptcha"));
//                            $(responseText).find("#google-recaptcha").after($googleRecaptcha).remove();
                        } );

                    }else{
                        console.log(data);
                    }



                },
                'error' : function(request, status, error){
                        console.log('ошибка');
                        console.log(status);
                        console.log(error);
                }
            });
        
        
    });
    
    //Submit new message
    var $formComment = $('#comment-form');
    $( document ).on('submit', '#comment-form', function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        var form = $(this);
        var $action = $(this).attr( 'action' );
//        $(this).find('.comment-submit').attr('disabled','disabled');
//        console.log($(this));
        $.ajax({
                'type' : 'POST',
                'url' : $action,
                'dataType' : 'json',
                'data' : $(this).serialize(),
                'beforeSend': function (data) {
                    $(this).show();
                },
                'success' : function(data){
                    $(this).hide();
                    if(data.status === 'success'){
                        console.log(data);
//                        window.location.reload(true);
                        var url  = window.location.href; 
//                        $.getScript("https://www.google.com/recaptcha/api.js?onload=onloadCallback&amp;render=explicit", function(data, textStatus){alert("Скрипт выполнен.");});    
                        $( "#ajax-comments-container" ).load( url + " #ajax-comments-container > *", function(responseText) {
                            $('#comment-form').find("input[type=text], textarea").val("");
//                            console.log($('#comment-form').find("input[type=text], textarea"));
                                $('#comment-form_content').trumbowyg(//чтобы работало после загрузки
                                        {
                                            lang: 'ru',
                                            btns: [
                                                ['preformatted'],
                                                ['strong', 'em'],
                                                ['link'],
                                                ['insertImage'],
                                                ['unorderedList', 'orderedList'],
                                                ['undo', 'redo'],
                                                ['fullscreen']
                                            ],
                                            imageWidthModalEdit: true,
                                            autogrow: true

                                        }
                                );
//                        $(responseText).find('script').appendTo( "#ajax-comments-container" );
                              
//                                grecaptcha.reset();
                        } );


                    }else if(data.status === 'errorValidate'){
                        console.log(data);
                        
                        form.find( "input, textarea").each(function( index, elem ) {
                            $(elem).removeClass('has-error');
                            $(elem).closest('.form-group').find('.help-block').html("");
                            
                            $.each( data.error, function( index, value ){
                                var strattr = 'CommentsForm['+index+']';
//                                console.log(strattr);
                                if($(elem).attr('name') === strattr){

                                    $(elem).closest('.form-group').addClass('has-error');
                                    $(elem).closest('.form-group').find('.help-block').html( value[0] );
                                }
                            });
                        });
                        
                        
                        var updateCaptchaImg = function(url){
                            $('.field-commentsform-verifycode').load( url + " .field-commentsform-verifycode > *", function(responseText) {
//                                console.log(url + " .field-commentsform-verifycode > *");
                            });
                        };
                        if(true === data.captchaRefresh){
                            updateCaptchaImg(window.location.href);
                        }
                        
                        
                    }else{
                        console.log(data);
                    }



                },
                'error' : function(request, status, error){
                        console.log('status:' + status);
                        console.log('error:' + error);
                }
            });
        
    });
    
});


