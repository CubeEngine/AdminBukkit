function ban_player(player, sync)
{
    var $result = false;
    if (!player)
    {
        player = prompt(AdminBukkit.t('serverutils', 'Enter the playnername which should be banned:'), '');
    }
    else
    {
        if (!confirm(AdminBukkit.t('serverutils', 'Do you really want to ban this Player?')))
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
        alert(AdminBukkit.t('serverutils', 'Your input was invalid!\nAllowed: A-Z, a-z, 0-9, _, .'));
        return $result;
    }
    var data = Object();
    data.player = player;
    var reason = prompt(AdminBukkit.t('serverutils', 'Why do you want to ban him? (not important)'), '');
    if (reason)
    {
        data.reason = reason;
    }
    var request = new ApiRequest('ban', 'add');
    request.onSuccess(function(){
        alert(AdminBukkit.t('serverutils', 'The player was successfully banned!'));
        $result = true;
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
                alert(AdminBukkit.t('serverutils', 'This player is already banned!'));
                break;
            case 3:
                alert(AdminBukkit.t('serverutils', 'No player name given!'));
                break;
        }
    });
    request.sync(!!sync);
    request.execute(data);
    return $result;
}
function ban_ip(ip, sync)
{
    var $result = false;
    if (!ip)
    {
        ip = prompt(AdminBukkit.t('serverutils', 'Write the IP(v4) which should be banned:'), '');
    }
    else
    {
        if (!confirm(AdminBukkit.t('serverutils', 'Do you really want to ban this IP?')))
        {
            return false;
        }
    }
    if (!ip)
    {
        return false;
    }
    ip = ip.replace(/\s/g, '');
    if (!ip.match(/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/))
    {
        alert(serverutilsLang.ip_invalid);
        return false;
    }
    var request = new ApiRequest('ban', 'add');
    request.onSuccess(function(){
        alert(AdminBukkit.t('serverutils', 'The IP was successfully banned!'));
        $result = true;
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
                alert(AdminBukkit.t('serverutils', 'Your input was not a valid IP(v4)!'));
                break;
            case 2:
                alert(AdminBukkit.t('serverutils', 'No IP given!'));
                break;
        }
    });
    request.sync(!!sync);
    request.execute({ip: ip});
    return $result;
}

function unban_player(player, sync)
{
    var $result = false;
    if (!player)
    {
        player = prompt(AdminBukkit.t('serverutils', 'Enter the playername which should be unbanned:'), '');
    }
    else
    {
        if (!confirm(AdminBukkit.t('serverutils', 'Player was successfully unbanned!')))
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
        alert(AdminBukki.t('serverutils', 'Your input was invalid!\nAllowed: A-Z, a-z, 0-9, _, .'));
        return false;
    }
    var request = new ApiRequest('ban', 'remove');
    request.onSuccess(function(){
        alert(AdminBukkit.t('serverutils', 'layer was successfully unbanned!'));
        $result = true;
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
                alert(AdminBukkit.t('serverutils', 'No player name given!'));
                break;
            case 3:
                alert(AdminBukkit.t('serverutils', 'The player is not banned!'));
                break;
        }
    });
    request.sync(!!sync);
    request.execute({player: player});
    return $result;
}
function unban_ip(ip, sync)
{
    var $result = false;
    if (!ip)
    {
        ip = prompt(AdminBukkit.t('serverutils', 'Enter the IP(v4) which should be unbanned:'), '');
    }
    else
    {
        if (!confirm(AdminBukkit.t('serverutils', 'Are you sure to unban this IP(v4)?')))
        {
            return false;
        }
    }
    if (!ip)
    {
        return false;
    }
    ip = ip.replace(/\s/g, '');
    if (!ip.match(/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/))
    {
        alert(AdminBukkit.t('serverutils', 'Your input was not a valid IP(v4)!'));
        return false;
    }
    var request = new ApiRequest('ban', 'remove');
    request.onSuccess(function(){
        alert(AdminBukkit.t('serverutils', 'IP was successfully unbanned!'));
        $result = true;
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
                alert(AdminBukkit.t('serverutils', 'No IP given!'));
                break;
            case 2:
                alert(AdminBukkit.t('serverutils', 'Your input was not a valid IP(v4)!'));
                break;
        }
    });
    request.sync(!!sync);
    request.execute({ip: ip});
    return $result;
}

