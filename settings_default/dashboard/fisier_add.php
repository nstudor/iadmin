<select name="item[fisier]" class="form-control">
<?php 
 	$ret=scandir('script/dashboard');
	foreach($ret as $rt) if((strpos($rt,'.php')!==false)&&(strpos($rt,'_')===false)){
?><option value="<?php echo str_replace('.php','',$rt);?>"><?php echo str_replace('.php','',$rt); ?></option><?php } ?>
</select>