<?php

namespace App\Console\Commands\Custom;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateRoute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:route {name}';

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
        $routeFilePath = base_path('routes/web.php');
        $newRoute = <<<EOT
        Route::group(['namespace' => '{$name}'], function () {
            Route::resource('/{$lowerName}', '\App\Http\Controllers\Admin\\$name\\$controllerName');
        });\n\n
        EOT;

        $routeContents = File::get($routeFilePath);

        // Find the end of the existing group and insert the new route before it
        $groupEndPosition = strripos($routeContents, '});');
        $newRouteContents = substr_replace($routeContents, $newRoute, $groupEndPosition, 0);

        // Write the new contents back to the file
        File::put($routeFilePath, $newRouteContents);

        $this->info('New route added successfully!');
    }
}
