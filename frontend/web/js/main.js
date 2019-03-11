//Определение ширины соответствующей @media only screen and (max-width : 768px)
var media_maxWidth768px = function(){
    if ( Modernizr.mq('only screen and (max-width : 768px)') ) {
        return true;
    }else{
        return false;
    }
};

//раскрытие меню в мобильной версии по клику на иконке
var mobyMenuShow = function(){
    var topNav = $(".topNav");
    var menuOpen = $('.menu--open');
    var menuClose = $('.menu--close');
    
    $(document).off('click.mobyMenuShow');
    
        if (media_maxWidth768px()) {
            
            $(document).on("click.mobyMenuShow", ".menu_ico i", function(e) {
                var time = performance.now();
                var self = $(this);

                
                topNav
                        .toggleClass('topNav--show')
                        .queue(function() {
                            self.addClass("menu_ico--hide");
                            self.siblings("i").removeClass("menu_ico--hide");
                            $(this).dequeue();
                        });

                
                time = performance.now() - time;
                console.log('Время выполнения = ', time);
            });
        
        } else {
            if( topNav.hasClass('topNav--show') ){
                menuOpen.addClass("menu_ico--hide");
                menuClose.removeClass("menu_ico--hide");
            }else{
                menuOpen.removeClass("menu_ico--hide");
                menuClose.addClass("menu_ico--hide");
                
            }
//            topNav.each(function (indx, element) {
//                if($(element).hasClass('menu_ico--hide')){
//                    $(element).removeClass("menu_ico--hide");
//                }
//            });
//            
//            if(menuOpen.hasClass('menu_ico--hide')){
//                menuOpen.removeClass("menu_ico--hide");
//                menuClose.addClass("menu_ico--hide");
//            }
        }
    
    
};


//Обработка клика на стрелке меню, для вложенного меню в мобильной версии
var menuToggle = function(){
    $(document).off('click.mynamespace');//чтобы не создавались повторно обработчики, т.к. тогда событие будет при одном клике срабатывать много раз 
    if (media_maxWidth768px()) {
//            console.log( 'Modernizr.mq ' );
            $(document).on("click.mynamespace", ".toggleChevron", function(e) {
//                console.log( 'click ' );
                
                var self = $(this);
                var subMenu = self.siblings(".subMenu");
                
                var hendler = function(){
                    if(subMenu.hasClass('subMenu_moby_show')){
                        subMenu.removeClass("subMenu_moby_show");
                        self.removeClass("toggleChevron_rotate");
                        console.log( 1 );
//                        return;

                    }else{
                        subMenu.addClass("subMenu_moby_show");
                        self.addClass("toggleChevron_rotate");
                        console.log( 0 );
//                        return;

                    }
                    
//                    console.log( subMenu.hasClass('subMenu_moby_show'));
                };
                
                setTimeout(hendler, 100);
                
//                e.stopPropagation(); // Отмена всплытия

            });
        
    } else {
        $(".subMenu").each(function (indx, element) {
            if($(element).hasClass('subMenu_moby_show')){
                $(element).removeClass("subMenu_moby_show");
            }
        });
        
        
        
        

    }
};



$( document ).ready(function() {
    console.log( "ready!" );
    
    var $window = $(window);
    var wwidth = $window.width();
    
    mobyMenuShow();
    menuToggle();
    
    $window.on('resize.mynamespace', function(e) {
        //только при горизонтально ресайзинге
        if ($window.width() !== wwidth){
            wwidth = $window.width();
            mobyMenuShow();
            menuToggle();
        } 
        
        
    });
    
    

    
});

