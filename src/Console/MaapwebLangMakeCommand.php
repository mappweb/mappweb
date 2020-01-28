<?php
/**
 * User: Ing. Oswaldo Montes Severiche
 * Date: 8/01/20
 * Time: 11:48 a. m.
 */

namespace Mappweb\Mappweb\Console;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MaapwebLangMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mappweb:make-lang';

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'mappweb:make-lang {name} {--locale=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new lang file based on the current language settings by default';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Lang';

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
    }

    /**
     * @inheritDoc
     */
    protected function getStub()
    {
        $locale = $this->option('locale')? : config('app.locale');

        switch ($locale){
            case 'es':
                return __DIR__.'/stubs/lang/es/lang.stub';

            case 'en':
                return __DIR__.'/stubs/lang/en/lang.stub';

            default :
                return __DIR__.'/stubs/lang/plain-lang.stub';
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

        $this->replaceModelName($stub);

        return $stub;
    }

    protected function qualifyClass($name)
    {
        return $this->getSnakeNameInput();
    }

    protected function replaceModelName(&$stub)
    {
        $stub = str_replace('DummyModel', Str::camel($this->getNameInput()), $stub);
    }

    /**
     * @return string
     */
    protected function getSnakeNameInput()
    {
        return Str::snake($this->getNameInput());
    }

    protected function getPath($name)
    {
        $locale = $this->option('locale')? : config('app.locale');
        $this->type = "Lang $locale";

        return resource_path('/lang/'. $locale  .'/'). $this->getSnakeNameInput() .'.php';
    }
}