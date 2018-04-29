<?php

namespace Apiato\Core\Generator\Commands;

use Apiato\Core\Generator\GeneratorCommand;
use Apiato\Core\Generator\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class RequestGenerator
 *
 * @author  Johannes Schobel <johannes.schobel@googlemail.com>
 */
class RequestGenerator extends GeneratorCommand implements ComponentsGenerator
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'apiato:generate:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Request class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $fileType = 'Request';

    /**
     * The structure of the file path.
     *
     * @var  string
     */
    protected $pathStructure = '{package-name}/UI/{user-interface}/Requests/*';

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
    protected $stubName = 'request.stub';

    /**
     * User required/optional inputs expected to be passed while calling the command.
     * This is a replacement of the `getArguments` function "which reads whenever it's called".
     *
     * @var  array
     */
    public $inputs = [
        ['ui', null, InputOption::VALUE_OPTIONAL, 'The user-interface to generate the Request for.'],
        ['transporter', null, InputOption::VALUE_OPTIONAL, 'Create a corresponding Transporter for this Request'],
        ['transportername', null, InputOption::VALUE_OPTIONAL, 'The name of the Transporter to be assigned'],
    ];

    /**
     * @return array
     */
    public function getUserInputs()
    {
        $ui = Str::lower($this->checkParameterOrChoice('ui', 'Select the UI for the controller', ['API', 'WEB'], 0));
        $transporter = $this->checkParameterOrConfirm('transporter', 'Would you like to create a corresponding Transporter for this Request?', true);

        if ($transporter) {
            $transporterName = $this->checkParameterOrAsk('transportername', 'Enter the Name of the corresponding Transporter to be assigned');

            $transporterComment = '';
            $transporterClass = '\\App\\Packages\\' . $this->packageName . '\\Data\\Transporters\\' . $transporterName . '::class';

            // now create the Transporter
            $this->call('apiato:generate:transporter', [
                '--package' => $this->packageName,
                '--file' => $transporterName,
            ]);
        }
        else {
            $transporterComment = '// ';
            $transporterClass = '\\App\\Base\\Transporters\\DataTransporter::class';
        }

        return [
            'path-parameters' => [
                'package-name' => $this->packageName,
                'user-interface' => Str::upper($ui),
            ],
            'stub-parameters' => [
                '_package-name' => Str::lower($this->packageName),
                'package-name' => $this->packageName,
                'class-name' => $this->fileName,
                'user-interface' => Str::upper($ui),
                'transporterEnabled' => $transporterComment,
                'transporterClass' => $transporterClass,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }

}
