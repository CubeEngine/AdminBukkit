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
    if (SESS_APPEND)
    {
        $url = appendSession($url);
    }
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
        if (typeof callback == 'function' || callback == null)
        {
            $onSuccess = callback;
        }
    }
    
    this.onFailure = function(callback)
    {
        if (typeof callback == 'function' || callback == null)
        {
            $onFailure = callback;
        }
    }
    
    this.onBeforeSend = function(callback)
    {
        if (typeof callback == 'function' || callback == null)
        {
            $onBeforeSend = callback;
        }
    }
    
    this.onComplete = function(callback)
    {
        if (typeof callback == 'function' || callback == null)
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
        if (!options.async)
        {
            options.timeout = 2;
        }
        
        return $.ajax(options);
    }
}