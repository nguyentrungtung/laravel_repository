<?php

namespace App\Console\Commands\Custom;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateRequestvalidate extends Command
{
     /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:Request-validate {name}';

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
        $routeFilePath = base_path('app/Http/Requests/Admin/'. $name . '/' . 'CreateRequest.php');
        $content = <<<EOT
        <?php

        namespace App\Http\Requests\Admin\\$name;

        use Illuminate\Foundation\Http\FormRequest;

        class CreateRequest extends FormRequest
        {
            /**
             * Determine if the user is authorized to make this request.
             *
             * @return bool
             */
            public function authorize()
            {
                return true;
            }

            /**
             * Get the validation rules that apply to the request.
             *
             * @return array<string, mixed>
             */
            public function rules()
            {
                return [
                    'title' => 'required',
                    'subtitle' => 'required',
                    'thumbnail' => 'required',
                    'view' => 'required',
                    'description' => 'required',
                    'status' => 'required',
                    'seo_title' => 'required',
                    'seo_description' => 'required',
                    'seo_keyword' => 'required',
                    'seo_canonical' => 'required',
                ];
            }
        }

        EOT;

        // Write the new contents back to the file
        File::makeDirectory('app/Http/Requests/Admin/' . $name . '/');
        File::put($routeFilePath, $content);

        $this->info('create request successfully!');
    }
}
