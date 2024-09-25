<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('12345678'),
        ]);

        User::factory()->create([
            'name' => 'Duwi Anjar Ari Wibowo',
            'email' => 'duwianjarariwibowo@gmail.com',
            'role' => 'client',
            'password' => Hash::make('12345678'),
        ]);

        // Delete all files in the public/assets/pp folder
        $files = File::files(public_path('assets/img/pp'));
        foreach ($files as $file) {
            File::delete($file);
        }
    }
}