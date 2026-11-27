<?php
// Shortcuts panel. Works with both login__shortcuts layouts:
//  - stacked icons: fa1, fa2, fa1type, fa2type, fa1color, fa2color, fa1shadow, fa2shadow, extraclass, colors as names (colors.css)
//  - single icon:   fontawesome, textcolor / backcolor / bordercolor as CSS colors
$h = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES);
?>
<div class="row g-3">
    <?php foreach (($panelData ?? []) as $r) {
        $newTab = (($r['newtab'] ?? 'N') == 'Y') ? ' target="_blank" rel="noopener"' : '';
        $stacked = !empty($r['fa1']) || !empty($r['fa2']);
    ?>
        <div class="col-6 col-sm-4 col-md-3 col-xl-2">
            <div class="ratio ratio-1x1">
                <?php if ($stacked) { ?>
                    <a href="<?= $h($r['link'] ?? '') ?>"<?= $newTab ?> class="ar-shortcut text-<?= $h($r['textcolor'] ?? 'body') ?> bg-<?= $h($r['backcolor'] ?? 'body') ?> border-<?= $h($r['bordercolor'] ?? '') ?> <?= $h($r['extraclass'] ?? '') ?>">
                        <span class="fa-stack fa-2x">
                            <?php if (!empty($r['fa1'])) { ?><i class="fa<?= $h($r['fa1type'] ?? 's') ?> fa-<?= $h($r['fa1']) ?> text-<?= $h($r['fa1color'] ?? '') ?> shadow-<?= $h($r['fa1shadow'] ?? '') ?> fa-stack-1x"></i><?php } ?>
                            <?php if (!empty($r['fa2'])) { ?><i class="fa<?= $h($r['fa2type'] ?? 's') ?> fa-<?= $h($r['fa2']) ?> text-<?= $h($r['fa2color'] ?? '') ?> shadow-<?= $h($r['fa2shadow'] ?? ($r['fa1shadow'] ?? '')) ?> fa-stack-1x"></i><?php } ?>
                        </span>
                        <span class="small"><?= $h($r['denumire'] ?? '') ?></span>
                    </a>
                <?php } else { ?>
                    <a href="<?= $h($r['link'] ?? '') ?>"<?= $newTab ?> class="ar-shortcut" style="background-color:<?= $h($r['backcolor'] ?? '') ?>; border-color:<?= $h($r['bordercolor'] ?? '') ?>; color:<?= $h($r['textcolor'] ?? '') ?>;">
                        <i class="fa fa-<?= $h(($r['fontawesome'] ?? '') ?: 'link') ?> fa-2x" aria-hidden="true"></i>
                        <span class="small"><?= $h($r['denumire'] ?? '') ?></span>
                    </a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <?php if (count($panelData ?? []) == 0) { ?>
        <div class="col-12 text-body-secondary small"><?= t('no_shortcuts') ?></div>
    <?php } ?>
</div>
