<?php

namespace Apiato\Core\Loaders;

use App;
use File;

/**
 * Class MigrationsLoaderTrait.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
trait MigrationsLoaderTrait
{

    /**
     * @param $packageName
     */
    public function loadMigrationsFromPackages($packageName)
    {
        $packageMigrationDirectory = base_path('app/Packages/' . $packageName . '/Data/Migrations');

        $this->loadMigrations($packageMigrationDirectory);
    }

    /**
     * @void
     */
    public function loadMigrationsFromShip()
    {
        $portMigrationDirectory = base_path('app/Base/Migrations');

        $this->loadMigrations($portMigrationDirectory);
    }

    /**
     * @param $directory
     */
    private function loadMigrations($directory)
    {
        if (File::isDirectory($directory)) {

            $this->loadMigrationsFrom($directory);

        }
    }

}
