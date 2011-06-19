var serverutilsLang = new ServerutilsLang();

function ban_player(player, sync)
{
    var $result = false;
    if (!player)
    {
        player = prompt(serverutilsLang.banplayer_prompt, '');
    }
    else
    {
        if (!confirm(serverutilsLang.banplayer_confirm))
        {
            return $result;
        }
    }
    if (!player)
    {
        return $result;
    }
    player = player.replace(/\s/g, '');
    if (!player.match(/^[\w\d\.]+$/i))
    {
        alert(serverutilsLang.name_invalid);
        return $result;
    }
    var data = Object();
    data.player = player;
    var reason = prompt(serverutilsLang.banplayer_reason, '');
    if (reason)
    {
        data.reason = reason;
    }
    var request = new ApiRequest('ban', 'add');
    request.onSuccess(function(){
        alert(serverutilsLang.banplayer_success);
        $result = true;
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
                alert(serverutilsLang.name_missing);
                break;
        }
    });
    request.sync(!!sync);
    request.execute(data);
    return $result;
}
function ban_ip(ip)
{
    if (!ip)
    {
        ip = prompt(serverutilsLang.banip_prompt, '');
    }
    else
    {
        if (!confirm(serverutilsLang.banip_confirm))
        {
            return;
        }
    }
    if (!ip)
    {
        return;
    }
    ip = ip.replace(/\s/g, '');
    if (!ip.match(/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/))
    {
        alert(serverutilsLang.ip_invalid);
        return;
    }
    var request = new ApiRequest('ban', 'add');
    request.onSuccess(function(){
        alert(serverutilsLang.banip_success);
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
                alert(serverutilsLang.ip_missing);
                break;
            case 2:
                alert(serverutilsLang.ip_invalid);
                break;
        }
    });
    request.execute({ip: ip});
}

function unban_player(player)
{
    if (!player)
    {
        player = prompt(serverutilsLang.unbanplayer_prompt, '');
    }
    else
    {
        if (!confirm(serverutilsLang.unbanplayer_confirm))
        {
            return;
        }
    }
    if (!player)
    {
        return;
    }
    player = player.replace(/\s/g, '');
    if (!player.match(/^[\w\d\.]+$/i))
    {
        alert(serverutilsLang.name_invalid);
        return;
    }
    var request = new ApiRequest('ban', 'remove');
    request.onSuccess(function(){
        alert(serverutilsLang.unbanplayer_success);
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
                alert(serverutilsLang.name_missing);
                break;
        }
    });
    request.execute({player: player});
}
function unban_ip(ip)
{
    if (!ip)
    {
        ip = prompt(serverutilsLang.unbanip_prompt, '');
    }
    else
    {
        if (!confirm(serverutilsLang.unbanip_confirm))
        {
            return;
        }
    }
    if (!ip)
    {
        return;
    }
    ip = ip.replace(/\s/g, '');
    if (!ip.match(/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/))
    {
        alert(serverutilsLang.ip_invalid);
        return;
    }
    var request = new ApiRequest('ban', 'remove');
    request.onSuccess(function(){
        alert(serverutilsLang.unbanip_success);
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
                alert(serverutilsLang.ip_missing);
                break;
            case 2:
                alert(serverutilsLang.ip_invalid);
                break;
        }
    });
    request.execute({ip: ip});
}

function whitelist_add(player)
{
    if (!player)
    {
        player = prompt(serverutilsLang.whitelist_add_prompt, '');
    }
    else
    {
        if (!confirm(serverutilsLang.whitelist_add_confirm))
        {
            return;
        }
    }
    if (!player)
    {
        return;
    }
    var request = new ApiRequest('whitelist', 'add');
    request.onSuccess(function(){
        alert(serverutilsLang.whitelist_add_success);
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
                alert(serverutilsLang.whitelist_add_noplayer);
                break;
        }
    });
    request.execute({player: player});
}

function whitelist_remove(player)
{
    if (!player)
    {
        player = prompt(serverutilsLang.whitelist_remove_prompt, '');
    }
    else
    {
        if (!confirm(serverutilsLang.whitelist_remove_confirm))
        {
            return;
        }
    }
    if (!player)
    {
        return;
    }
    var request = new ApiRequest('whitelist', 'remove');
    request.onSuccess(function(){
        alert(serverutilsLang.whitelist_remove_success);
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
                alert(serverutilsLang.whitelist_remove_noplayer);
                break;
        }
    });
    request.execute({player: player});
}

function operator_add()
{
    if (!player)
    {
        player = prompt(serverutilsLang.operator_add_prompt, '');
    }
    else
    {
        if (!confirm(serverutilsLang.operator_add_confirm))
        {
            return;
        }
    }
    if (!player)
    {
        return;
    }
    var request = new ApiRequest('operator', 'add');
    request.onSuccess(function(){
        alert(serverutilsLang.operator_add_success);
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
                alert(serverutilsLang.operator_add_noplayer);
                break;
        }
    });
    request.execute({player: player});
}

function operator_remove()
{
    if (!player)
    {
        player = prompt(serverutilsLang.operator_remove_prompt, '');
    }
    else
    {
        if (!confirm(serverutilsLang.operator_remove_confirm))
        {
            return;
        }
    }
    if (!player)
    {
        return;
    }
    var request = new ApiRequest('operator', 'remove');
    request.onSuccess(function(){
        alert(serverutilsLang.operator_remove_success);
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
                alert(serverutilsLang.operator_remove_noplayer);
                break;
        }
    });
    request.execute({player: player});
}
