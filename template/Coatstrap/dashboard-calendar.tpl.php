<?php
$dd = $panelData['dd'] ?? strtotime('today');
$an = (int)($panelData['an'] ?? date('Y', $dd));
$lu = (int)($panelData['lu'] ?? date('m', $dd));
$zi = (int)($panelData['zi'] ?? date('d', $dd));
$first = strtotime(sprintf('%04d-%02d-01', $an, $lu));
$lead = (int)date('N', $first) - 1;          // empty cells before day 1 (week starts Monday)
$days = (int)date('t', $first);
$today = strtotime('today');
?>
<div class="d-flex align-items-center justify-content-between mb-2">
    <a class="btn btn-sm btn-light" href="./?data=<?= date('Y-m-d', strtotime(date('Y-m-d', $dd) . ' -1 month')) ?>" aria-label="<?= t('month_previous') ?>"><i class="fa-solid fa-chevron-left"></i></a>
    <div class="d-flex gap-1">
        <div class="dropdown">
            <button class="btn btn-sm btn-light dropdown-toggle fw-semibold" data-bs-toggle="dropdown" aria-expanded="false"><?= mb_strtoupper(format_strftime('%B', $dd)) ?></button>
            <ul class="dropdown-menu">
                <?php for ($j = 1; $j <= 12; $j++) { ?>
                    <li><a class="dropdown-item<?= $j == $lu ? ' active' : '' ?>" href="./?data=<?= "$an-$j-1" ?>"><?= mb_strtoupper(format_strftime('%B', strtotime("2000-$j-01"))) ?></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="dropdown">
            <button class="btn btn-sm btn-light dropdown-toggle fw-semibold" data-bs-toggle="dropdown" aria-expanded="false"><?= $an ?></button>
            <ul class="dropdown-menu">
                <?php for ($j = $an - 3; $j <= $an + 3; $j++) { ?>
                    <li><a class="dropdown-item<?= $j == $an ? ' active' : '' ?>" href="./?data=<?= "$j-$lu-1" ?>"><?= $j ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <a class="btn btn-sm btn-light" href="./?data=<?= date('Y-m-d', strtotime(date('Y-m-d', $dd) . ' +1 month')) ?>" aria-label="<?= t('month_next') ?>"><i class="fa-solid fa-chevron-right"></i></a>
</div>
<table class="table table-sm table-borderless text-center mb-0">
    <thead>
        <tr class="text-body-secondary small">
            <?php for ($d = 1; $d <= 7; $d++) echo '<th>' . t("day_short_$d") . '</th>'; ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php
            $n = 0;
            for ($i = 0; $i < $lead; $i++, $n++) echo '<td></td>';
            for ($i = 1; $i <= $days; $i++, $n++) {
                if ($n > 0 && $n % 7 == 0) echo '</tr><tr>';
                $day = strtotime(sprintf('%04d-%02d-%02d', $an, $lu, $i));
                $cls = $day == $today ? 'bg-primary-subtle rounded' : '';
            ?><td class="<?= $cls ?>"><a class="text-decoration-none<?= $day == $dd ? ' fw-bold text-primary' : ' text-body' ?>" href="./?data=<?= date('Y-m-d', $day) ?>"><?= $i ?></a></td><?php
            }
            while ($n % 7 != 0) { echo '<td></td>'; $n++; }
            ?>
        </tr>
    </tbody>
</table>
