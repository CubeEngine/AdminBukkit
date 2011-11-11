// @todo taps -> spaces
class Server
{
    private static $instances = array();
    
    private $id;
    private $host;
    private $port;
    private $authkey;
    private $owner;
    private $members;
    
    private function __construct($serverId)
    {
        $this->id = $serverId;
    }
    
    public static function getInstance($serverId)
    {
        if (!isset(self::$instances[$serverId]))
        {
            self::$instances[$serverId] = new self($serverId);
        }
        return self::$instances[$serverId];


    public function getId()
    {
        return $this->id;
    }
    
    public function getHost()
    {
        return $this->host;
    }
    
    public function getPort()
    {
        return $this->port;
    }
    
    public function getAuthKey()
    {
        return $this->authkey;
    }
    
    public function getOwner()
    {
        return $this->owner;
    }
    
    public function getMembers()
    {
        return $this->members;
    }
}