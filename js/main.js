var genericLang = new GenericLang();

function urlencode(str)
{
    function parse(match)
    {
        var dec = parseInt(match.substr(1), 16)
        if (dec > 127)
        {
            return String.fromCharCode(dec);
        }
        return match;
    }
    
    return escape(str).replace(/%[a-f0-9]{2}/ig, parse);
}

function setProgress(state)
{
    if (state)
    {
        $('#progress').css('display', 'block');
        var progressWidth = document.getElementById('progress').offsetWidth / 2;
        var windowWidth = window.innerWidth / 2;
        $('#progress').css('left', (windowWidth - progressWidth) + 'px');
    }
    else
    {
        $('#progress').css('display', 'none');
    }
}

function redirectTo(target)
{
    if (target)
    {
        if (SESS_APPEND)
        {
            target = appendSession(target);
        }
        document.location.href = target;
    }
}

function appendSession(target)
{
    if (!target.match(new RegExp(SESS_QUERY, 'i')))
    {
        target += (target.match(/\?/) ? '&' : '?') + SESS_QUERY;
    }
    return target;
}

function linkHandler(e)
{
    if (e.isDefaultPrevented())
    {
        return false;
    }
    setProgress(true);
    $(this).addClass('active');
    redirectTo(this.href);
    return false;
}

function touchTooltipHandler(e)
{
    e.preventDefault();
    var $target = $(e.target);
    var $timeout = setTimeout(attachTooltip, 200);
    var $tooltip = null;
    
    function attachTooltip()
    {
        $tooltip = $('<div class="touchTooltip"><div>' + $target.attr('title') + '</div></div>');
        var pos = $target.position();
        $tooltip.css('top', pos.top + e.target.offsetHeight + 'px');
        $tooltip.css('left', pos.left + 'px');
        $tooltip.css('max-width', (window.innerWidth - pos.left - 5) + 'px');
        $tooltip.bind('touchstart', function(){
            $tooltip.remove();
        });
        $(document.body).append($tooltip);
    }
    
    function removeTooltip()
    {
        $target.unbind('touchmove', removeTooltip).unbind('touchend', removeTooltip);
        clearTimeout($timeout);
        if ($tooltip != null)
        {
            setTimeout(function(){
                $tooltip.remove();
            }, 2000);
        }
    }
    
    $target.bind('touchend', removeTooltip).bind('touchmove', removeTooltip);
}

function historyBack(e)
{
    window.history.back();
}

function prepareForm(query)
{
    if (SESS_APPEND)
    {
        $(query).append($('<input>').attr('type', 'hidden')
                        .attr('name', SESS_NAME)
                        .attr('value', SESS_ID));
    }
    $(query + ' .submit').click(function(){
        $(query).submit();
    });
    $(query).submit(function(){
        setProgress(true);
    });
    $(window).bind('keypress', function(e){
        if (e.which == 13)
        {
            $(query).submit();
        }
    });
}

function prepareOverlay(query)
{
    $(query).css('padding-top', $('.toolbar').height() + 10);
    $(query).click(function(e){
        toggleOverlay(query);
    });
    $('.toggleoverlay').click(function(e){
        e.preventDefault();
        toggleOverlay(query);
    });
}

function toggleOverlay(query)
{
    $(query).toggle('fast');
    if (typeof scroller != 'undefined')
    {
        scroller.refresh();
        scroller.scrollTo(0, 0);
    }
}

function realSort(a, b)
{
    a = a.toLowerCase();
    var array = new Array(a, b.toLowerCase());
    return (array.sort()[0] == a ? -1 : 1);
}

$(window).unload(function(){
    ready = false;
    setProgress(true);
});

var shakeListener = new WKShake();
shakeListener.start();

$(function(){
    ready = true;
    if (typeof init == 'function')
    {
        init();
    }
    $('a[href=\\#]').click(function(e){
        e.preventDefault();
    });
    $('a[target=_blank], a[href^=http]').click(function(e){
        if (confirm(genericLang.confirm_openlink))
        {
            window.open(this.href);
        }
        e.preventDefault();
    });
    $('a[href]:not(a[target=_blank])').click(linkHandler);
    $('.toolbar a.back').click(historyBack);
    $('*[title]').live('touchstart', touchTooltipHandler);
});