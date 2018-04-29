<?php

/**
 * This files acts as the single factory php file of all the application.
 * Inside this file I am including every factory file found int he application.
 *
 * This currently only load factories from packages not form the port as it's not necessary yet!
 */

use Apiato\Core\Foundation\Facades\Apiato;

// Default seeders directory in the container
$packagesFactoriesPath = '/Data/Factories/';

// Automatically include Factory Files from all Packages to this file,
// which will be used by Laravel when dealing with Model Factories.

// Checkout the FactoriesLoaderTrait.php trait, to get an idea on how this works.
foreach (Apiato::getPackagesNames() as $containerName) {

    $packagesDirectory = base_path('app/Packages/' . $containerName . $packagesFactoriesPath);

    if (\File::isDirectory($packagesDirectory)) {

        $files = \File::allFiles($packagesDirectory);

        foreach ($files as $factoryFile) {

            if (\File::isFile($factoryFile)) {

                // Include the factory files
                include($factoryFile);

            }
        }
    }

}

