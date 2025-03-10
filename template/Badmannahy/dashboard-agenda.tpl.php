<?php
$re = mysql_query("SELECT * FROM login_agenda WHERE id_user=$_SESSION[userid] AND data='" . date("Y-m-d", $dd) . "' ORDER BY ora");
while ($r = mysql_fetch_assoc($re)) for ($i = 1; $i <= $r['durata']; $i++) $ag[$r['ora'] + $i - 1] = $r;
?>
<table class="table table-striped">
  <thead>
    <tr>
      <td width="15%">&nbsp;</td>
      <td><strong><?php echo strftime("%d %B %Y", $dd) ?></strong></td>
      <td width="5%">&nbsp;</td>
    </tr>
  </thead>
  <tbody>
    <?php for ($i = 16; $i <= 44; $i++) { ?>
      <tr>
        <td><?php echo floor($i / 2) ?><sup><?php echo 3 * ($i % 2) ?>0</sup></td>
        <td>
          <?php
          if (isset($ag[$i])) echo ($ag[$i]['id'] != $ag[$i - 1]['id'] ? $ag[$i]['subiect'] : " -- // --");
          else echo '&nbsp;';
          ?></td>
        <td width="5%">
          <?php if (!isset($ag[$i])) { ?>
            <a href="./?p=tadd-agenda&data=<?php echo date("Y-m-d", $dd) ?>&ora=<?php echo $i ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
          <?php } else { ?>
            <a href="./?p=toper-agenda-detalii&id=<?php echo $ag[$i]['id'] ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
          <?php } ?>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>