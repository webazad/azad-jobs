;(function($){
    $(document).ready(function(){
        var sortList = $('ul#custom-type-list');
        var animation = $('#loading-animation');
        var pageTitle = $('div h1');
        sortList.sortable({
            update: function(){
                animation.show();
                $.ajax({
                    url: 'ajaxurl',
                    type: 'POST',
                    data: {
                        action:'save_sort'
                    },
                    success: function(){
                        $('div#message').remove();
                        animation.hide();
                        pageTitle.after('<div id="message" class="updated below"><p>Hi htere</p></div>');
                    },
                    error: function(){
                        $('div#message').remove();
                        animation.hide();
                        pageTitle.after('<div id="message" class="error below"><p>Hi htere</p></div>');
                    }
                });
            }
        });
    });
})(jQuery);