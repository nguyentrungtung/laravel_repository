<?php

namespace App\Console\Commands\Custom;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:crud {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $lowername = strtolower($name);
        $this->call('create:request-validate', ['name' => $name]);
        $this->call('update:request-validate', ['name' => $name]);
        $this->call('create:route', ['name' => $name]);
        $this->call('create:model', ['name' => $name]);
        $this->call('create:controller', ['name' => $name]);
        $this->call('create:migration', ['name' => $name]);
        File::makeDirectory('resources/views/admin/' . $lowername);
        $this->call('create:view-index', ['name' => $name]);
        $this->call('create:view-edit', ['name' => $name]);
        $this->call('make:repository', ['name' => $name]);
        $this->info('New route added successfully!');
    }
}
