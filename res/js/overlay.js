function Overlay(element)
{
    var $this = this;
    var $jElem = $(element);
    if (!$jElem)
    {
        throw "The overlay needs a valid element to be attached!";
    }
    $jElem.click(function(e){
        $this.toggle()
    });
    $jElem.find('.toggleoverlay').click(function(e){
        e.preventDefault();
        $this.toggle();
    });

    this.toggle = function()
    {
        if (!this.isOpen())
        {
            this.open();
        }
        else
        {
            this.close();
        }
    }

    this.isOpen = function()
    {
        return ($jElem.css('display') != 'none');
    }

    this.open = function()
    {
        var event = new Event($jElem);
        $jElem.trigger('beforeOpenOverlay', event);
        if (event.isCancelled())
        {
            return;
        }
        $jElem.show('fast', function(){
            $jElem.trigger('openOverlay', event);
        });
    }

    this.close = function()
    {
        var event = new Event($jElem);
        $jElem.trigger('beforeCloseOverlay', event);
        if (event.isCancelled())
        {
            return;
        }
        $jElem.hide('fast', function(){
            $jElem.trigger('closeOverlay', event);
        });
    }

    this.getElement = function()
    {
        return $jElem;
    }
}