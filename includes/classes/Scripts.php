<?php
	Class Scripts{
	    
	    function __construct(){
    	    $this->stylesheets = array();
    	    $this->javascripts = array();
    	    $this->sheetCount = 0;
    	    $this->scriptCount = 0;
    	    $this->outScripts = "";
    	    $this->outSheets = "";
	    }
	    
		public function addStylesheet(string $folderPath, string $fileName){
		    $this->sheetCount++;
		    $this->stylesheets[$this->sheetCount]["name"] = $fileName;
		    $this->stylesheets[$this->sheetCount]["path"] = $folderPath;  
		}
		
		public function addJavascript(string $folderPath, string $fileName, bool $deferLoad){
		    $this->scriptCount++;
		    $this->javascripts[$this->scriptCount]["name"] = $fileName;
		    $this->javascripts[$this->scriptCount]["path"] = $folderPath;
		    $this->javascripts[$this->scriptCount]["deferLoad"] = $deferLoad;
		}
		
		public function loadSheets(){
		    foreach($this->stylesheets as $sheets){
		       $this->outSheets .= "<link rel='stylesheet' type='text/css' href='" . $sheets["path"] . "/" . $sheets["name"] . "'>\n";
		    }
		    
		    return $this->outSheets;    
		}
		
		public function loadScripts(){
		    
		    foreach($this->javascripts as $jscript){
		        $this->outScripts .= "<script ";
                $this->outScripts .= "src='" . $jscript["path"] . "/" . $jscript["name"] . "'";
                if($jscript["deferLoad"] == true){
                    $this->outScripts .= " defer ";
                }
                $this->outScripts .= "></script>\n";
		    }
		    
		    return $this->outScripts; 
		}
	}
	
?>