<?php 
$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    if(empty($_POST["form-action"]))
    {
        $imageUrl = $_FILES["image-file"] ?? '';
        $imageName = $_POST["image-name"] ?? '';
        $externalUrl = $_POST["google-image-file"];
        
        $gImageId = $_POST["google-image-id"] ?? '';
        $gImageName = $_POST["google-image-name"] ?? '';
        $gImageMimeType = $_POST["google-image-mime-type"] ?? '';
        $gOuthToken = $_POST["google-outh-token"] ?? '';
    
        if(!empty($externalUrl) && !empty($imageName)) // In the future replace validation with more advanced Class Validation
        { 
    
            $uploadDir = FULL_IMAGES_PATH;
            $image = new Image();
            
            $image->uploadGoogleImage($uploadDir, $gImageId, $gImageName, $gImageMimeType, $gOuthToken);
            $image->addName($imageName);
            $image->insertImage(); 
            //Prevents from resubmission
            header("Location:" . $_SERVER['PHP_SELF']);
            
        }
        else if(!empty($imageName) && !empty($imageUrl))
        {
            
            $uploadDir = SHORT_IMAGES_PATH;
            $fileUpload = $uploadDir.basename($imageUrl['name']);
            
            $image = new Image();
            $image->addExtension(strtolower(pathinfo($imageUrl['name'], PATHINFO_EXTENSION)));
            
            if($image->moveImage($uploadDir, $imageUrl, ALLOWED_IMAGE_TYPES))
            {
                $image->addName($imageName);
                $image->addUrl($imageUrl["name"]);
                $image->insertImage();
                
                //Prevents from resubmission
                header("Location:" . $_SERVER['PHP_SELF']);   
            }
        }
    }
    else
    {
        $error = true;
    }
}

?>

<form id="upload-form" action="" method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="col">
			<h1 class="text-center">Image upload form</h1>
        	<div class="form-group">
        		<label for="image-name">Enter image name<span class="required">*</span></label>
        		<input type="text" class="form-control" name="image-name" id="image-name" placeholder="Enter Image Name">  
        	</div>
        	<div id="local-picker" class="form-group">
        		<label for="image-file">Upload from local pc<span class="required">*</span></label>
        		<input type="file" class="form-control-file" name="image-file" id="image-file">
        	</div>
        	<div id="google-picker" class="form-group hidden">
        		<label for="image-file">Upload from google drive<span class="required">*</span></label>
        		<input class="form-control" type="text" class="form-control-file" readonly="readonly" name="google-image-file" id="google-image-file">
        		<button type="button" id="auth" class="btn btn-default mtop-10" disabled>Choose File</button>
        	</div>
        	<div class="form-group">
        		<input type="checkbox" id="upload-google-drive" name="upload-google-drive" onClick="uploadWithGoogle()" />
    			<label for="subscribeNews">Upload with google drive?</label>
    		</div>
        	<input class="hidden" type="text" name="google-image-id" id="google-image-id">
        	<input class="hidden" type="text" name="google-image-name" id="google-image-name">
        	<input class="hidden" type="text" name="google-image-mime-type" id="google-image-mime-type">
        	<input class="hidden" type="text" name="google-outh-token" id="google-outh-token">
        	
        	<button type="submit" class="btn btn-primary">Upload</button>
    	</div>
	</div>
	<?php echo ($error === true) ? "<p class='text-danger'>All fields are required*</p>" : ""; ?>
</form>

