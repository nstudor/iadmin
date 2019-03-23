<?php foreach ($panelData as $r) { ?>
    <div class="col-xs-4 col-sm-3 col-lg-2 embed-responsive embed-responsive-4by3"><div class="panel" style="background-color:<?= $r['backcolor'] ?>; border-color:<?= $r['bordercolor'] ?>;">
            <div class="embed-responsive-item text-center">
                <a href="<?php echo $r['link'] ?>"<?php if ($r['newtab'] == 'Y') echo ' target="_blank"' ?> style="color:<?= $r['textcolor'] ?>;"><br><i class="fa fa-<?php echo $r['fontawesome'] ?>" aria-hidden="true"></i><br /><?php echo $r['denumire'] ?></a>
            </div>
        </div>
    </div>
<?php } ?>