<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class QuickLoginCommand extends Command
{
    protected $signature = 'dev:login {role=admin}';
    protected $description = 'Show quick login credentials for development';

    public function handle()
    {
        $role = $this->argument('role');
        
        $users = [
            'admin' => 'admin@grosir.com',
            'owner' => 'owner@grosir.com',
            'customer' => 'budi@example.com',
            'budi' => 'budi@example.com',
            'siti' => 'siti@example.com',
        ];

        if (!isset($users[$role])) {
            $this->error("❌ Role '{$role}' not found. Available: " . implode(', ', array_keys($users)));
            return 1;
        }

        $email = $users[$role];
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("❌ User not found. Run: php artisan migrate:fresh --seed");
            return 1;
        }

        $this->info('');
        $this->line('╔════════════════════════════════════════╗');
        $this->line('║        🚀 QUICK LOGIN CREDENTIALS      ║');
        $this->line('╚════════════════════════════════════════╝');
        $this->line('');
        $this->line("Role:     <fg=green>{$user->role}</>");
        $this->line("Name:     <fg=blue>{$user->name}</>");
        $this->line("Email:    <fg=cyan>{$email}</>");
        $this->line("Password: <fg=yellow>password123</>");
        $this->line('');
        $this->line("Login at: <fg=magenta>http://127.0.0.1:8000/login</>");
        $this->line('');

        return 0;
    }
}
