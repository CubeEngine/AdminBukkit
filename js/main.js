var genericLang = new GenericLang();

var errors = {
    '-1': genericLang.error_unknown,
    1: genericLang.error_invalidpath,
    2: genericLang.error_wrongpass,
    3: genericLang.error_ctlrerror,
    4: genericLang.error_notimplemented,
    5: genericLang.error_apinotfound
}

var ready = false;

$.fn.tap = function(callback)
{
    $(this).bind('tap', callback);
}
 
function isDefined(target)
{
    return (typeof target !== 'undefined');
}

function apiBeforeSend()
{
    setProgress(true);
}
function apiComplete()
{
    setProgress(false);
}
function apiError(jqXHR, textStatus, thrownError)
{
    errorCode = jqXHR.responseText.split(',')[0];
    alert(genericLang.ajax_error.replace('{0}', errors[errorCode]));
    if (errorCode == "2")
    {
        redirectPage('home');
    }
}
function apiCall(controller, action, success, data, method, noprogress, sync)
{
    if (!ready)
    {
        return null;
    }
    if (!isDefined(controller) || !isDefined(controller))
    {
        debugMsg("controller or action not given!");
        return null;
    }
    var url = 'backend/apiproxy.php/' + controller + '/' + action;
    if (!isDefined(data))
    {
        data = {};
    }
    if (!isDefined(method))
    {
        method = 'GET';
    }
    if (!isDefined(success))
    {
        success = null;
    }
    if (SESS_APPEND)
    {
        url = appendSession(url);
    }
    var options = {
        url: url,
        data: data,
        type: method,
        success: success,
        error: apiError,
        async: !sync
    }
    if (!options.async)
    {
        options.timeout = 2;
    }
    if (!noprogress)
    {
        options.beforeSend = apiBeforeSend;
        options.complete = apiComplete;
    }
    return $.ajax(options);
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

function touchHandler(e)
{
    e.preventDefault();
    $('.toolbar h1').html('touch started');
    var target = $(e.target);
    var moved = false;
    
    function touchMove()
    {
        $('.toolbar h1').html('touch moved');
        moved = true;
    }
    
    function touchEnd()
    {
        $('.toolbar h1').html('touch ended');
        if (!moved)
        {
            target.trigger('tap', e);
        }
        target.unbind('touchmove', touchMove).unbind('touchend', touchEnd);
    }
    
    target.bind('touchend', touchMove).bind('touchmove', touchEnd);
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

function touchEventsSupported()
{
    if (typeof TouchEvent != 'undefined')
    {
        alert('touch supported!');
        return true;
    }
    else
    {
        alert('touch NOT supported!');
        return false;
}
}

$(window).unload(function(){
    ready = false;
    setProgress(true);
});

$(window).bind('touchstart', touchHandler);

$(function(){
    ready = true;
    if (typeof init !== 'undefined')
    {
        if (init instanceof Function)
        {
            init();
        }
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
});