window.AdminBukkit = (function(){
    var AdminBukkit = function() {
        var self = this;
        var languages = [];

        var loadLanguage = function(cat) {
            $.ajax({
                url: BASE_PATH + '/index.php/javascript/translation?cat=' + cat,
                async: false,
                timeout: 2,
                success: function(data, textStatus, jqXHR) {
                    jQuery.globalEval(data);
                }
            });
        }

        this.registerLanguage = function(cat, messages)
        {
            if (typeof messages == 'object')
            {
                languages['' + cat] = messages;
            }
        }

        this.t = function(cat, message) {
            if (!languages[cat])
            {
                loadLanguage(cat);
            }
            if (languages[cat] && typeof languages[cat][message] != 'undefined')
            {
                return languages[cat][message];
            }
            else
            {
                return message;
            }

        }

        this.urlencode = function(str) {
            function parse(match) {
                var dec = parseInt(match.substr(1), 16)
                if (dec > 127)
                {
                    return String.fromCharCode(dec);
                }
                return match;
            }

            return escape(str).replace(/%[a-f0-9]{2}/ig, parse);
        }

        this.redirectTo = function(target, message) {
            if (target)
            {
                if (message)
                {
                    target += (target.indexOf('?') == -1 ? '?' : '&')
                            + '_message='
                            + this.urlencode(message);

                }
                document.location.href = target;
            }
        }

        this.appendSession = function(target)
        {
            if (!target.match(new RegExp(SESS_QUERY, 'i')))
            {
                target += (target.match(/\?/) ? '&' : '?') + SESS_QUERY;
            }
            return target;
        }

        this.realSort = function(a, b)
        {
            a = a.toLowerCase();
            var array = new Array(a, b.toLowerCase());
            return (array.sort()[0] == a ? -1 : 1);
        }

        this.isDataDifferent = function(oldData, data)
        {
            if (!oldData)
            {
                return true;
            }
            if (oldData.length != data.length)
            {
                return true;
            }
            for (var i = 0; i < oldData.length; ++i)
            {
                if (oldData[i] != data[i])
                {
                    return true;
                }
            }
            return false;
        }

        this.parseColors = function(string)
        {
            var regex = /§([0-9a-f])/i;
            var counter = 0;
            var last = '';
            
            function parse(match) {
                if (last != match[1]) {
                    last = match[1];
                    try {
                        ++counter;
                        return '<span class="' + this.getChatColorClassByChar(match[1]) + '">'
                    }
                    catch (e)
                    {}
                }
                return '';
            }

            while (string.match(regex)) {
                string = string.replace(regex, parse);
            }

            return string + (new Array(counter)).join('</span>');
        };

        this.getChatColorClassByChar = function(colorChar) {
            var colorName;
            switch (colorChar) {
                case '0':
                    colorName = 'black';
                    break;
                case '1':
                    colorName = 'dark-blue';
                    break;
                case '2':
                    colorName = 'dark-green';
                    break;
                case '3':
                    colorName = 'teal';
                    break;
                case '4':
                    colorName = 'dark-red';
                    break;
                case '5':
                    colorName = 'purple';
                    break;
                case '6':
                    colorName = 'gold';
                    break;
                case '7':
                    colorName = 'gray';
                    break;
                case '8':
                    colorName = 'dark-gray';
                    break;
                case '9':
                    colorName = 'blue';
                    break;
                case 'a':
                    colorName = 'bright-green';
                    break;
                case 'b':
                    colorName = 'aqua';
                    break;
                case 'c':
                    colorName = 'red';
                    break;
                case 'd':
                    colorName = 'pink';
                    break;
                case 'e':
                    colorName = 'yellow';
                    break;
                case 'f':
                    colorName = 'white';
                default:
                    throw 'Unknown color character!';
            }

            return 'chatcolor-' + colorName;
        }
        
        this.getEnvById = function(id) {
            switch (id) {
                case -1:
                    return 'NETHER';
                case 0:
                    return 'NORMAL';
                case 1:
                    return 'THE_END';
                default:
                    return 'UNKNOWN';
            }
        }

        this.getGamemodeById = function(id) {
            switch (id) {
                case 0:
                    return 'SURVIVAL';
                case 1:
                    return 'CREATIVE';
                default:
                    return 'UNKNOWN';
            }
        }
    };

    return new AdminBukkit();
})();

window.$AB = window.AdminBukkit;