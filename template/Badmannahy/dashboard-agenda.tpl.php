<?php
$dd = $panelData['dd'] ?? strtotime('today');
$ag = $panelData['slots'] ?? [];
?>
<table class="table table-striped">
  <thead>
    <tr>
      <td width="15%">&nbsp;</td>
      <td><strong><?php echo format_strftime("%d %B %Y", $dd) ?></strong></td>
      <td width="5%">&nbsp;</td>
    </tr>
  </thead>
  <tbody>
    <?php for ($i = $panelData['start'] ?? 16; $i <= ($panelData['stop'] ?? 44); $i++) { ?>
      <tr>
        <td><?php echo floor($i / 2) ?><sup><?php echo 3 * ($i % 2) ?>0</sup></td>
        <td>
          <?php
          if (isset($ag[$i])) echo (($ag[$i]['id'] != ($ag[$i - 1]['id'] ?? null)) ? $ag[$i]['subiect'] : " -- // --");
          else echo '&nbsp;';
          ?></td>
        <td width="5%">
          <?php if (!isset($ag[$i])) { ?>
            <a href="./agenda-add.htm?data=<?php echo date("Y-m-d", $dd) ?>&ora=<?php echo $i ?>"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
          <?php } else { ?>
            <a href="./agenda-edit-id-<?php echo (int)$ag[$i]['id'] ?>.htm"><i class="fa fa-eye" aria-hidden="true"></i></a>
          <?php } ?>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>
