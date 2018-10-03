<?php 
    $item=db_select("*", "login_rights", "id_role=$_GET[idu] AND id_menu=$_GET[idd]")[0];
    $menu=db_select("*", "login_menu", "id=$item[id_menu]")[0];
    $x=explode('-',$menu['link']);
    $item['v']=explode(' ',$item['details_v']);
    $item['a']=explode(' ',$item['details_a']);
    $item['m']=explode(' ',$item['details_m']);
    $item['d']=explode(' ',$item['details_d']);
    include("../settings/$x[1]/config.php");
?>
<form action="" method="post">
<input name="id" type="hidden" value="<?php echo $_GET['idd'] ?>" />
<input name="ch[v][]" type="hidden" value="" />
<input name="ch[a][]" type="hidden" value="" />
<input name="ch[m][]" type="hidden" value="" />
<input name="ch[d][]" type="hidden" value="" />
<table width="100%" class="table table-striped table-bordered">
<thead>
  <tr>
    <th>&nbsp;</th>
    <th width="15%">Vizualizare</th>
    <th width="15%">Adaugare</th>
    <th width="15%">Modificare</th>
    <th width="15%">Stergere</th>
  </tr>
</thead>
<tbody>
<?php foreach($specials as $v) {?>
  <tr>
    <td><?php echo (isset($stitles[$v])?$stitles[$v]:$v) ?></td>
    <td align="center"><input name="ch[v][]" type="checkbox" value="<?php echo $v ?>"<?php if(in_array($v,$item['v'])) echo " checked" ?> id="<?php echo $v ?>v" /><label for="<?php echo $v ?>v"></label></td>
    <td align="center"><input name="ch[a][]" type="checkbox" value="<?php echo $v ?>"<?php if(in_array($v,$item['a'])) echo " checked" ?> id="<?php echo $v ?>a" /><label for="<?php echo $v ?>a"></label></td>
    <td align="center"><input name="ch[m][]" type="checkbox" value="<?php echo $v ?>"<?php if(in_array($v,$item['m'])) echo " checked" ?> id="<?php echo $v ?>m" /><label for="<?php echo $v ?>m"></label></td>
    <td align="center"><input name="ch[d][]" type="checkbox" value="<?php echo $v ?>"<?php if(in_array($v,$item['d'])) echo " checked" ?> id="<?php echo $v ?>d" /><label for="<?php echo $v ?>d"></label></td>
  </tr>
<?php } ?>
</tbody>
<tfoot>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="3" align="center"><button class="btn btn-<?php echo $theme ?> spc" type="submit"><strong class="glyphicon glyphicon-ok"></strong> OK</button></td>
    </tr>
 </tfoot>
</table>
</form>