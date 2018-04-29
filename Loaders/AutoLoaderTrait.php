<?php

namespace Apiato\Core\Loaders;

use Apiato\Core\Foundation\Facades\Apiato;

/**
 * Class AutoLoaderTrait.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
trait AutoLoaderTrait
{

    // using each component loader trait
    use ConfigsLoaderTrait;
    use LocalizationLoaderTrait;
    use MigrationsLoaderTrait;
    use ViewsLoaderTrait;
    use ProvidersLoaderTrait;
    use ConsolesLoaderTrait;
    use AliasesLoaderTrait;

    /**
     * * to be used from the `boot` function of the main service provider
     */
    public function runLoadersBoot()
    {
        // the config files should be loaded first from all the directories in their own loop
        $this->loadConfigsFromShip();
        $this->loadMigrationsFromShip();
        $this->loadViewsFromShip();
        $this->loadConsolesFromShip();

        // > iterate over all the packages folders and autoload most of the components
        foreach (Apiato::getPackagesNames() as $containerName) {
            $this->loadConfigsFromPackages($containerName);
            $this->loadLocalsFromPackages($containerName);
            $this->loadOnlyMainProvidersFromPackages($containerName);
            $this->loadMigrationsFromPackages($containerName);
            $this->loadConsolesFromPackages($containerName);
            $this->loadViewsFromPackages($containerName);
        }

        $this->loadFactoriesFromPackages();
    }

}
