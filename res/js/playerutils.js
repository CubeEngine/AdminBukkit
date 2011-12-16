function player_kick(player, sync)
{
    var $result = false;
    if (confirm(AdminBukkit.t('playerutils', 'Do you really want to kick this Player?')))
    {
        var reason = prompt(AdminBukkit.t('playerutils', 'Why do you want to kick him? (not important)'), '');
        if (!reason)
        {
            reason = '';
        }
        var request = new ApiRequest('player', 'kick');
        request.onSuccess(function(){
            alert(AdminBukkit.t('playerutils', 'The player was successfully kicked!'));
            $result = true;
        });
        request.onFailure(function(error){
            switch(error)
            {
                case 1:
                    alert(AdminBukkit.t('playerutils', 'No player has been named!'));
                    break;
                case 2:
                    alert(AdminBukkit.t('playerutils', 'Player not found!'));
                    break;
            }
            $result = false;
        });
        request.sync(!!sync);
        request.execute({player: player, reason: reason});
    }
    return $result;
}

function player_kill(player)
{
    if (confirm(AdminBukkit.t('playerutils', 'Do you really want to kill this Player?')))
    {
        var request = new ApiRequest('player', 'kill');
        request.onSuccess(function(){
            alert(AdminBukkit.t('playerutils', 'The player was successfully killed!'));
        });
        request.onFailure(function(error){
            switch(error)
            {
                case 1:
                    alert(AdminBukkit.t('playerutils', 'No player has been named!'));
                    break;
                case 2:
                    alert(AdminBukkit.t('playerutils', 'Player not found!'));
                    break;
            }
        });
        request.execute({player: player});
    }
}

function player_burn(player)
{
    var duration = prompt(AdminBukkit.t('playerutils', 'How long (in seconds) should the player burn?'), '5');
    if (!duration)
    {
        return;
    }
    duration = duration.replace(/\s/g, '');
    if (!duration.match(/^\d+$/))
    {
        alert(AdminBukkit.t('playerutils', 'You have to enter a number!'));
        return;
    }
    var request = new ApiRequest('player', 'burn');
    request.onSuccess(function(){
        alert(AdminBukkit.t('playerutils', 'The Player was successfully lit!'));
    });
    request.onFailure(function(error){
        switch(error)
        {
            case 1:
                alert(AdminBukkit.t('playerutils', 'No player has been given!'));
                break;
            case 2:
                alert(AdminBukkit.t('playerutils', 'Player not found!'));
                break;
            case 3:
                alert(AdminBukkit.t('playerutils', 'You have to enter a number!'));
                break;
        }
    });
    request.execute({player: player, duration: duration});
}

function player_heal(player)
{
    if (confirm(AdminBukkit.t('playerutils', 'Do you really want to heal this Player?')))
    {
        var request = new ApiRequest('player', 'heal');
        request.onSuccess(function(){
            alert(AdminBukkit.t('playerutils', 'The player was successfully healed!'));
        });
        request.onFailure(function(error){
            switch(error)
            {
                case 1:
                    alert(AdminBukkit.t('playerutils', 'No player has been named!'));
                    break;
                case 2:
                    alert(AdminBukkit.t('playerutils', 'Player not found!'));
                    break;
            }
        });
        request.execute({player: player});
    }
}

function player_tell(player)
{
    var message = prompt(AdminBukkit.t('playerutils', 'Enter a message (max. 100 characters):'), '');
    if (!message)
    {
        return;
    }
    var request = new ApiRequest('player', 'tell');
    request.onSuccess(function(){
        alert(AdminBukkit.t('playerutils', 'Message was successfully sent!'));
    });
    request.onFailure(function(error){
        switch(error)
        {
            case 1:
                alert(AdminBukkit.t('playerutils', 'No player was given!'));
                break;
            case 2:
                alert(AdminBukkit.t('playerutils', 'Player not found!'));
                break;
            case 3:
                alert(AdminBukkit.t('playerutils', 'No message has been entered!'));
                break;
        }
    });
    request.execute({player: player, message: message.substr(0, 100)});
}

function player_clearinv(player)
{
    if (confirm(AdminBukkit.t('playerutils', 'Do you really want to clear the inventory?')))
    {
        var request = new ApiRequest('player', 'clearinventory');
        request.onSuccess(function(){
            alert(AdminBukkit.t('playerutils', 'The inventory was successfully cleared!'));
        });
        request.onFailure(function(error){
            switch(error)
            {
                case 1:
                    alert(AdminBukkit.t('playerutils', 'No player has been gived!'));
                    break;
                case 2:
                    alert(AdminBukkit.t('playerutils', 'Player not found!'));
                    break;
            }
        });
        request.execute({player: player});
    }
}

