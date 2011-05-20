<?php
    class Statistics
    {
        public static function increment($index)
        {
            $db = SQLite::instance();
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
            $query = 'SELECT value FROM statistics WHERE `index`=?';
            $result = SQLite::instance()->preparedQuery($query, array($index));
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
            $partialIndex = str_replace('*', '%', $partialIndex);
            $query = 'SELECT `index`, value FROM statistics WHERE `index` LIKE ?';
            return SQLite::instance()->preparedQuery($query, array($partialIndex));
        }
    }
?>
