<?php 
 
    class Database{
		
        private $_connection;
        private static $_instance;
        public static function getInstance() {
            if(!self::$_instance) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
        
        private function __construct() {
            $this->_connection = new pdo("sqlite:" . DB_PATH);
        }
        
        public function selectRecord($table, $rowNames){
            //Function any time could be upgraded
            
            $sql = "SELECT " . $rowNames ." FROM " .$table. ""; 
            
            $query = $this->_connection->prepare($sql);
            $query->execute();
            
            $result = $query->fetchAll();         
            return $result;
        }
        
        public function insertRecord($table, $records, $rowNames){
            
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
	