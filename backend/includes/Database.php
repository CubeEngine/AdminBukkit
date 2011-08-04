<?php
    abstract class Database
    {
        protected $db;
        protected $error;

        public abstract function connect();
        public abstract function getPrefix();
        
        public function preparedQuery($query, array $data, $return = true)
        {
            $this->connect();
            
            $statement = $this->db->prepare($query);
            $statement->execute($data);
            if ($return)
            {
                return $statement->fetchAll(PDO::FETCH_ASSOC);
            }
        }


        public function query($query, $return = true)
        {
            $this->connect();

            if ($return)
            {
                $result = $this->db->query($query);
                if ($result === false)
                {
                    throw new DatabaseException('The query failed!');
                }
                $fetchedResult = array();
                foreach ($result as $row)
                {
                    $fetchedResult[] = $row;
                }

                return $fetchedResult;
            }
            else
            {
                return ($this->db->exec($query) !== false);
            }
        }
        
        public function error()
        {
            return $this->error;
        }
    }
?>
