<?php

namespace Apiato\Core\Generator\Commands;

use Apiato\Core\Generator\GeneratorCommand;
use Apiato\Core\Generator\Interfaces\ComponentsGenerator;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ModelGenerator
 *
 * @author  Justin Atack  <justinatack@gmail.com>
 */
class ModelGenerator extends GeneratorCommand implements ComponentsGenerator
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'apiato:generate:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $fileType = 'Model';

    /**
     * The structure of the file path.
     *
     * @var  string
     */
    protected $pathStructure = '{package-name}/Models/*';

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
    protected $stubName = 'model.stub';

    /**
     * User required/optional inputs expected to be passed while calling the command.
     * This is a replacement of the `getArguments` function "which reads whenever it's called".
     *
     * @var  array
     */
    public $inputs = [
        ['repository', null, InputOption::VALUE_OPTIONAL, 'Generate the corresponding Repository for this Model?'],
    ];

    /**
     * @return array
     */
    public function getUserInputs()
    {
        $repository = $this->checkParameterOrConfirm('repository', 'Do you want to generate the corresponding Repository for this Model?', true);
        if($repository) {
            // we need to generate a corresponding repository
            // so call the other command
            $status = $this->call('apiato:generate:repository', [
                '--package' => $this->packageName,
                '--file' => $this->fileName . 'Repository'
            ]);

            if ($status == 0) {
                $this->printInfoMessage('The Repository was successfully generated');
            }
            else {
                $this->printErrorMessage('Could not generate the corresponding Repository!');
            }
        }

        return [
            'path-parameters' => [
                'package-name' => $this->packageName,
            ],
            'stub-parameters' => [
                '_package-name' => Str::lower($this->packageName),
                'package-name' => $this->packageName,
                'class-name' => $this->fileName,
                'resource-key' => strtolower(Pluralizer::plural($this->fileName)),
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }

}