/**
 * @todo add item names
 */
function player_give(player)
{
    var item = prompt(AdminBukkit.t('playerutils', 'Enter the Block ID (format: blockid[:blockdata]):'), '');
    if (!item)
    {
        return;
    }
    item = item.replace(/\s/g, '');
    if (items && item.match(/[^\d:]/))
    {
        if (items[item])
        {
            item = items[item][0] + ':' + items[item][1];
        }
        else
        {
            alert(AdminBukkit.t('playerutils', 'That item alias was not found.'));
            return;
        }
    }
    if (!item.match(/^\d+(:\d+)?$/))
    {
        alert(AdminBukkit.t('playerutils', 'You have to regard the format!'));
        return;
    }
    var data = 0;
    if (item.indexOf(':') > -1)
    {
        var delimPos = item.indexOf(':');
        data = item.substr(delimPos + 1);
        item = item.substr(0, delimPos);
    }
    var amount = prompt(AdminBukkit.t('playerutils', 'How many?'), '64');
    if (!amount)
    {
        amount = '64';
    }
    amount = amount.replace(/\s/g, '');
    var request = new ApiRequest('player', 'give');
    request.onSuccess(function(){
        alert(AdminBukkit.t('playerutils', 'Item successfully delivered!'));
    });
    request.onFailure(function(error){
        switch(error)
        {
            case 1:
                alert(AdminBukkit.t('playerutils', 'No player has been given!'));
                break;
            case 2:
                alert(AdminBukkit.t('playerutils', 'Player not found!'));
                break;
            case 3:
                alert(AdminBukkit.t('playerutils', 'You have to regard the format!'));
                break;
            case 4:
                alert(AdminBukkit.t('playerutils', 'No item ID was given!'));
                break;
            case 5:
                alert(AdminBukkit.t('playerutils', 'A invalid block data value was given!'));
                break;
            case 6:
                alert(AdminBukkit.t('playerutils', 'An invalid amount was given!'));
                break;
            case 7:
                alert(AdminBukkit.t('playerutils', 'Unknown item!'));
                break;
        }
    });
    request.execute({player: player, itemid: item, data: data, amount: amount});
}

/**
 * @todo needs rework
 */
function player_teleport(player)
{
    var target = prompt(AdminBukkit.t('playerutils', 'Enter the target (Playername or coordinate (x,y,z[,orientiation]):'), '');
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
        alert(AdminBukkit.t('playerutils', 'You entered a invalid target!'));
        return;
    }
    var request = new ApiRequest('player', 'teleport');
    request.onSuccess(function(){
        alert(AdminBukkit.t('playerutils', 'The player was successfully teleported!'));
    });
    request.onFailure(function(error){
        switch(error)
        {
            case 1:
                alert(AdminBukkit.t('playerutils', 'No player has been given!'));
                break;
            case 2:
                alert(AdminBukkit.t('playerutils', 'Player not found!'));
                break;
            case 3:
                alert(AdminBukkit.t('playerutils', 'World not found!'));
                break;
            case 4:
            case 5:
                alert(AdminBukkit.t('playerutils', 'You entered a invalid target!'));
                break;
        }
    });
    request.execute(data);
}

function player_op(player)
{
    if (confirm(AdminBukkit.t('playerutils', 'Are you sure to op this player?')))
    {
        var request = new ApiRequest('operator', 'add');
        request.onSuccess(function(){
            alert(AdminBukkit.t('playerutils', 'The player was successfully op\'ped!'));
        });
        request.onFailure(function(error){
            switch(error)
            {
                case 1:
                    alert(AdminBukkit.t('playerutils', 'There was no player given!'));
                    break;
                case 2:
                    alert(AdminBukkit.t('playerutils', 'This player is already a operator!'));
                    break;
            }
        });
        request.execute({
            player: player
        });
    }
}

function player_deop(player)
{
    if (confirm(AdminBukkit.t('playerutils', 'Are you sure to deop this player?')))
    {
        var request = new ApiRequest('operator', 'remove');
        request.onSuccess(function(){
            alert(AdminBukkit.t('playerutils', 'The player was successfully deop\'ped!'));
        });
        request.onFailure(function(error){
            switch(error)
            {
                case 1:
                    alert(AdminBukkit.t('playerutils', 'There was no player given!'));
                    break;
                case 2:
                    alert(AdminBukkit.t('playerutils', 'This player is no operator!'));
                    break;
            }
        });
        request.execute({
            player: player
        });
    }
}