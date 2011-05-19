var banutilsLang = new BanutilsLang();

function ban_player(player, sync)
{
    var $result = false;
    if (!player)
    {
        player = prompt(banutilsLang.banplayer_prompt);
    }
    else
    {
        if (!confirm(banutilsLang.banplayer_confirm))
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
        alert(banutilsLang.name_invalid);
        return $result;
    }
    var data = Object();
    data.player = player;
    var reason = prompt(banutilsLang.banplayer_reason, '');
    if (reason)
    {
        data.reason = reason;
    }
    var request = new ApiRequest('server', 'ban');
    request.onSuccess(function(){
        alert(banutilsLang.banplayer_success);
        $result = true;
    });
    request.sync(!!sync);
    request.execute(data);
    return $result;
}
function ban_ip(ip)
{
    if (!ip)
    {
        ip = prompt(banutilsLang.banip_prompt);
    }
    else
    {
        if (!confirm(banutilsLang.banip_confirm))
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
        alert(banutilsLang.ip_invalid);
        return;
    }
    var request = new ApiRequest('server', 'ban');
    request.onSuccess(function(){
        alert(banutilsLang.banip_success);
    });
    request.execute({ip: ip});
}

function unban_player(player)
{
    if (!player)
    {
        player = prompt(banutilsLang.unbanplayer_prompt);
    }
    if (!player)
    {
        return;
    }
    player = player.replace(/\s/g, '');
    if (!player.match(/^[\w\d\.]+$/i))
    {
        alert(banutilsLang.name_invalid);
        return;
    }
    var request = new ApiRequest('server', 'unban');
    request.onSuccess(function(){
        alert(banutilsLang.unbanplayer_success);
    });
    request.execute({player: player});
}
function unban_ip(ip)
{
    if (!ip)
    {
        ip = prompt(banutilsLang.unbanip_prompt);
    }
    if (!ip)
    {
        return;
    }
    ip = ip.replace(/\s/g, '');
    if (!ip.match(/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/))
    {
        alert(banutilsLang.ip_invalid);
        return;
    }
    var request = new ApiRequest('server', 'unban');
    request.onSuccess(function(){
        alert(banutilsLang.unbanip_success);
    });
    request.execute({ip: ip});
}