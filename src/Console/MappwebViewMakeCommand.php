<?php
/**
 * User: Ing. Oswaldo Montes Severiche
 * Date: 25/01/20
 * Time: 4:44 p. m.
 */

namespace Mappweb\Mappweb\Console;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use function Matrix\add;

class MappwebViewMakeCommand extends GeneratorCommand
{
    use BuildStubTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mappweb:make-view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the index, show, add modal or destroy modal view. Default create the index view.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View';

    public function handle()
    {
        if (parent::handle() === false){
            return false;
        }
    }

    /**
     * @param string $name
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        if ($this->option('show')){
            return $stub;
        }

        if ($this->option('add') || $this->option('destroy')){
            $this->replaceModelName($stub);
            $this->replaceKebabModelName($stub);
            $this->replaceKebabPluralModelName($stub);
            $this->replaceSnakeModelName($stub);

            return $stub;
        }

        $this->replaceKebabPluralModelName($stub);
        $this->replaceSnakeModelName($stub);

        return $stub;
    }

    /**
     * @inheritDoc
     */
    protected function getStub()
    {
        if ($this->option('show')){
            return __DIR__.'/stubs/crud/views/show.stub';
        }

        if ($this->option('add')){
            return __DIR__.'/stubs/crud/views/modal-add-edit.stub';
        }

        if ($this->option('destroy')){
            return __DIR__.'/stubs/crud/views/modal-destroy.stub';
        }

        return __DIR__.'/stubs/crud/views/index.stub';
    }

    protected function qualifyClass($name)
    {
        return Str::camel($name);
    }

    protected function getPath($name)
    {
        $kebabName = Str::kebab($name);

        $path = resource_path('views/'. $kebabName .'/');

        if ($this->option('show')){
            $this->type = "View $kebabName.show";
            return $path .'show.blade.php';
        }

        if ($this->option('add')){
            $this->type = "View $kebabName.modal-add-edit";
            return $path .'modal-add-edit.blade.php';
        }

        if ($this->option('destroy')){
            $this->type = "View $kebabName.modal-destroy";
            return $path .'modal-destroy.blade.php';
        }

        $this->type = "View $kebabName.index";
        return $path .'index.blade.php';
    }

    protected function getOptions()
    {
        return [
            ['show', 's', InputOption::VALUE_OPTIONAL, 'Create a new show view.'],
            ['add', 'a', InputOption::VALUE_OPTIONAL, 'Create a new add modal view.'],
            ['destroy', 'd', InputOption::VALUE_OPTIONAL, 'Create a new destroy modal view.'],
        ];
    }
}