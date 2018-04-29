<?php

namespace Apiato\Core\Loaders;

use App;
use File;

/**
 * Class LocalizationLoaderTrait
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
trait LocalizationLoaderTrait
{

    /**
     * @param $packageName
     */
    public function loadLocalsFromPackages($packageName)
    {
        $packageMigrationDirectory = base_path('app/Packages/' . $packageName . '/Resources/Languages');

        $this->loadLocals($packageMigrationDirectory, $packageName);
    }

    /**
     * @void
     */
    public function loadLocalsFromShip()
    {
        // ..
    }

    /**
     * @param $directory
     * @param $packageName
     */
    private function loadLocals($directory, $packageName)
    {
        if (File::isDirectory($directory)) {

            $this->loadTranslationsFrom($directory, strtolower($packageName));

        }
    }

}
