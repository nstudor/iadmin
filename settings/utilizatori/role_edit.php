<select name="item[role]" class="form-control" id="ajaxitem">
<?php 
	$ret=mysql_query("SELECT * FROM login_roles WHERE id!=1 ORDER BY rolename");
	while($rt=mysql_fetch_array($ret))
	{
?><option value="<?php echo $rt['id'];?>"<?php if($rt['id']==$item['role']) echo ' selected' ?>><?php echo $rt['rolename']; ?></option><?php } ?>
</select>