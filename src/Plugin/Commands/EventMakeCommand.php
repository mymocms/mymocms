<?php

namespace Mymo\Plugin\Commands;

use Illuminate\Support\Str;
use Mymo\Plugin\Support\Config\GenerateConfigReader;
use Mymo\Plugin\Support\Stub;
use Mymo\Plugin\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;

class EventMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    protected $argumentName = 'name';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make-event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new event class for the specified plugin';

    public function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub('/event.stub', [
            'NAMESPACE' => $this->getClassNamespace($module),
            'CLASS' => $this->getClass(),
        ]))->render();
    }

    public function getDestinationFilePath()
    {
        $path       = $this->laravel['modules']->getModulePath($this->getModuleName());

        $eventPath = GenerateConfigReader::read('event');

        return $path . $eventPath->getPath() . '/' . $this->getFileName() . '.php';
    }

    /**
     * @return string
     */
    protected function getFileName()
    {
        return Str::studly($this->argument('name'));
    }

    public function getDefaultNamespace() : string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.event.namespace') ?: $module->config('paths.generator.event.path', 'Events');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the event.'],
            ['module', InputArgument::OPTIONAL, 'The name of plugin will be used.'],
        ];
    }
}