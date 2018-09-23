<select name="item[role]" class="form-control">
<?php 
	$ret=mysql_query("SELECT * FROM login_roles WHERE id!=1  ORDER BY rolename");
	while($rt=mysql_fetch_array($ret))
	{ ?><option value="<?php echo $rt['id'];?>"><?php echo $rt['rolename'];?></option><?php } ?>
</select>