<?php
    $count = 0;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["form-action"])) {
            if($_POST["form-action"] == "search"){
                $keyWord = $_POST["search-keyword"];
                if(!empty($keyWord)){
                    $Images = new Image();
                    $getImages = $Images->selectImagesByKeyWord($keyWord);
                    $count = count($getImages);
                }
            }
    }else{
       
        $Images = new Image();
        $getImages = $Images->selectImages();
        $count = count($getImages);
    }
?>


<div class="row mbottom-30">
    <div class="col">
        <form id="upload-form" action="" method="post">
        	<input type="text" name="form-action" id="form-action" class="form-control hidden" value="search">
            <div class="input-group">
            	<label for="image-name">Search by Keyword</label>
            	<div class="input-group">
                	<input type="text" name="search-keyword" id="search-keyword" class="form-control">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Search</button>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">

    <?php
        if($count > 0){
            foreach($getImages as $image){ 
    ?>
        	<div class="col-xs-12 col-sm-6 col-md-4">
        		<div class="image-item">
            		<p class="image-title">
            			<?php  
            			     echo $image["ImageName"];
            			?>
            		</p>
            		<img title="<?php echo $image["ImageName"] ?>" class="img-fluid" src="<?php echo SHORT_IMAGES_PATH . $image["ImageURL"] ?>">
        		</div>
       		</div>
	<?php 
            } 
        }else{
    ?>
    	<div class="col">
    		<h5>No Images Uploaded</h5>
    	</div>
    <?php
        }
	?>
</div>