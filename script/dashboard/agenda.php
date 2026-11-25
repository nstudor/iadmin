<?php
// agenda of the logged-in user for the selected day (?data=YYYY-MM-DD, default today)
// slots are half hours: ora 16 = 08:00, 17 = 08:30 ... ; durata = number of slots
$agDay = strtotime($_GET['data'] ?? 'today') ?: strtotime('today');
$agRows = db_select('*', 'login__agenda', 'id_user=' . (int)$_SESSION['userid'] . " AND data='" . date('Y-m-d', $agDay) . "'", 'ora') ?? [];
$agSlots = [];
foreach ($agRows as $r)
    for ($i = 0; $i < max(1, (int)$r['durata']); $i++) $agSlots[(int)$r['ora'] + $i] = $r;

foreach ($panelRows as $rk => $rv)
    foreach ($rv['panels'] as $k => $v)
        if ($v['fisier'] == 'agenda') {
            $panelRows[$rk]['panels'][$k]['data'] = [
                'dd' => $agDay,
                'slots' => $agSlots,
                'start' => (int)($agenda['hour_start'] ?? 16),
                'stop' => (int)($agenda['hour_stop'] ?? 44),
            ];
        }
