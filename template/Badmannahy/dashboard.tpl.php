<?php
    foreach($panelRows as $r) {
?>
<div class="row dashboard">
<?php
    foreach($r['panels'] as $r2) {
        $panelData = $r2['data'] ?? [];
        $panelTpl = db_is_ident($r2['fisier']) && file_exists(__DIR__ . "/dashboard-$r2[fisier].tpl.php") ? __DIR__ . "/dashboard-$r2[fisier].tpl.php" : '';
?>
<div class="col col-12 col-sm-<?php echo (int)$r2['marimesm'] ?> col-lg-<?php echo (int)$r2['marimelg'] ?>">
<?php if($r2['vizibil']=='Y' && $panelTpl) {
    if(empty($r2['no_box'])) {?>
<div class="card" rel="<?= (int)$r2['id'] ?>">
    <div class="card-header <?= $tmpBackground ?> text-light">
        <b><?php echo $r2['denumire'] ?></b>
        <i class="float-end fa fa-chevron-<?php echo ($r2['deschis']=='N'?"down":"up") ?>"></i>
    </div>
    <div class="card-body"<?php if($r2['deschis']=='N') echo " style='display:none'"?>>
        <?php include($panelTpl) ?>
    </div>
</div>
    <?php } else { include($panelTpl); }} else echo "&nbsp;" ?>
</div>
<?php } ?>
</div>
<?php } ?>
<script type="text/javascript">
$('.dashboard .card-header i').click(function() {
    var card = $(this).closest('.card');
    var self = $(this);
    var body = card.find('.card-body');
    var wasOpen = body.is(':visible');
    body.slideToggle('slow');
    self.toggleClass('fa-chevron-up', !wasOpen).toggleClass('fa-chevron-down', wasOpen);
    // remember open / closed (needs modify right on the dashboard module)
    $.post("ajax/modal.php?p=mdoedit-dashboard", { id: card.attr('rel'), field: 'deschis', item: wasOpen ? 'N' : 'Y' });
});
</script>
