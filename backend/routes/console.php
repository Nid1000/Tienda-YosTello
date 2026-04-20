<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment('La tienda esta lista para crecer.');
})->purpose('Muestra un mensaje de inspiracion.');
