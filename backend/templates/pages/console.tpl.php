<?php $lang = Lang::instance('console') ?>
<?php $genericLang = Lang::instance('generic') ?>
<div id="console_viewbox">
    <div></div>
</div>
<ul>
    <li><input type="text" id="console_input" placeholder="<?php $lang->command_enter ?>"></li>
</ul>
<script type="text/javascript" src="js/iscroll-lite.min.js"></script>
<script type="text/javascript">
    var consoleRequest = new ApiRequest('server', 'console');
    consoleRequest.data({format:'json'});
    consoleRequest.ignoreFirstFail(true);
    consoleRequest.onBeforeSend(null);
    consoleRequest.onComplete(null);
    consoleRequest.onSuccess(refreshConsole);
    consoleRequest.onFailure(function(){
        alert('<?php $lang->console_fail ?>');
    });
    var consoleScroller = new iScroll('console_viewbox');
    consoleScroller.scrollToElement('div#console_viewbox > div > div:last-child', 100);


    function refreshConsole(data)
    {
        var parseRegex = /(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}) \[(\w+)] (.*)/i;
        var consoleBox = $('#console_viewbox > div');
        data = eval('(' + data + ')');
        data = data.reverse();
        //var lines = [];
        for (var i = 0; i < data.length; ++i)
        {
            var line = data[i];
            var match = line.match(parseRegex);
            if (match)
            {
                var lineDiv = $(document.createElement('div'));
                lineDiv.attr('title', match[1]);
                lineDiv.addClass('logtype_' + match[2].toLowerCase());
                lineDiv.text(match[3]);
                consoleBox.append(lineDiv);
            }
        }
        consoleBox.remove('div:gt(99)');
        consoleScroller.refresh();
    }

    function init()
    {
        consoleRequest.execute();
    }
</script>