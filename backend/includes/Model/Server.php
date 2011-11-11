// @todo taps -> spaces
class Server
{
    private static $instances = array();
    
    private $id;
    private $alias;
    private $host;
    private $port;
    private $authkey;
    private $owner;
    private $members;
    
    private function __construct($serverId)
    {
        try
        {
            $this->id = $serverId;
            $db = DatabaseManager::getDatabase();
            $result = $db->preparedQuery('SELECT id,`alias`,host,port,authkey,owner,members FROM ' . $db->getPrefix() . 'servers WHERE id=?', array($serverId));
            if (count($result))
            {
                $result = $result[0];
                $this->id = $result['id'];
                $this->alias = $result['alias'];
                $this->host = $result['host'];
                $this->port = $result['port'];
                $this->authkey = $result['authkey'];
                $this->owner = $result['owner'];
                $this->members = explode(',', $result['host']);
            }
            else
            {
                throw new Exception('The requested server was not found!')
            }
        }
        catch (Exception $e)
        {
            throw new Exception('Failed to load the server from database!');
        }
    }
    
    public static function getInstance($serverId)
    {
        if (!isset(self::$instances[$serverId]))
        {
            self::$instances[$serverId] = new self($serverId);
        }
        return self::$instances[$serverId];
    }
    
    public static function createServer($alias, $host, $port, $authkey, $owner, $members = array())
    {
        // @todo implement
    }


    public function getId()
    {
        return $this->id;
    }
    
    public function getAlias()
    {
        return $this->alias;
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
    
    public function delete()
    {
        // @todo implement
    }
}