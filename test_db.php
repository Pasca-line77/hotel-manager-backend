<?php
require 'vendor/autoload.php';
 = require_once 'bootstrap/app.php';
 = ->make(Illuminate\Contracts\Console\Kernel::class);
->bootstrap();

try {
    \ = \DB::connection()->getPdo();
    echo '✅ Connexion MySQL réussie !' . PHP_EOL;
    echo 'Base de données: ' . \DB::connection()->getDatabaseName() . PHP_EOL;
} catch (\Exception \) {
    echo '❌ Erreur: ' . \->getMessage() . PHP_EOL;
}
