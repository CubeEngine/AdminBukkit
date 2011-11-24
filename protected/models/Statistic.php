<?php
    class Statistic
    {
        private static $tableName = 'statistics';
        private $index;
        private $db;

        public function __construct($index)
        {
            if (substr_count($index, '*'))
            {
                throw new CModelException('No wildcards allowed!');
            }
            $this->index = $index;
            $this->db = Yii::app()->db;
        }

        public function __toString()
        {
            return $this->index;
        }

        public function getIndex()
        {
            return $this->index;
        }

        public function increment()
        {
            $affectedRows = $this->db->createCommand()->update(
                self::$tableName,
                array('value' => new CDbExpression('value + 1')),
                '`index` = :index',
                array(':index' => $this->index)
            );
            if (!$affectedRows)
            {
                $this->db->createCommand()->insert(self::$tableName, array(
                    'index' => $this->index,
                    'value' => 1
                ));
            }
        }

        public function getValue()
        {
            $result = $this->db->createCommand()
                    ->select('value')
                    ->from(self::$tableName)
                    ->where('`index` = :index', array(':index' => $this->index))
                    ->limit(1)
                    ->query();
            foreach ($result as $row)
            {
                return $row['value'];
            }
            return 0;
        }

        public static function getValues($partialIndex)
        {
            $result = Yii::app()->db->createCommand()
                    ->select(array('index', 'value'))
                    ->from(self::$tableName)
                    ->where('`index` like :index', array(':index' => str_replace('*', '%', $partialIndex)))
                    ->query();
            return $result->readAll();
        }
    }
?>
