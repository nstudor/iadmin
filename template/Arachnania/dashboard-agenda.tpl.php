<?php
$dd = $panelData['dd'] ?? strtotime('today');
$ag = $panelData['slots'] ?? [];
?>
<div class="fw-semibold mb-2"><i class="fa-regular fa-calendar me-2"></i><?= format_strftime('%d %B %Y', $dd) ?></div>
<div class="table-responsive">
    <table class="table table-sm table-hover align-middle mb-0">
        <tbody>
            <?php for ($i = $panelData['start'] ?? 16; $i <= ($panelData['stop'] ?? 44); $i++) {
                $slot = $ag[$i] ?? null;
                $cont = $slot && (($ag[$i - 1]['id'] ?? null) == $slot['id']);
            ?>
                <tr<?= $slot ? ' class="table-primary"' : '' ?>>
                    <td class="text-body-secondary" style="width:4.5rem"><?= sprintf('%02d:%02d', intdiv($i, 2), 30 * ($i % 2)) ?></td>
                    <td><?= $slot ? ($cont ? '<span class="text-body-secondary">&#8942;</span>' : htmlspecialchars($slot['subiect'])) : '' ?></td>
                    <td class="text-end" style="width:3rem">
                        <?php if (!$slot) { ?>
                            <a class="text-body-secondary" href="./agenda-add.htm?data=<?= date('Y-m-d', $dd) ?>&ora=<?= $i ?>" title="<?= t('add') ?>"><i class="fa-solid fa-plus"></i></a>
                        <?php } elseif (!$cont) { ?>
                            <a href="./agenda-edit-id-<?= (int)$slot['id'] ?>.htm" title="<?= t('open') ?>"><i class="fa-solid fa-eye"></i></a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
