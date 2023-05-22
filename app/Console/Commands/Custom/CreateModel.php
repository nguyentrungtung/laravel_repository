<?php

namespace App\Console\Commands\Custom;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:model {name}';

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
        $lowerName = strtolower($name);
        $controllerName = $name . 'Controller';
        $routeFilePath = base_path('app/Models/' . $name) . '.php';
        $content = <<<EOT
        <?php

        namespace App\Models;

        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\Model;

        class {$name} extends Model
        {
            use HasFactory;
        }

        EOT;

        // Write the new contents back to the file
        File::put($routeFilePath, $content);

        $this->info('create model successfully!');
    }
}