function whitelist_add(player, sync)
{
    var $result = false;
    if (!player)
    {
        player = prompt(AdminBukkit.t('serverutils', 'Enter the player name to add:'), '');
    }
    else
    {
        if (!confirm(AdminBukkit.t('serverutils', 'Do you really want to add this player to the whitelist?')))
        {
            return false;
        }
    }
    if (!player)
    {
        return false;
    }
    var request = new ApiRequest('whitelist', 'add');
    request.onSuccess(function(){
        alert(AdminBukkit.t('serverutils', 'The player was successfully added to the whitelist!'));
        $result = true;
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
                alert(AdminBukkit.t('serverutils', 'No player given!'));
                break;
            case 2:
                alert(AdminBukkit.t('serverutils', 'The player is already on the whitelist!'));
                break;
        }
    });
    request.sync(!!sync);
    request.execute({player: player});
    return $result;
}

function whitelist_remove(player, sync)
{
    var $result = false;
    if (!player)
    {
        player = prompt(AdminBukkit.t('serverutils', 'Enter the player name to remove:'), '');
    }
    else
    {
        if (!confirm(AdminBukkit.t('serverutils', 'Do you really want to remove this player from the whitelist?')))
        {
            return false;
        }
    }
    if (!player)
    {
        return false;
    }
    var request = new ApiRequest('whitelist', 'remove');
    request.onSuccess(function(){
        alert(AdminBukkit.t('serverutils', 'The player was successfully removed from the whitelist!'));
        $result = true;
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
                alert(AdminBukkit.t('serverutils', 'No player given!'));
                break;
            case 2:
                alert(AdminBukkit.t('serverutils', 'The player is not on the whitelist!'));
                break;
        }
    });
    request.sync(!!sync);
    request.execute({player: player});
    return $result;
}

function operator_add(player, sync)
{
    var $result = false;
    if (!player)
    {
        player = prompt(AdminBukkit.t('serverutils', 'Enter the player name to op:'), '');
    }
    else
    {
        if (!confirm(AdminBukkit.t('serverutils', 'Do you really want to op this player?')))
        {
            return false;
        }
    }
    if (!player)
    {
        return false;
    }
    var request = new ApiRequest('operator', 'add');
    request.onSuccess(function(){
        alert(AdminBukkit.t('servverutils', 'The player was successfully opped!'));
        $result = true;
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
                alert(AdminBukkit.t('serverutils', 'No player given!'));
                break;
            case 2:
                alert(AdminBukkit.t('serverutils', 'The player is already an operator!'));
                break;
        }
    });
    request.sync(!!sync);
    request.execute({player: player});
    return $result;
}

function operator_remove(player, sync)
{
    var $result = false;
    if (!player)
    {
        player = prompt(AdminBukkit.t('serverutils', 'Enter the player name to deop:'), '');
    }
    else
    {
        if (!confirm(AdminBukkit.t('serverutils', 'Do you really want to deop this player?')))
        {
            return false;
        }
    }
    if (!player)
    {
        return false;
    }
    var request = new ApiRequest('operator', 'remove');
    request.onSuccess(function(){
        alert(AdminBukkit.t('serverutils', 'The player was successfully deopped!'));
        $result = true;
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
                alert(AdminBukkit.t('serverutils', 'No player given!'));
                break;
            case 2:
                alert(AdminBukkit.t('serverutils', 'The player is no operator!'));
                break;
        }
    });
    request.sync(!!sync);
    request.execute({player: player});
    return $result;
}
