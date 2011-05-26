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
    
    function onError(jqXHR, textStatus, thrownError)
    {
        var errCode = $.trim(jqXHR.responseText);
        // only process errors with a response
        if (errCode)
        {
            errCode = errCode.split(',');
            var major = parseInt(errCode[0]);
            var minor = 0;
            if (errCode.length > 1)
            {
                minor = parseInt(errCode[1]);
            }
            switch (major)
            {
                case -1:
                    alert(genericLang.error_unknown);
                    break;
                case 1:
                    alert(genericLang.error_invalidpath);
                    break;
                case 2:
                    alert(genericLang.error_authfailed);
                    redirectTo('home.html?msg=' + urlencode(genericLang.redirect_msg));
                    break;
                case 3:
                    // execute onFailure if set
                    if (typeof $onFailure == 'function')
                    {
                        $onFailure(minor);
                    }
                    break;
                case 4:
                    alert(genericLang.error_notimplemented);
                    break;
                case 5:
                    alert(genericLang.error_apinotfound);
                    break;
                default:
                    //debug
                    alert('Failed: ' + jqXHR.responseText);
                    //do nothing
                    break;
            }
        }
    }
    
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
            error: onError,
            beforeSend: $onBeforeSend,
            complete: $onComplete
        };
        if (!options.async)
        {
            options.timeout = 2;
        }
        
        return $.ajax(options);
    }
}