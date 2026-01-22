<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrateSeedAll extends Command
{
    protected $signature = 'migrate:seed-all {--force}';
    protected $description = 'Migrate & seed all databases (shared migrations & seeders)';

    public function handle()
    {
        if (app()->environment('production') && ! $this->option('force')) {
            $this->error('❌ Tidak boleh migrate:fresh di production tanpa --force');
            return Command::FAILURE;
        }

        $databases = ['mysql', 'mysql2'];

        foreach ($databases as $db) {
            $this->info("🔄 Migrating database: {$db}");

            Artisan::call('migrate:fresh', [
                '--database' => $db,
                '--force' => true,
            ]);

            $this->line(Artisan::output());

            $this->info("🌱 Seeding database: {$db}");

            Artisan::call('db:seed', [
                '--database' => $db,
                '--force' => true,
            ]);

            $this->line(Artisan::output());
        }

        $this->info('✅ Semua database berhasil migrate & seed');
        return Command::SUCCESS;
    }
}
