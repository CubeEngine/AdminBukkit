var banutilsLang = new BanutilsLang();

function ban_player(player, sync)
{
    if (!player)
    {
        player = prompt(banutilsLang.banplayer_prompt);
    }
    else
    {
        if (!confirm(banutilsLang.banplayer_confirm))
        {
            return false;
        }
    }
    if (!player)
    {
        return false;
    }
    player = player.replace(/\s/g, '');
    if (!player.match(/^[\w\d\.]+$/i))
    {
        alert(banutilsLang.name_invalid);
        return false;
    }
    var data = Object();
    data.player = player;
    var reason = prompt(banutilsLang.banplayer_reason, '');
    if (reason)
    {
        data.reason = reason;
    }
    apiCall('server', 'ban', function(){
        alert(banutilsLang.banplayer_success);
    }, data, 'GET', false, !!sync);
    return true;
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
    apiCall('server', 'ban', function(){
        alert(banutilsLang.banip_success);
    }, {ip: ip});
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
    apiCall('server', 'unban', function(){
        alert(banutilsLang.unbanplayer_success);
    }, {player: player});
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
    apiCall('server', 'unban', function(){
        alert(banutilsLang.unbanip_success);
    }, {ip: ip});
}