var worldutilsLang = new WorldutilsLang();

function world_create()
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
        apiCall('world', 'create', function(data){
            alert(worldutilsLang.create_success);
            refreshData();
        }, data);
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
    time = $.trim(time);
    if (time.match(/^\d+$/))
    {} // leave as is
    else if (time.match(/^\d{1,2}:\d{1,2}$/))
    {
        var timeParts = time.split(':');
        var hourTicks = 24000 / 24;
        var minuteTicks = hourTicks / 60;
        time = timeParts[0] * hourTicks;
        time += Math.round(timeParts[1] * minuteTicks);
    }
    else
    {
        alert(worldutilsLang.time_invalidformat);
        return;
    }
    apiCall('world', 'time', function(data){
        alert(worldutilsLang.time_success);
    }, {world: world, time: time});
}

function world_pvp(world)
{
    var state = confirm(worldutilsLang.pvp_state);
    state = (state ? 'on' : 'off');
    apiCall('world', 'pvp', function(data){
        alert(state == 'on' ? worldutilsLang.pvp_success_on : worldutilsLang.pvp_success_off);
    }, {world: world, pvp: state});
}

function world_storm(world)
{
    var state = confirm(worldutilsLang.storm_state);
    state = (state ? 'on' : 'off');
    apiCall('world', 'storm', function(data){
        alert(state == 'on' ? worldutilsLang.storm_success_on : worldutilsLang.storm_success_off);
    }, {world: world, storm: state});
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
    apiCall('world', 'spawn', function(data){
        alert(worldutilsLang.spawn_success);
    }, {world: world, location: location}, 'POST');
}
