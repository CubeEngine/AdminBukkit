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

function redirectTo(target)
{
    if (target)
    {
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

/*
@todo tooltips need a better implementation

function touchTooltipHandler(event)
{
    var $target = $(event.target);
    var $timeout = setTimeout(attachTooltip, 170);
    var $tooltip = null;
    
    function attachTooltip()
    {
        event.preventDefault();
        $tooltip = $('<div class="touchTooltip"><div>' + $target.attr('title') + '</div></div>');
        var pos = $target.position();
        $tooltip.css('top', pos.top + event.target.offsetHeight + 'px');
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
}*/

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

function realSort(a, b)
{
    a = a.toLowerCase();
    var array = new Array(a, b.toLowerCase());
    return (array.sort()[0] == a ? -1 : 1);
}

function isDataDifferent(oldData, data)
{
    if (!oldData)
    {
        return true;
    }
    if (oldData.length != data.length)
    {
        return true;
    }
    for (var i = 0; i < oldData.length; ++i)
    {
        if (oldData[i] != data[i])
        {
            return true;
        }
    }
    return false;
}

function parseColors(string)
{
    var regex = /§([0-9a-f])/i;
    var counter = 0;
    var last = '';

    function parse(match)
    {
        if (last != match[1])
        {
            var color = '';
            last = match[1];
            switch (match[1])
            {
                case '0':
                    color = '#000';
                    break;
                case '1':
                    color = '#009';
                    break;
                case '2':
                    color = '#090';
                    break;
                case '3':
                    color = '#099';
                    break;
                case '4':
                    color = '#800';
                    break;
                case '5':
                    color = '#909';
                    break;
                case '6':
                    color = '#F90';
                    break;
                case '7':
                    color = '#CCC';
                    break;
                case '8':
                    color = '#999';
                    break;
                case '9':
                    color = '#00F';
                    break;
                case 'a':
                    color = '#0F0';
                    break;
                case 'b':
                    color = '#0FF';
                    break;
                case 'c':
                    color = '#F00';
                    break;
                case 'd':
                    color = '#F0F';
                    break;
                case 'e':
                    color = '#FF0';
                    break;
                case 'f':
                    color = '#000'; // white -> black for readability
            }
            if (color)
            {
                counter++;
                return '<span style="color:' + color + ';">'
            }
        }
        return '';
    }

    while (string.match(regex))
    {
        string = string.replace(regex, parse);
    }

    return string + (new Array(counter)).join('</span>');
}

$.mobile.loadingMessage = genericLang.progress;
$.mobile.pageloadErrorMessage = genericLang.pageloaderror;
$.mobile.listview.prototype.options.filterPlaceholder = genericLang.filterplaceholder;

$(window).unload(function(){
    $.mobile.showPageLoadingMsg();
});

$(function(){
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
    //$('*[title]').live('touchstart', touchTooltipHandler);
});