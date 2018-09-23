<select name="item[fisier]" class="form-control" id="ajaxitem">
<?php 
 	$ret=scandir('dashboard');
	foreach($ret as $rt) if((strpos($rt,'.php')!==false)&&(strpos($rt,'_')===false)){
?><option value="<?php echo str_replace('.php','',$rt);?>"<?php if($rt=="$item[fisier].php") echo ' selected' ?>><?php echo str_replace('.php','',$rt);?></option><?php } ?>
</select>