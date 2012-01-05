$.mobile.loadingMessage = $AB.t('generic', 'Loading...');
$.mobile.pageloadErrorMessage = $AB.t('generic', 'The page could not be loaded!');
$.mobile.listview.prototype.options.filterPlaceholder = $AB.t('generic', 'Search...');

$(window).unload(function(){
    $.mobile.showPageLoadingMsg();
});

$(function(){
    $('a[href=\\#]').click(function(e){
        e.preventDefault();
    });
    $('a[target=_blank], a[href^=http]').click(function(e){
        if (confirm($AB.t('generic', 'Do you want to open this link in a new window?')))
        {
            window.open(this.href);
        }
        e.preventDefault();
    });
    $('*[title]').on('taphold', AdminBukkit.tooltipHandler);
    $('div#container').on('swiperight', history.back);
});