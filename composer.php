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

function upd($path, $file, $web){
    if (!is_dir($path)) {
        echo "Directory '$path' not exists and has been created\n";
        mkdir($path, 0755, true);
    }

    if (file_put_contents($path . DIRECTORY_SEPARATOR . $file, file_get_contents($web))) echo "File $file - downloaded\n\n";
}

function update_assets() {
    $pathComponents = 'res' . DIRECTORY_SEPARATOR . 'site' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR;

    echo "Update Bootstrap\n";
    /*
    $components_path = 'res' . DIRECTORY_SEPARATOR . 'site' . DIRECTORY_SEPARATOR . 'components';

    echo "Update Bootstrap\n";
    upd($components_path, 'bootstrap.min.js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js');
*/
    $path = $pathComponents . 'bootstrap';
    
    upd($path, 'bootstrap.min.css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');
    upd($path, 'bootstrap.min.css.map', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css.map');
    upd($path, 'bootstrap.min.js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js');
    upd($path, 'bootstrap.min.js.map', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js.map');
    upd($path, 'font-awesome.min.css', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

    echo "Update FullCalendar\n";

    $path = $pathComponents . 'fullcalendar';
    upd($path, 'fullcalendar.min.css', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css');
    upd($path, 'fullcalendar.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js');


    echo "Update FullCalendar\n";

    $path = $pathComponents . 'jquery';
    upd($path, 'jquery.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js');


    echo "Update Popper\n";

    $path = $pathComponents . 'popper';
    upd($path, 'popper.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/esm/popper.min.js');


    echo "Update Select2\n";

    $path = $pathComponents . 'select2';
    upd($path, 'select2.min.css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css');
    upd($path, 'select2.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js');
    
    echo "************************ Shortcut is not suported ************************ \n";


    echo "Update bootstrap-datetimepicker\n";
    $path = $pathComponents . 'bootstrap-datetimepicker';
    upd($path, 'bootstrap-datetimepicker.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css');
    upd($path, 'bootstrap-datetimepicker.min.css', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js');


    echo "Update jQuery-Impromptu\n";
    $path = $pathComponents . 'jQuery-Impromptu';
    upd($path, 'jquery-impromptu.min.css', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-impromptu/6.2.3/themes/base.min.css');
    upd($path, 'jquery-impromptu.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-impromptu/6.2.3/jquery-impromptu.min.js');
    
    //file_put_contents($dir . DIRECTORY_SEPARATOR . 'bootstrap.min.js', file_get_contents('https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js'));


    /*
    echo "Update jQuery\n";
    file_put_contents(__DIR__ . 'jquery.js', file_get_contents('https://code.jquery.com/jquery-3.2.1.js'));
    file_put_contents(__DIR__ . 'jquery.min.js', file_get_contents('https://code.jquery.com/jquery-3.2.1.min.js'));
    file_put_contents(__DIR__ . 'jquery.min.map', file_get_contents('https://code.jquery.com/jquery-3.2.1.min.map'));
    
    echo "Update mustache.js\n";
    file_put_contents(__DIR__ . 'mustache.js', file_get_contents('https://raw.githubusercontent.com/janl/mustache.js/v2.3.0/mustache.js'));
    file_put_contents(__DIR__ . 'mustache.min.js', file_get_contents('https://raw.githubusercontent.com/janl/mustache.js/v2.3.0/mustache.min.js'));
    */
}