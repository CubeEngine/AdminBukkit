var worldutilsLang = new WorldutilsLang();

function world_create(onSuccess)
{
    alert(genericLang.function_disabled);
    return false;
    
    var data = new Object();
    var world = prompt(worldutilsLang.create_name, '');
    if (!world)
    {
        return false;
    }
    world = world.replace(/\s/g, '');
    if (!world.match(/^[\w\d-]+$/))
    {
        alert(worldutilsLang.create_invalidname);
    }
    data.world = world;
    var seed = prompt(worldutilsLang.create_seed, '');
    if (seed)
    {
        data.seed = seed;
    }
    data.environment = 'normal';
    var env = prompt(worldutilsLang.create_env, '');
    if (env == 'normal' || env == 'nether')
    {
        data.environment = env;
    }
    else
    {
        alert(worldutilsLang.create_invalidenv);
        return false;
    }
    if (confirm(worldutilsLang.create_warning))
    {
        var request = new ApiRequest('world', 'create');
        request.onSuccess(function(){
            alert(worldutilsLang.create_success);
            if (onSuccess && onSuccess instanceof Function)
            {
                onSuccess();
            }
        });
        request.onFailure(function(code){
            switch (code)
            {
                case 1:
                    alert(worldutilsLang.create_noname);
                    break;
                case 2:
                    alert(worldutilsLang.create_alreadyexists);
                    break;
                case 3:
                    alert(worldutilsLang.create_invalidenv);
                    break;
            }
        });
        request.execute(data);
    }
    return false;
}

function world_time(world)
{
    var time = prompt(worldutilsLang.time_enter, '');
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
        alert(worldutilsLang.time_success);
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
            case 2:
                alert(worldutilsLang.world_notfound)
                break;
            case 3:
            case 4:
                alert(worldutilsLang.time_invalid);
                break;
        }
    });
    request.execute({world: world, time: time});
}

function world_pvp(world)
{
    var state = confirm(worldutilsLang.pvp_state);
    state = (state ? 'on' : 'off');
    var request = new ApiRequest('world', 'pvp');
    request.onSuccess(function(){
        alert(state == 'on' ? worldutilsLang.pvp_success_on : worldutilsLang.pvp_success_off);
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
            case 2:
                alert(worldutilsLang.world_notfound);
                break;
            case 3:
                alert(worldutilsLang.world_invalidstate);
                break;
        }
    });
    request.execute({world: world, pvp: state});
}

function world_storm(world)
{
    var state = confirm(worldutilsLang.storm_state);
    state = (state ? 'on' : 'off');
    var request = new ApiRequest('world', 'storm');
    request.onSuccess(function(){
        alert(state == 'on' ? worldutilsLang.storm_success_on : worldutilsLang.storm_success_off);
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
            case 2:
                alert(worldutilsLang.world_notfound);
                break;
            case 3:
                alert(worldutilsLang.world_invalidstate);
                break;
        }
    });
    request.execute({world: world, storm: state});
}

function world_spawn(world)
{
    var location = prompt(worldutilsLang.spawn_location, '');
    if (!location)
    {
        return;
    }
    location = $.trim(location);
    if (!location.match(/^(\-)?\d+,(\-)?\d+,(\-)?\d+$/))
    {
        alert(worldutilsLang.spawn_invalidformat);
        return;
    }
    var request = new ApiRequest('world', 'spawn');
    request.onSuccess(function(){
        alert(worldutilsLang.spawn_success);
    });
    request.onFailure(function(code){
        switch (code)
        {
            case 1:
            case 2:
                alert(worldutilsLang.world_notfound);
                break;
            case 3:
            case 4:
                alert(worldutilsLang.spawn_invalidlocation);
                break;
        }
    });
    request.method('POST');
    request.execute({world: world, location: location});
}
