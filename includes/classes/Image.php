<?php
    Class Image{
        
        public $name;
        public $url;
        public $externalUrl;
        public $extension;
        
        function addName(string $name){
            $this->name = $name;
        }
        
        function addUrl(string $url){
            $this->url = $url;
        }
        
        function addExtension(string $ext){
            $this->extension = $ext;
        }
        
        function insertImage(){
            if(isset($this->name) && isset($this->url)){
                $data = array($this->name, $this->url);
                $rowNames = "ImageName, ImageUrl";
                
                $db = Database::getInstance();
                $db->insertRecord('Images', $data, $rowNames);
            }else{
                //To do: log to file here
            }
        }
        
        function selectImages(){
            $db = Database::getInstance();
            $results = $db->selectRecord(
                'Images',
                "ImageName, ImageUrl"
                );
            return $results;
        }
        
        function moveImage(string $uploadDir, $imageFile, array $allowedExt){
            if(in_array($this->extension, $allowedExt)){
                
                $fileUpload = $uploadDir.basename($imageFile['name']);
                $fileExtension = strtolower(pathinfo($imageFile['name'], PATHINFO_EXTENSION));
                
                if(in_array($fileExtension, $allowedExt)){
                    if (move_uploaded_file($imageFile['tmp_name'], $fileUpload)) {
                        return true;
                    }else{
                        //To do: log to file here
                        return false;
                    }
                }
            }
        }
        
        function uploadGoogleImage(string $saveToPath, string $gImageId, string $gImageFullName, string $gImageMimeType, string $gOuthToken){    
            
            $this->addExtension(IMAGE_EXTENSIONS[$gImageMimeType]);
            
            $getUrl = 'https://www.googleapis.com/drive/v3/files/' . $gImageId . '?alt=media';   
            $authHeader = 'Authorization: Bearer ' . $gOuthToken;
            
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $getUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authHeader));
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            
            $image = curl_exec($ch);
            
            $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            $error = curl_error($ch);
            
            curl_close($ch);
            
            if(!empty($this->extension)){
                $this->url = $gImageFullName;
                $fullImagePath = (string)$saveToPath . "\\" . $gImageFullName;
                
                // In the future to do rename for existing files
                if (!file_exists($fullImagePath)) {
                    fwrite(fopen($fullImagePath,'x'), $image);
                }
            }
        }
        
    }