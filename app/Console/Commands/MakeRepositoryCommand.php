<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;


class MakeRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'command:name';
    protected $signature = 'make:repository {name} {model?} {use_abstract?}';
    /**
     * The console command description.
     *
     * @var string
     */
//    protected $description = 'Command description';
    protected $description = 'Make an Repositories Class using name and model repository';


    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected Filesystem $files;
    protected string $nameClass;
    protected string $concretePath;
    protected string $contractPath;
    protected string $contractName;
    protected string $modelName;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->nameClass = $this->getClassName($this->argument('name')) . 'Repository';
        $this->modelName = $this->argument('model') ? $this->getClassName($this->argument('model')) : $this->getClassName($this->argument('name'));
        $repoPath = $this->getRepositoryPath('Eloquent/' . $this->nameClass);
        $contractPath = $this->getRepositoryPath($this->nameClass . 'Interface');

//        $contractPath = $this->getRepositoryPath('Eloquent/' . $this->nameClass);
//        $repoPath = $this->getRepositoryPath($this->nameClass);
        // Make directory
        $this->makeDirectory($contractPath);
        $this->makeDirectory($repoPath);

        // Get file content
        $newContractFile = $this->buildContractClass();
        $newConcreteFile = $this->buildConcreteClass();

        // Create files
        $this->files->put($contractPath, $newContractFile);
        $this->files->put($repoPath, $newConcreteFile);

        // Map Interface and Concrete
        $this->createContract();

        $this->info('Repository ' . $this->argument('name') . ' created successfully.');
//        return Command::SUCCESS;
    }



    protected function createContract()
    {
        $path = $this->laravel['path'] . '/Providers/RepositoryServiceProvider.php';
        $content = file_get_contents($path);
        $search = "/\/\/Eloquent/m";

        $dollar = htmlspecialchars('$');
        $slash = htmlspecialchars('\\');
        $interface = 'Interface';
        $replace = <<<EDT
            //Eloquent
                    {$dollar}this->app->singleton(
                        $slash$this->contractPath{$interface}::class,
                        $slash$this->concretePath::class
                    );
            EDT;
        $content = preg_replace($search, $replace, $content);
        file_put_contents($path, $content);
        return true;
    }

    protected function getRepositoryPath($name): string
    {
        $name = Str::replaceFirst($this->laravel->getNamespace(), '', $name);

        return $this->laravel['path'] . '/Repositories/' . str_replace('\\', '/', $name) . '.php';
    }

    protected function makeDirectory(string $path): void
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    protected function buildContractClass(): string
    {
        $stubVariables = $this->getStubInterfaceVariables();
        return view('stubs.repository_interface', $stubVariables)->render();
    }

    protected function buildConcreteClass(): string
    {
        $stubVariables = $this->getStubConcreteVariables();
        return view('stubs.repository', $stubVariables)->render();
    }

    public function getStubInterfaceVariables()
    {
        $filePath = Str::replaceFirst($this->laravel->getNamespace(), '', $this->nameClass);
        $filePathElement = explode('/', $filePath);
        $class = array_pop($filePathElement);
        $namespacePath = implode('\\', $filePathElement);
        $namespace = $this->laravel->getNamespace() . 'Repositories' . ($namespacePath ? '\\' . $namespacePath : '');
        $this->contractPath = $namespace . '\\' . $class;
        $this->contractName = $class;
        return [
            'name_space' => $namespace,
            'class_name' => $this->nameClass . 'Interface'
        ];
    }

    public function getStubConcreteVariables(): array
    {
        $filePath = Str::replaceFirst($this->laravel->getNamespace(), '', $this->nameClass);
        $filePathElement = explode('/', $filePath);
        $class = array_pop($filePathElement);
        $namespacePath = implode('\\', $filePathElement);
        $namespace = $this->laravel->getNamespace() . 'Repositories\Eloquent' . ($namespacePath ? '\\' . $namespacePath : '');
        $modelPath = $this->laravel->getNamespace() . 'Models\\' . $this->modelName;
        $useAbstract = $this->argument('use_abstract') ?? true;
        $this->concretePath = $namespace . '\\' . $class;

        return [
            'name_space' => $namespace,
            'contract_path' => $this->contractPath . 'Interface',
            'contract_name' => $this->contractName . 'Interface',
            'model_path' => $modelPath,
            'class_name' => $class,
            'abstract_repo_name' => 'RelationModelRepository',
            'model_name' => $this->modelName,
            'use_abstract' => $useAbstract
        ];
    }

    public function getClassName($name): string
    {
        $nameClass = ucwords(Pluralizer::singular($name));
        if ($index = strpos($nameClass, 'Repository')) {
            $nameClass = substr($nameClass, 0, $index);
        }
        return $nameClass;
    }

}
