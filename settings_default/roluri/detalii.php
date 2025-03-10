<?php
	$special=1;
	$item=mysql_fetch_array(mysql_query("SELECT * FROM pagini WHERE id=".$_GET['id']));
?>

<form action="clickdoedit.php?p=tabel-pagini&pag=pagini&table=pagini&fld=content_l&id=<?php echo $_GET['id'] ?>" method="post" name="frm">
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td align="center">
    <textarea name="content_l" style="width:750px; height:400px;"><?php echo $item['content_l'] ?></textarea>
    </td>
  </tr>
  <tr>
    <td align="center"><input type="submit" value="OK" class="buton" />
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" value="CANCEL" onClick="parent.Shadowbox.close()" class="buton"  />
</td>
  </tr>
</table>
</form>