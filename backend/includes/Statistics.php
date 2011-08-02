<?php
    class Statistics
    {
        public static function increment($index)
        {
            $db = DatabaseManager::instance()->getDatabase();
            $data = array($index);
            $query = 'SELECT count(*) AS \'count\' FROM statistics WHERE `index`=?';
            $result = $db->preparedQuery($query, $data);
            if ($result[0]['count'] > 0)
            {
                $query = 'UPDATE statistics SET value=value+1 WHERE `index`=?';   
            }
            else
            {
                $query = 'INSERT INTO statistics (`index`, value) VALUES (?, 1)';
            }
            return $db->preparedQuery($query, $data, false);
        }
        
        public static function getValue($index)
        {
            $db = DatabaseManager::instance()->getDatabase();
            $query = 'SELECT value FROM statistics WHERE `index`=?';
            $result = $db->preparedQuery($query, array($index));
            if (count($result))
            {
                return $result[0]['value'];
            }
            else
            {
                return null;
            }
        }
        
        public static function getValues($partialIndex)
        {
            $db = DatabaseManager::instance()->getDatabase();
            $partialIndex = str_replace('*', '%', $partialIndex);
            $query = 'SELECT `index`, value FROM statistics WHERE `index` LIKE ?';
            return $db->preparedQuery($query, array($partialIndex));
        }
    }
?>
