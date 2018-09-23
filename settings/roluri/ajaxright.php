<?php 
	error_reporting(0);
	session_start();
	include('../../defines.php');
	$fields=array(
		'v'=>'vizualizare',
		'a'=>'adaugare',
		'm'=>'modificare',
		's'=>'stergere',
	);
	$item=@mysql_fetch_assoc(@mysql_query("SELECT * FROM login_rights WHERE id_role=$_GET[idu] AND id_menu=$_GET[idd]"));
	if(!isset($item[$fields[$_GET['tip']]]))
		mysql_query("INSERT INTO login_rights (id_role, id_menu, ".$fields[$_GET['tip']].") VALUES ($_GET[idu], $_GET[idd], 'Y')");
		else
		mysql_query("UPDATE login_rights SET ".$fields[$_GET['tip']]."='".($item[$fields[$_GET['tip']]]=='Y'?'N':'Y')."' WHERE id_role='$_GET[idu]' AND id_menu='$_GET[idd]'");
?><button class="btn btn-<?php echo ($item[$fields[$_GET['tip']]]=='Y'?'danger':'success'); ?> spc" onclick="butonat(<?php echo $_GET['idd'] ?>,'<?php echo $_GET['tip'] ?>')">O</button>