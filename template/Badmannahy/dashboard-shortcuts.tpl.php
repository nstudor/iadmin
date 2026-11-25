<?php
// Shortcuts panel. Works with both login__shortcuts layouts:
//  - stacked icons: fa1, fa2, fa1type, fa2type, fa1color, fa2color, fa1shadow, fa2shadow, extraclass, textcolor / backcolor / bordercolor as color names
//  - single icon:   fontawesome, textcolor / backcolor / bordercolor as CSS colors
$h = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES);
foreach (($panelData ?? []) as $r) {
    $newTab = (($r['newtab'] ?? 'N') == 'Y') ? ' target="_blank"' : '';
    if (!empty($r['fa1']) || !empty($r['fa2'])) { ?>
    <div class="col-3 col-sm-2 col-lg-1">
      <div class="ratio ratio-1x1">
        <div class="panel">
            <div class="text-center">
                <a href="<?= $h($r['link'] ?? '') ?>"<?= $newTab ?> class="text-<?= $h($r['textcolor'] ?? '') ?> bg-<?= $h($r['backcolor'] ?? '') ?> border-<?= $h($r['bordercolor'] ?? '') ?> <?= $h($r['extraclass'] ?? '') ?>">
                    <span class="fa-stack fa-2x <?= $h($r['extraclass'] ?? '') ?> text-<?= $h($r['textcolor'] ?? '') ?>">
                        <?php if (!empty($r['fa1'])) { ?><i class="fa<?= $h($r['fa1type'] ?? 's') ?> fa-<?= $h($r['fa1']) ?> text-<?= $h($r['fa1color'] ?? '') ?> shadow-<?= $h($r['fa1shadow'] ?? '') ?> fa-stack-1x"></i><?php } ?>
                        <?php if (!empty($r['fa2'])) { ?><i class="fa<?= $h($r['fa2type'] ?? 's') ?> fa-<?= $h($r['fa2']) ?> text-<?= $h($r['fa2color'] ?? '') ?> shadow-<?= $h($r['fa2shadow'] ?? ($r['fa1shadow'] ?? '')) ?> fa-stack-1x"></i><?php } ?>
                    </span>
                    <br><br><?= $h($r['denumire'] ?? '') ?></a>
            </div>
        </div>
      </div>
    </div>
<?php } else { ?>
    <div class="col-4 col-sm-3 col-lg-2">
      <div class="ratio ratio-4x3">
        <div class="panel" style="background-color:<?= $h($r['backcolor'] ?? '') ?>; border-color:<?= $h($r['bordercolor'] ?? '') ?>;">
            <div class="text-center">
                <a href="<?= $h($r['link'] ?? '') ?>"<?= $newTab ?> style="color:<?= $h($r['textcolor'] ?? '') ?>;"><br><i class="fa fa-<?= $h(($r['fontawesome'] ?? '') ?: 'link') ?>" aria-hidden="true"></i><br /><?= $h($r['denumire'] ?? '') ?></a>
            </div>
        </div>
      </div>
    </div>
<?php }
} ?>
