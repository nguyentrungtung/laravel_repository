<?php

namespace App\Console\Commands\Custom;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:controller {name}';

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
        $repositoryInterfaceName = $name . 'RepositoryInterface';
        $routeFilePath = base_path('app/Http/Controllers/Admin/' . $name . '/' . $name . 'Controller.php');
        $content = <<<EOT
        <?php

        namespace App\Http\Controllers\Admin\\$name;

        use Illuminate\Http\Request;
        use App\Http\Controllers\Controller;
        use App\Models\\$name;
        use App\Repositories\\$repositoryInterfaceName;
        use App\Services\Production\FileServices;
        use Illuminate\Support\Facades\Redirect;
        use App\Http\Requests\\$name\CreateRequest;
        use App\Http\Requests\\$name\UpdateRequest;
        use Exception;


        class {$name}Controller extends Controller
        {
            /** @var App\Repositories\{$lowerName}RepositoryInterface {$lowerName}Repository */
            /** @var App\Services\Production\FileServices FileServices */
            protected \${$lowerName}Repository;
            protected \$fileServices;
            protected \$provinceRepository;
            protected \$districtRepository;

            /**
             * class UserController.
             *
             * @param \{$lowerName}RepositoryInterface \${$lowerName}Repository
             * @param FileServices \$fileServices
             */
            public function __construct(
                {$name}RepositoryInterface \${$lowerName}Repository,
                FileServices \$fileServices,
            ) {
                \$this->{$lowerName}Repository = \${$lowerName}Repository;
                \$this->fileServices   = \$fileServices;
            }

            /**
             * Display a listing of the resource.
             *
             * @return \Illuminate\Http\Response
             */
            public function index(Request \$request)
            {
                if(\Auth::user()->hasPermissionTo('list {$lowerName}'))
                    \$offset    = \$request->get('offset', '');
                    \$limit     = \$request->get('limit', 20);
                    \$order     = \$request->get('order', 'id');
                    \$direction = \$request->get('direction','DESC');

                    \$queryWord = \$request->get('query');


                    \$filter = [];
                    if (!empty(\$queryWord)) {
                        \$filter['query'] = \$queryWord;
                    }
                    \${$lowerName}s     = \$this->{$lowerName}Repository->allByFilterPagination(\$filter, \$limit, \$order, \$direction);
                    \$breadcrumbs = [
                        ['title' => 'Home', 'url' => route('home.index')],
                        ['title' => '{$lowerName}', 'url' => route('{$lowerName}.index')]
                    ];
                    return view('admin.{$lowerName}s.index', compact('{$lowerName}s' , 'breadcrumbs'));
                } else {
                    \App::abort(403);
                }
            }

            /**
             * Show the form for creating a new resource.
             *
             * @return \Illuminate\Http\Response
             */
            public function create()
            {
                if(\Auth::user()->hasPermissionTo('add {$lowerName}'))
                    \$breadcrumbs = [
                        ['title' => 'Home', 'url' => route('home.index')],
                        ['title' => '{$lowerName}', 'url' => route('{$lowerName}.index')],
                        ['title' => '{$lowerName}', 'url' => route('{$lowerName}.create')],
                    ];
                    \$statusData = [
                        [
                            'name' => 'Hiện',
                            'value' => 1,
                        ],
                        [
                            'name' => 'Ẩn',
                            'value' => 0,
                        ]
                    ];
                    return view('admin.{$lowerName}.edit', compact('statusData', 'breadcrumbs'));
                } else {
                    \App::abort(403);
                }
            }

            /**
             * Store a newly created resource in storage.
             *
             * @param  \Illuminate\Http\Request  \$request
             * @return \Illuminate\Http\Response
             */
            public function store(CreateRequest \$request)
            {
                if(\Auth::user()->hasPermissionTo('add {$lowerName}'))
                    \$input = \$request->except(['_token']);

                    try {
                        \$model = \$this->\${$lowerName}Repository->create(\$input);
                        return redirect(route('{$lowerName}.index'))->with('success', 'Tạo bài viết thành công!');
                    } catch(Exception \$e) {
                        throw New Exception(\$e);
                    }
                } else {
                    \App::abort(403);
                }
            }

            /**
             * Display the specified resource.
             *
             * @param  int  \$id
             * @return \Illuminate\Http\Response
             */
            public function show(\$id)
            {
                // \$user = \$this->{$lowerName}Repository->findOrFail(\$id);
                // return view('admin.{$lowerName}.show', compact('{$lowerName}'));
            }

            /**
             * Show the form for editing the specified resource.
             *
             * @param  int  \$id
             * @return \Illuminate\Http\Response
             */
             public function edit(\$id)
             {
                if(\Auth::user()->hasPermissionTo('edit {$lowerName}'))
                    \${$lowerName} = \$this->{$lowerName}Repository->findOrFail(\$id);

                    \$breadcrumbs = [
                        ['title' => 'Home', 'url' => route('home.index')],
                        ['title' => '{$lowerName}', 'url' => route('{$lowerName}.index')],
                        ['title' => '{$lowerName}', 'url' => route('{$lowerName}.edit' , ['{$lowerName}' => \$id])],
                    ];
                    \$statusData = [
                        [
                            'name' => 'Ẩn',
                            'value' => 0,
                        ],
                        [
                            'name' => 'Hiện',
                            'value' => 1,
                        ],
                    ];
                    return view('admin.{$lowerName}s.edit', compact('statusData', '{$lowerName}',  'breadcrumbs'));
                } else {
                    \App::abort(403);
                }
             }

            /**
             * Update the specified resource in storage.
             *
             * @param  \Illuminate\Http\Request  \$request
             * @param  int  \$id
             * @return \Illuminate\Http\Response
             */
            public function update(UpdateRequest \$request, \$id)
            {
                if(\Auth::user()->hasPermissionTo('edit {$lowerName}'))
                    \$model = \$this->{$lowerName}Repository->findOrFail(\$id);
                    if(empty(\$model) {
                        return Redirect::back()->with('error', 'Not Found!');
                    } else {
                        try {
                        \$this->{$lowerName}Repository->update(\$model, \$input)
                            return redirect()->route('{$lowerName}.index')->with('success', 'Update successfully');
                        } catch(\Exception \$e) {
                            throw new Exception(\$e);
                        }
                    }
                } else {
                    \App::abort(403);
                }
            }

            /**
             * Remove the specified resource from storage.
             *
             * @param int \$id
             * @return \Illuminate\Http\Response
             * @throws Exception
             */
            public function destroy(\$id)
            {
                if(\Auth::user()->hasPermissionTo('delete {$lowerName}'))
                    \${$lowerName} = \$this->{$lowerName}Repository->findOrFail(\$id);
                    if (empty(\${$lowerName})) {
                        session()->flash('error', 'Not found user.');

                        return ['error' => true];
                    }
                    try {
                        \$this->{$lowerName}Repository->delete(\${$lowerName});

                        session()->flash('success', 'Destroy successfully.');

                        return ['error' => false];
                    } catch (Exception \$e) {
                        throw new Exception(\$e);
                    }
                } else {
                    \App::abort(403);
                }
            }
        }


        EOT;

        // Write the new contents back to the file
        File::makeDirectory('app/Http/Controllers/Admin/' . $name);
        File::put($routeFilePath, $content);

        $this->info('create model successfully!');
    }
}
