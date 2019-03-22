<table class="table table-striped" style="color:#999">
<thead>
<tr style="height:25px;" class="alert-<?php echo $theme ?>">
  <th><a href="?data=<?php echo date("Y-m-d",strtotime(date("Y-m-d",$dd). " - 1 month")) ?>"><strong class="fa fa-chevron-left"></strong></a></th>
  <th colspan="5">
<span class="dropdown">
  <span class="dropdown-toggle" id="ddluna" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
<?php echo strtoupper(strftime("%B",$dd)) ?>    <span class="caret"></span>
  </span>
  <ul class="dropdown-menu" aria-labelledby="ddluna">
<?php for($j=1;$j<=12;$j++) { ?>
    <li><a href="./?data=<?php echo "$an-$j-$zi"; ?>"><?php echo strtoupper(strftime("%B",strtotime("2000-$j-01"))) ?></a></li>
<?php } ?>    
  </ul>
</span>  
<span class="dropdown">
  <span class="dropdown-toggle" id="ddanul" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
<?php echo strtoupper(strftime("%Y",$dd)) ?>    <span class="caret"></span>
  </span>
  <ul class="dropdown-menu" aria-labelledby="ddanul">
<?php for($j=$an-3;$j<=$an+3;$j++) { ?>
    <li><a href="./?data=<?php echo "$j-$lu-$zi"; ?>"><?php echo $j ?></a></li>
<?php } ?>    
  </ul>
</span>
  </th>
  <th><a href="?data=<?php echo date("Y-m-d",strtotime(date("Y-m-d",$dd). " + 1 month")) ?>" style="float:right"><strong class="fa fa-chevron-right"></strong></a></th>

</tr>
  <tr bgcolor="#FFFFFF" style="font-size:14px">
    <td><strong>Lu</strong></td>
    <td><strong>Ma</strong></td>
    <td><strong>Mi</strong></td>
    <td><strong>Jo</strong></td>
    <td><strong>Vi</strong></td>
    <td><strong>Sa</strong></td>
    <td><strong>Du</strong></td>
</tr>
</thead>
<tbody>
<tr>
<?php 
	$d1=strtotime(date("Y-m-1",strtotime("$an-$lu-22")));
	$nd1=date("N",$d1);
	$ndm=date("t",$dd);
	$n=0;

	for($i=2;$i<=$nd1;$i++)
		{ $n++;?><td>&nbsp;</td><?php }
	for($i=1;$i<=$ndm;$i++)
		{ $n++;?><td align="center"<?php if(strtotime("$an-$lu-$i")==strtotime("today")) echo ' style="background-color:#FCF"' ?>>
<a href="?data=<?php echo "$an-$lu-$i" ?>"><?php echo (strtotime("$an-$lu-$i")==$dd?"<strong style='color:#000'>$i</strong>":$i) ?></a>
</td><?php
	if(($n%7==0)&&($i!=$ndm)) echo "</tr><tr>";
 }
 while($n%7!=0)	{ $n++;?><td>&nbsp;</td><?php }
 ?>
  </tr>
</tbody>
</table>
