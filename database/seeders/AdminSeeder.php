<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Cek dulu, hindari duplicate jika seeder dijalankan ulang
        User::firstOrCreate(
            ['email' => 'admin@smknu2medan.sch.id'],
            [
                'nama_lengkap' => 'Admin Utama',
                'password' => Hash::make('Password'),
                'role' => 'admin',
            ]
        );

        $this->command->info('✓ Akun admin berhasil dibuat.');
        $this->command->line('  Email    : admin@smknu2medan.sch.id');
        $this->command->line('  Password : Password');
        $this->command->warn('  Segera ganti password setelah login pertama!');
    }
}