<?php

namespace Apiato\Core\Generator\Commands;

use Apiato\Core\Generator\GeneratorCommand;
use Apiato\Core\Generator\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

/**
 * Class ConfigurationGenerator
 *
 * @author  Johannes Schobel <johannes.schobel@googlemail.com>
 */
class ConfigurationGenerator extends GeneratorCommand implements ComponentsGenerator
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'apiato:generate:configuration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Configuration file for a Package';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $fileType = 'Configuration';

    /**
     * The structure of the file path.
     *
     * @var  string
     */
    protected $pathStructure = '{package-name}/Configs/*';

    /**
     * The structure of the file name.
     *
     * @var  string
     */
    protected $nameStructure = '{file-name}-package';

    /**
     * The name of the stub file.
     *
     * @var  string
     */
    protected $stubName = 'config.stub';

    /**
     * User required/optional inputs expected to be passed while calling the command.
     * This is a replacement of the `getArguments` function "which reads whenever it's called".
     *
     * @var  array
     */
    public $inputs = [
    ];

    /**
     * @return array
     */
    public function getUserInputs()
    {
        return [
            'path-parameters' => [
                'package-name' => $this->packageName,
            ],
            'stub-parameters' => [
                '_package-name' => Str::lower($this->packageName),
                'package-name' => $this->packageName,
                'class-name' => $this->fileName,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }

    /**
     * Get the default file name for this component to be generated
     *
     * @return string
     */
    public function getDefaultFileName()
    {
        return Str::lower($this->packageName);
    }
}
