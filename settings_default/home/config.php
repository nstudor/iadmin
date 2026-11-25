<?php
// Home page (no ?p= given): the user's dashboard panels from login__dashboard.
// The panels themselves are configured in the "dashboard" module.
$hasNoTable = 1;
$scriptPage = "dashboard";

// agenda panel: first / last half-hour slot shown (slot = hour * 2, 16 = 08:00, 44 = 22:00)
$agenda = [
    'hour_start' => 16,
    'hour_stop' => 44,
];

include('script/dashboard.scr.php');
