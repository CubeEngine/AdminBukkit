function ApiRequest(controller, action)
{
    if (!controller || !action)
    {
        throw "Controller and action are required!";
    }
    var $this = this;
    var $controller = controller;
    var $action = (!!action ? action : '');
    var $url = 'backend/apiproxy.php/' + $controller + '/' + $action;
    var $data = null;
    var $sync = false;
    var $method = 'GET';
    
    var $onSuccess = null;
    var $onFailure = null;
    var $onBeforeSend = function(){
        setProgress(true);
    };
    var $onComplete = function(){
        setProgress(false);
    };
    
    this.onSuccess = function(callback)
    {
        if (callback && (callback instanceof Function))
        {
            $onSuccess = callback;
        }
    }
    
    this.onFailure = function(callback)
    {
        if (callback && (callback instanceof Function))
        {
            $onFailure = callback;
        }
    }
    
    this.onBeforeSend = function(callback)
    {
        if (callback && (callback instanceof Function))
        {
            $onBeforeSend = callback;
        }
    }
    
    this.onComplete = function(callback)
    {
        if (callback && (callback instanceof Function))
        {
            $onComplete = callback;
        }
    }
    
    this.sync = function(state)
    {
        if (typeof state !== 'undefined')
        {
            $sync = !!state;
        }
        else
        {
            return $sync;
        }
    }
    
    this.method = function(method)
    {
        if (typeof state !== 'undefined')
        {
            $method = method;
        }
        else
        {
            return $method;
        }
    }
    
    this.url = function()
    {
        return $url;
    }
    
    this.data = function(data)
    {
        if (typeof data !== 'undefined')
        {
            $data = data;
        }
        else
        {
            return $data;
        }
    }
    
    this.execute = function(data)
    {
        if (!ApiRequest.ready)
        {
            return null;
        }
        var requestData = $data;
        if (data && data instanceof Object)
        {
            requestData = data;
        }
        
        var options = {
            url: $url,
            type: $method,
            data: requestData,
            async: !$sync,
            success: $onSuccess,
            error: $onFailure,
            beforeSend: $onBeforeSend,
            complete: $onComplete
        }
        if (options.async)
        {
            options.timeout = 2;
        }
        
        return $.ajax(options);
    }
}

ApiRequest.prototype.ready = false;

jQuery(function(){
    ApiRequest.ready = true;
}).bind('unload', function(){
    ApiRequest.ready = false;
});