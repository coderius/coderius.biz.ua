;(function ($, window, document, undefined) {
    'use strict';

    var methods = {
        init: function (options) {
            
            return this.each(function () {
                var opt = $.extend(true, {}, $.fn.thumbs.defaults, options);
                
                
                methods.make.call(this, opt);
                
                methods.setLike.call(this, opt.like);
//                console.log(opt.like);
                methods.setDislike.call(this, opt.dislike);
                
            });
        },
        
        make: function (opt) {
            var self = this;
            var like = methods.getLike.call(self, opt),
                dislike = methods.getDislike.call(self, opt),
                id = Math.round(1E6 * Math.random()) + Date.now();
            
            $(self)
                .addClass(opt.classCss)
                .attr('data-id-review', id)
                .append($('<div>').addClass('sprite sprite-fa-thumbs-up-grey').attr('id', 'set-up-control'),
                    $('<div>').addClass('jq-rating-like').html(like),
                    $('<div>').addClass('sprite sprite-fa-thumbs-down-grey').attr('id', 'set-down-control'),
                    $('<div>').addClass('jq-rating-dislike').html(dislike));
                    
            if(opt.isActiveLike){
                methods.setActiveLike.call($(self));
            }  
            
            if(opt.isActiveDislike){
                methods.setActiveDislike.call($(self));
            }
                    
            $(self)
                .find('#set-up-control')
                .on('click', function () {
                    var likes = methods.getLike.call($(self));
                    if (typeof opt !== 'undefined' && $.isFunction(opt.onLike)) {
                        opt.onLike(likes, self, methods);
                    }
                });

            $(self)
                .find('#set-down-control')
                .on('click', function () {
                    var dislikes = methods.getDislike.call($(self));
                    if (typeof opt !== 'undefined' && $.isFunction(opt.onDislike)) {
                        opt.onDislike(dislikes, self, methods);
                    }
                });        
                    
        },
        
        getLike: function (opt) {
            return $(this).attr('data-like');
        },
        
        getDislike: function (opt) {
            return $(this).attr('data-dislike');
        },
        
        setLike: function (val) {
//            console.log(val);
            $(this).attr('data-like', val).find('.jq-rating-like').html(val);
            
        },
        
        setDislike: function (val) {
            $(this).attr('data-dislike', val).find('.jq-rating-dislike').html(val);
        },
        
        ///////////
        setActiveLike: function () {
            $(this).find('#set-up-control')
                    .removeClass('sprite-fa-thumbs-up-grey')
                    .addClass('sprite-fa-thumbs-o-up-green');
        },
        
        setActiveDislike: function () {
            $(this).find('#set-down-control')
                    .removeClass('sprite-fa-thumbs-down-grey')
                    .addClass('sprite-fa-thumbs-o-down-green');
        },
        
        removeActiveLike: function () {
            $(this).find('#set-up-control')
                    .removeClass('sprite-fa-thumbs-o-up-green')
                    .addClass('sprite-fa-thumbs-up-grey');
        },
        
        removeActiveDislike: function () {
            $(this).find('#set-down-control')
                    .removeClass('sprite-fa-thumbs-o-down-green')
                    .addClass('sprite-fa-thumbs-down-grey');
        },
        
        switchToActiveLike: function () {
            var self = $(this);
            methods.setActiveLike.call($(self));
            methods.removeActiveDislike.call($(self));
        },
        
        switchToActiveDislike: function () {
            var self = $(this);
            methods.setActiveDislike.call($(self));
            methods.removeActiveLike.call($(self));
        },
        
    };

    $.fn.thumbs = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist!');
        }
    };

    $.fn.thumbs.defaults = {
        classCss: 'jq-rating',
        like: 0,
        dislike: 0,
        isActiveLike: false,
        isActiveDislike: false
    };
})(jQuery, window, document);