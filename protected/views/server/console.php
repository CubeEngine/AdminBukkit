<div id="console_viewbox">
    <div><?php echo Yii::t('generic', 'Loading...') ?></div>
</div>
<div>
    <input type="text" id="console_input" placeholder="<?php echo Yii::t('server', 'Enter a command') ?>">
</div>
<script type="text/javascript">
    var refreshing = true,
        timeoutID,
        consoleRequest = new ApiRequest('server', 'console');
    consoleRequest.data({format:'json'});
    consoleRequest.ignoreFirstFail(true);
    consoleRequest.onBeforeSend(null);
    consoleRequest.onComplete(null);
    consoleRequest.onSuccess(refreshConsole);
    consoleRequest.onFailure(function(){
        alert('<?php echo Yii::t('server', 'Console failed!') ?>');
    });
    var commandHistory = [];

    function refreshConsole(data)
    {
        var parseRegex = /(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}) \[(\w+)] (.*)/i;
        var console = document.getElementById('console_viewbox');
        var consoleBox = $(console).find('div:first');
        var scrollDown = (console.scrollTop == (console.scrollHeight - console.offsetHeight));
        //data = eval('(' + data + ')');
        consoleBox.html('');
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
        if (!console)
        {
            return;
        }
        if (scrollDown)
        {
            console.scrollTop = console.scrollHeight;
        }

        if (refreshing)
        {
            timeoutID = setTimeout(function(){
                consoleRequest.execute();
            }, 1000);
        }
    }

    $('#server_console').bind('pageshow', function(){
        refreshing = true;
        consoleRequest.execute();
    }).bind('pagehide', function(){
        if (refreshing)
        {
            refreshing = false;
            clearTimeout(timeoutID);
        }
    }).bind('pagecreate', function(){
        $('#console_input').bind('keydown', function(e){
            if (e.which == 13)
            {
                var commandLine = $(e.target).val().split(" ");
                var command = commandLine[0];
                data = {}
                if (commandLine.length > 1)
                {
                    var params = commandLine.slice(1, commandLine.length);
                    data.params = params.join(",");
                }
                var commandRequest = new ApiRequest('command', command);
                commandRequest.onSuccess(function(data){
                    $('#console_input').val('');
                    if (!refreshing)
                    {
                        consoleRequest.execute();
                    }
                });
                commandRequest.onFailure(function(error){
                    switch (error)
                    {
                        case 1:
                            alert('<?php echo Yii::t('server', 'The server failed to read the log file.\nPlease inform an adminstrator of the server.') ?>');
                    }
                });
                commandRequest.execute(data);
            }
        });

        $('#console_toolbar_button').click(function(e){
            e.preventDefault();
            var elem = $(e.target);
            if (refreshing)
            {
                refreshing = false;
                clearTimeout(timeoutID);
                elem.text('<?php echo Yii::t('server', 'Refreshing on') ?>');
            }
            else
            {
                refreshing = true;
                elem.text('<?php echo Yii::t('server', 'Refreshing off') ?>');
                consoleRequest.execute();
            }
            return false;
        });
    });
</script>