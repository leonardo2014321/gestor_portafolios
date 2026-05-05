<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $count = \Illuminate\Support\Facades\DB::table('busquedas')->count();
    echo "Count: " . $count . "\n";
    $items = \Illuminate\Support\Facades\DB::table('busquedas')->limit(5)->get();
    echo json_encode($items);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
