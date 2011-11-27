$.mobile.loadingMessage = $AB.t('generic', 'Loading...');
$.mobile.pageloadErrorMessage = $AB.t('generic', 'The page could not be loaded!');
$.mobile.listview.prototype.options.filterPlaceholder = $AB.t('generic', 'Search...');

String.prototype.t = function(cat) {
    return AdminBukkit.t(cat, this);
}

alert('test'.t('generic'));

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
    //$('*[title]').live('touchstart', touchTooltipHandler);
});