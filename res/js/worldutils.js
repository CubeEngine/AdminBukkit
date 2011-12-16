function world_create(world, seed, environment, generator, onSuccess)
{
    var data = new Object();
    if (!world)
    {
        alert(AdminBukkit.t('worldutils', 'No world name has been entered.'));
        return false;
    }
    world = world.replace(/\s/g, '');
    if (!world.match(/^[\w\d-]+$/))
    {
        alert(AdminBukkit.t('worldutils', 'The name is invalid!'));
    }
    data.world = world;
    if (seed)
    {
        data.seed = seed;
    }

    if (environment && (environment == 'normal' || environment == 'nether' || environment == 'skylands'))
    {
        data.environment = environment;
    }
    else
    {
        alert(AdminBukkit.t('worldutils', 'You entered nothing or an invalid type!'));
        return false;
    }
    if (generator)
    {
        data.generator = generator;
    }
    if (confirm(AdminBukkit.t('worldutils', 'Warning!\nIf a world with the same name does already exist(not loaded) the world will be overwritten, if the settings (seed, type) are different!')))
    {
        var request = new ApiRequest('world', 'create');
        request.onSuccess(function(){
            alert(AdminBukkit.t('worldutils', 'World was successfully created!'));
            if (onSuccess && onSuccess instanceof Function)
            {
                onSuccess();
            }
        });
        request.onFailure(function(code){
            switch (code)
            {
                case 1:
                    alert(AdminBukkit.t('worldutils', 'No world name has been entered.'));
                    break;
                case 2:
                    alert(AdminBukkit.t('worldutils', 'There is already a world with the given name.'));
                    break;
                case 3:
                    alert(AdminBukkit.t('worldutils', 'You entered nothing or an invalid type.'));
                    break;
                case 4:
                    alert(AdminBukkit.t('worldutils', 'The given generator was not found.'));
                    break;
            }
        });
        request.execute(data);
    }
    return false;
}

function world_time(world)
{
    var time = prompt(AdminBukkit.t('worldutils', 'Enter the time:'), '');
    if (!time)
    {
        return;
    }
    time = time.replace(/\s/g, '');
    if (time.match(/^\d+$/))
    {} // leave as is
    else if (time.match(/^\d{1,2}:\d{2}$/))
    {
        var timeParts = time.split(':');
        var hours = parseInt(timeParts[0]);
        var minutes = parseInt(timeParts[1]);
        if (minutes > 59)
        {
            minutes = 59;
        }
        if (minutes > 0 && hours > 23)
        {
            hours = 23;
        }
        else if (hours > 24)
        {
            hours = 24;
        }
        var hourTicks = 24000 / 24;
        var minuteTicks = hourTicks / 60;
        time = hours * hourTicks;
        time += Math.round(minutes * minuteTicks);
        time -= 6000;
    }
    else
    {
        alert(worldutilsLang.time_invalidformat);
        return;
    }
    
    var request = new ApiRequest('world', 'time');
    request.onSuccess(function(){
        alert(AdminBukkit.t('worldurils', 'The time was successfully set!'));
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
            case 2:
                alert(AdminBukkit.t('worldutils', 'You have to regard the format!'))
                break;
            case 3:
            case 4:
                alert(AdminBukkit.t('worldutils', 'No valid time has been entered.'));
                break;
        }
    });
    request.execute({world: world, time: time});
}

function world_pvp(world)
{
    var state = confirm(AdminBukkit.t('worldutils', 'Should PVP be activated or deactivated?\n\nOK to activate it, Cancel to deactivate it.'));
    state = (state ? 'on' : 'off');
    var request = new ApiRequest('world', 'pvp');
    request.onSuccess(function(){
        alert(state == 'on' ? AdminBukkit.t('worldutils', 'PVP was successfully activated!') : AdminBukkit.t('worldutils', 'PVP was successfully deactivated!'));
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
            case 2:
                alert(AdminBukkit.t('worldutils', 'World not found.'));
                break;
            case 3:
                alert(AdminBukkit.t('worldutils', 'Invalid state has been entered.\nPlease inform an administrator.'));
                break;
        }
    });
    request.execute({world: world, pvp: state});
}

function world_storm(world)
{
    var state = confirm(AdminBukkit.t('worldutils', 'Should it be stormy or not?\n\nOK to turn it stormy, Cancel to turn it sunny.'));
    state = (state ? 'on' : 'off');
    var request = new ApiRequest('world', 'storm');
    request.onSuccess(function(){
        alert(state == 'on' ? AdminBukkit.t('worldutils', 'It is stormy now!') : AdminBukkit.t('worldutils', 'It is not stormy anymore!'));
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
            case 2:
                alert(AdminBukkit.t('worldutils', 'World not found.'));
                break;
            case 3:
                alert(AdminBukkit.t('worldutils', 'Invalid state has been entered.\nPlease inform an administrator.'));
                break;
        }
    });
    request.execute({world: world, storm: state});
}

function world_spawn(world)
{
    var target = prompt(AdminBukkit.t('worldutils', 'Enter the spawn location (format: x,y,z) or a player name:'), '');
    if (!target)
    {
        return;
    }
    var data = {
        world: world
    };
    target = target.replace(/\s/g, '');
    if (target.match(/^(\-)?\d+,(\-)?\d+,(\-)?\d+$/))
    {
        data.location = target;
    }
    else if (target.match(/^[\w\d\._]+$/i))
    {
        data.player = target;
    }
    else
    {
        alert(worldutilsLang.spawn_invalidformat);
        return;
    }
    var request = new ApiRequest('world', 'spawn');
    request.onSuccess(function(){
        alert(AdminBukkit.t('worldutils', 'The spawn was successfully moved!'));
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
            case 2:
                alert(AdminBukkit.t('worldutils', 'World not found.'));
                break;
            case 3:
            case 5:
                alert(AdminBukkit.t('worldutils', 'Invalid location!'));
                break;
            case 4:
                alert(AdminBukkit.t('worldutils', 'The location has the wrong format!'));
                break;
        }
    });
    request.method('POST');
    request.execute(data);
}
