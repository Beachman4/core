<?php

namespace Apiato\Core\Generator\Commands;

use Apiato\Core\Generator\GeneratorCommand;
use Apiato\Core\Generator\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

/**
 * Class NotificationGenerator
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class NotificationGenerator extends GeneratorCommand implements ComponentsGenerator
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'apiato:generate:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Notification class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $fileType = 'Notification';

    /**
     * The structure of the file path.
     *
     * @var  string
     */
    protected $pathStructure = '{package-name}/Notifications/*';

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
    protected $stubName = 'notification.stub';

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

  }
