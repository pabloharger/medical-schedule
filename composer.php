<?php

$event = isset($argv[1]) ? $argv[1] : null;

if ($event == 'post-update-cmd') {
    // composer update
    update_assets();
}

if ($event == 'post-install-cmd') {
    // composer install
    update_assets();
}

if ($event == 'update-assets') {
    update_assets();
}

function update_assets() {
}