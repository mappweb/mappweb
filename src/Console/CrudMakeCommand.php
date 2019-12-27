<?php
/**
 * User: Ing. Oswaldo Montes Severiche
 * Date: 27/12/19
 * Time: 12:01 p. m.
 */

namespace Mappweb\Mappweb\Console;


use Illuminate\Console\Command;

class CrudMakeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:crud';

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'make:crud {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new crud for custom model, with observer, migration, controller, lang and view';

    /**
     * Execute the console command.
     *
     * @return null
     */
    public function handle()
    {
        $this->createMappwebModel();
        //$this->createLang();
        //$this->createView();
    }

    protected function createMappwebModel()
    {
        $this->call('mappweb:make-model', [
            'name' => $this->getNameInput()
        ]);
    }

    /*
    protected function createLang()
    {
        //
    }

    protected function createView()
    {
        //
    }*/

    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }
}