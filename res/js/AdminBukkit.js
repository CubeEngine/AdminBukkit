window.AdminBukkit = (function(){
    var AdminBukkit = function() {
        var self = this;
        var languages = [];

        var registerLanguage = function(cat) {
            
        }

        var loadLanguage = function(cat) {
            $.ajax({
                url: BASE_PATH + '/index.php/javascript/translation?cat=' + cat,
                async: false,
                timeout: 2,
                success: function(data, textStatus, jqXHR) {
                    eval(data);
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

        this.redirectTo = function(target) {
            if (target)
            {
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
                    var color = '';
                    last = match[1];
                    switch (match[1]) {
                        case '0':
                            color = '#000';
                            break;
                        case '1':
                            color = '#009';
                            break;
                        case '2':
                            color = '#090';
                            break;
                        case '3':
                            color = '#099';
                            break;
                        case '4':
                            color = '#800';
                            break;
                        case '5':
                            color = '#909';
                            break;
                        case '6':
                            color = '#F90';
                            break;
                        case '7':
                            color = '#CCC';
                            break;
                        case '8':
                            color = '#999';
                            break;
                        case '9':
                            color = '#00F';
                            break;
                        case 'a':
                            color = '#0F0';
                            break;
                        case 'b':
                            color = '#0FF';
                            break;
                        case 'c':
                            color = '#F00';
                            break;
                        case 'd':
                            color = '#F0F';
                            break;
                        case 'e':
                            color = '#FF0';
                            break;
                        case 'f':
                            color = '#000'; // white -> black for readability
                    }
                    if (color) {
                        ++counter;
                        return '<span style="color:' + color + ';">'
                    }
                }
                return '';
            }

            while (string.match(regex)) {
                string = string.replace(regex, parse);
            }

            return string + (new Array(counter)).join('</span>');
        };

    };

    return new AdminBukkit();
})();

var $AB = AdminBukkit;