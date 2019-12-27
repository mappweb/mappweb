<?php
/**
 * User: Ing. Oswaldo Montes Severiche
 * Date: 27/12/19
 * Time: 12:27 p. m.
 */

namespace Mappweb\Mappweb\Console;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MappwebModelMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mappweb:make-model';

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'mappweb:make-model {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model with mappweb stub and observer, migration, request and controller';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Execute the console command.
     *
     * @return bool
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        if (parent::handle() === false){
            return false;
        }

        $this->createObserver();
        $this->createMigration();
        $this->createController();
        $this->createRequest();
    }

    /**
     * Create a observer for the model.
     *
     * @return void
     */
    protected function createObserver()
    {
        $modelName = $this->getModelName();

        $this->call('make:observer', [
            'name' => "{$modelName}Observer",
            '--model' => $modelName,
        ]);
    }

    /**
     * Create a migration for the model.
     *
     * @return void
     */
    protected function createMigration()
    {
        $table = Str::snake(Str::pluralStudly(class_basename($this->argument('name'))));

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    /**
     * Create a controller for the model.
     *
     * @return void
     */
    protected function createController()
    {
        $controller = Str::studly(class_basename($this->argument('name')));
        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('make:controller', [
            'name' => "{$controller}Controller",
            '--model' => $modelName,
        ]);
    }

    /**
     * Create a request for the model.
     *
     * @return void
     */
    protected function createRequest()
    {
        $modelName = $this->getModelName();

        $this->call('make:request', [
            'name' => "{$modelName}Request",
        ]);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/crud/model.stub';
    }

    /**
     * Get the model name.
     *
     * @return string
     */
    protected function getModelName()
    {
        return Str::studly(class_basename($this->argument('name')));
    }
}