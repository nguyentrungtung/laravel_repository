<?php

namespace App\Console\Commands\Custom;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:migration {name}';

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
        $current_time = date('Y_m_d_His');
        $routeFilePath = 'database/migrations/' . $current_time . '_create_' . $lowerName . 's_table.php';
        $content = <<<EOT
        <?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        return new class extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create('{$lowerName}s', function (Blueprint \$table) {
                    \$table->id();
                    \$table->string('thumbnail')->nullable();
                    \$table->string('title')->nullable();
                    \$table->string('summary')->nullable();
                    \$table->string('author')->nullable();
                    \$table->longText('description')->nullable();
                    \$table->tinyInteger('status')->nullable();
                    \$table->string('label')->nullable();
                    \$table->string('seo_title')->nullable();
                    \$table->string('seo_description')->nullable();
                    \$table->string('seo_keyword')->nullable();
                    \$table->string('seo_canonical')->nullable();
                    \$table->timestamps();
                });
            }

            /**
             * Reverse the migrations.
             *
             * @return void
             */
            public function down()
            {
                Schema::dropIfExists('{$lowerName}s');
            }
        };


        EOT;

        // Write the new contents back to the file
        File::put($routeFilePath, $content);

        $this->info('create model successfully!');
    }
}
