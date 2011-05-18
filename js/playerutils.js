var playerutilsLang = new PlayerutilsLang();

/**
 * @todo add item names
 */
var items = {
    
}

function player_kick(player, sync)
{
    if (confirm(playerutilsLang.kick_confirm))
    {
        var reason = prompt(playerutilsLang.kick_reason, '');
        apiCall('player', 'kick', function(){
            alert(playerutilsLang.kick_success);
        }, {player: player, reason: reason}, 'GET', false, !!sync);
        return true;
    }
    return false;
}

function player_kill(player)
{
    if (confirm(playerutilsLang.kill_confirm))
    {
        apiCall('player', 'kill', function(){
            alert(playerutilsLang.kill_success);
        }, {player: player});
    }
}

function player_burn(player)
{
    var duration = prompt(playerutilsLang.burn_duration, '5');
    if (!duration)
    {
        return;
    }
    duration = duration.replace(/\s/g, '');
    if (!duration.match(/^\d+$/))
    {
        alert(playerutilsLang.burn_nonumber);
        return;
    }
    apiCall('player', 'burn', function(){
        alert(playerutilsLang.burn_success);
    }, {player: player, duration: duration});
}

function player_heal(player)
{
    if (confirm(playerutilsLang.heal_confirm))
    {
        apiCall('player', 'heal', function(){
            alert(playerutilsLang.heal_success);
        }, {player: player});
    }
}

function player_tell(player)
{
    var message = prompt(playerutilsLang.tell_message, '');
    if (!message)
    {
        return;
    }
    apiCall('player', 'tell', function(){
        alert(playerutilsLang.tell_success);
    }, {player: player, message: message.substr(0, 100)});
}

function player_clearinv(player)
{
    if (confirm(playerutilsLang.clearinv_confirm))
    {
        apiCall('player', 'clearinventory', function(){
            alert(playerutilsLang.clearinv_success);
        }, {player: player});
    }
}

/**
 * @todo add item names
 */
function player_give(player)
{
    var item = prompt(playerutilsLang.give_item, '');
    if (!item)
    {
        return;
    }
    item = item.replace(/\s/g, '');
    if (!item.match(/^\d+(:\d+)?$/))
    {
        alert(playerutilsLang.give_formatfail);
        return;
    }
    var data = 0;
    if (item.indexOf(':') > -1)
    {
        data = item.substr(item.indexOf(':') + 1);
    }
    var amount = prompt(playerutilsLang.give_amount, '64');
    if (!amount)
    {
        amount = '64';
    }
    amount = amount.replace(/\s/g, '');
    apiCall('player', 'give', function(){
        alert(playerutilsLang.give_success);
    }, {player: player, itemid: item, data: data, amount: amount});
}

/**
 * @todo player-to-player teleportation
 */
function player_teleport(player)
{
    var target = prompt(playerutilsLang.teleport_target, '');
    if (!target)
    {
        return;
    }
    var data = new Object();
    data.player = player;
    target = target.replace(/\s/g, '');
    if (target.match(/^\-?\d+(\.\d+)?,\-?\d+(\.\d+)?,\-?\d+(\.\d+)?(,\d+(\.\d+)?)?$/))
    {
        data.location = target;
    }
    else if (target.match(/^[\w\d\.]+$/))
    {
        data.targetplayer = target;
    }
    else
    {
        alert(playerutilsLang.teleport_invalidtarget);
        return;
    }
    apiCall('player', 'teleport', function(){
        alert(playerutilsLang.teleport_success);
    }, data);
}