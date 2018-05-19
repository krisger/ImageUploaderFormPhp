<?php
    $Images = new Image();
    $getImages = $Images->selectImages();
    $count = count($getImages);
?>
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