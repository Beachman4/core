<?php

namespace Apiato\Core\Loaders;

use File;

/**
 * Class ViewsLoaderTrait.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
trait ViewsLoaderTrait
{

    /**
     * @param $packageName
     */
    public function loadViewsFromPackages($packageName)
    {
        $packageViewDirectory = base_path('app/Packages/' . $packageName . '/UI/WEB/Views/');
        $packageMailTemplatesDirectory = base_path('app/Packages/' . $packageName . '/Mails/Templates/');

        $this->loadViews($packageViewDirectory, $packageName);
        $this->loadViews($packageMailTemplatesDirectory, $packageName);
    }

    /**
     * @param void
     */
    public function loadViewsFromShip()
    {
        $portMailTemplatesDirectory = base_path('app/Base/Mails/Templates/');

        $this->loadViews($portMailTemplatesDirectory, 'ship'); // Base views accessible via `ship::`.
    }

    /**
     * @param $directory
     * @param $packageName
     */
    private function loadViews($directory, $packageName)
    {
        if (File::isDirectory($directory)) {
            $this->loadViewsFrom($directory, strtolower($packageName));
        }
    }

}
