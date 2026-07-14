<?php

use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

if (! User::where('email', 'admin@admin.com')->exists()) {
    User::create([
        'name' => 'Admin',
        'email' => 'admin@admin.com',
        'password' => bcrypt('admin123'),
    ]);
    echo "Admin created: admin@admin.com / admin123\n";
} else {
    echo "Admin already exists\n";
}
