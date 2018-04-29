<?php

namespace Apiato\Core\Generator\Commands;

use Apiato\Core\Generator\GeneratorCommand;
use Apiato\Core\Generator\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ContainerComposerGenerator
 *
 * @author  Johannes Schobel <johannes.schobel@googlemail.com>
 */
class ContainerGenerator extends GeneratorCommand implements ComponentsGenerator
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'apiato:generate:package';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Package for apiato from scratch';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $fileType = 'Package';

    /**
     * The structure of the file path.
     *
     * @var  string
     */
    protected $pathStructure = '{package-name}/*';

    /**
     * The structure of the file name.
     *
     * @var  string
     */
    protected $nameStructure = '{file-name}';

    /**
     * The name of the stub file.
     *
     * @var  string
     */
    protected $stubName = 'composer.stub';

    /**
     * User required/optional inputs expected to be passed while calling the command.
     * This is a replacement of the `getArguments` function "which reads whenever it's called".
     *
     * @var  array
     */
    public $inputs = [
        ['ui', null, InputOption::VALUE_OPTIONAL, 'The user-interface to generate the Controller for.'],
        ['transporters', null, InputOption::VALUE_OPTIONAL, 'Use specific Transporters or rely on the generic DataTransporter'],
    ];

    /**
     * @return array
     */
    public function getUserInputs()
    {
        $ui = Str::lower($this->checkParameterOrChoice('ui', 'Select the UI for this package', ['API', 'WEB', 'BOTH'], 0));

        $useTransporters = $this->checkParameterOrConfirm('transporters', 'Would you like to use specific Transporters', true);

        // packagename as inputted and lower
        $packageName = $this->packageName;
        $_packageName = Str::lower($this->packageName);

        if ($ui == 'api' || $ui == 'both') {
            $this->call('apiato:generate:package:api', [
                '--package'    => $packageName,
                '--file'         => 'composer',
                '--transporters' => $useTransporters,
            ]);
        }

        if ($ui == 'web' || $ui == 'both') {
            $this->call('apiato:generate:package:web', [
                '--package'    => $packageName,
                '--file'         => 'composer',
                '--transporters' => $useTransporters,
            ]);
        }

        $this->printInfoMessage('Generating Composer File');
        return [
            'path-parameters' => [
                'package-name' => $packageName,
            ],
            'stub-parameters' => [
                '_package-name' => $_packageName,
                'package-name' => $packageName,
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
        return 'composer';
    }

    public function getDefaultFileExtension()
    {
        return 'json';
    }


}
