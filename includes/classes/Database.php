<?php 
 
    class Database{
		
        private $_connection;
        private static $_instance;
        public static function getInstance() 
        {
            if(!self::$_instance) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
        
        private function __construct() 
        {
            $this->_connection = new pdo("sqlite:" . DB_PATH);
        }
        
        public function selectRecord(
            string $table,
            string $fields,
            array $conditionFields = [],
            array $conditionOperators = [],
            array $conditionValues = []
        )
        {
            //Function any time could be upgraded
            $countFields = sizeof($conditionFields);
            
            $sql = "SELECT " . $fields ." FROM " .$table. ""; 
            if($countFields > 0)
            {
                $sql .= " WHERE ";
                for($i = 0; $i < $countFields; $i++)
                {
                    if($i !== 0){
                        $sql .= "AND ";
                    }
                    $sql .= $conditionFields[$i];
                    $sql .= " ";
                    $sql .=  $conditionOperators[$i];
                    $sql .= " ";
                    $sql .=  ":" . $conditionFields[$i];; 
                }
            }
            
            $query = $this->_connection->prepare($sql); 
            if($countFields > 0)
            {
                for($i = 0; $i < $countFields; $i++){
                    $query->bindValue(":" . $conditionFields[$i], $conditionValues[$i], PDO::PARAM_STR);
                }
            }
            
            $query->execute();
            $result = $query->fetchAll(); 
            
            return $result;
        }
        
        public function insertRecord($table, $records, $rowNames)
        {
            
            $placeholder = array();
            
            for ($i = 0; $i < sizeof($records); $i++){
                $placeholder[$i] = ":" . $rowNames[$i];
            }
            
            $placeholder = implode(',', $placeholder);       
            $sql = "INSERT INTO ".$table." (".$rowNames.") VALUES (" . $placeholder . ")";        
            $query = $this->_connection->prepare($sql); 
            
            for ($i = 0; $i < sizeof($records); $i++){
                $query->bindValue(":" . $rowNames[$i], $records[$i], PDO::PARAM_STR);
            }
    
            $query->execute();
        }
    }
	