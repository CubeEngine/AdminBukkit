$.mobile.loadingMessage = AdminBukkit.t('generic', 'Loading...');
$.mobile.pageloadErrorMessage = AdminBukkit.t('generic', 'The page could not be loaded!');
$.mobile.listview.prototype.options.filterPlaceholder = AdminBukkit.t('generic', 'Search...');
$.mobile.defaultPageTransition = 'slide';

$(window).unload(function(){
    $.mobile.showPageLoadingMsg();
});

$(function(){
    $('a[href=\\#]').click(function(e){
        e.preventDefault();
    });
    $('a[target=_blank], a[href^=http]').click(function(e){
        e.preventDefault();
        if (confirm(AdminBukkit.t('generic', 'Do you want to open this link in a new window?')))
        {
            window.open(this.href);
        }
    });
    $('*[title]').on('taphold', AdminBukkit.tooltipHandler);
    $('div.ui-header').on('taphold', function(){
        AdminBukkit.redirectTo(BASE_PATH);
    })
    $('div#container')
        .on('swiperight', function(){
            history.back();
        })
        .on('swipeleft', function(){
            history.forward();
        });
});