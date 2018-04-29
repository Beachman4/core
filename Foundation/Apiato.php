<?php

namespace Apiato\Core\Foundation;

use Apiato\Core\Exceptions\ClassDoesNotExistException;
use Apiato\Core\Exceptions\MissingContainerException;
use Apiato\Core\Exceptions\WrongConfigurationsException;
use Apiato\Core\Traits\CallableTrait;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

/**
 * Class Apiato
 *
 * Helper Class to serve Apiato (Base/Packages).
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class Apiato
{

    use CallableTrait;

    /**
     * Get the packages namespace value from the packages config file
     *
     * @return  string
     */
    public function getPackagesNamespace()
    {
        return Config::get('apiato.containers.namespace');
    }

    /**
     * Get the packages names
     *
     * @return  array
     */
    public function getPackagesNames()
    {
        $packagesNames = [];

        foreach ($this->getPackagesPaths() as $packagesPath) {
            $packagesNames[] = basename($packagesPath);
        }

        return $packagesNames;
    }

    /**
     * Get the port folders names
     *
     * @return  array
     */
    public function getShipFoldersNames()
    {
        $portFoldersNames = [];

        foreach ($this->getShipPath() as $portFoldersPath) {
            $portFoldersNames[] = basename($portFoldersPath);
        }

        return $portFoldersNames;
    }

    /**
     * get packages directories paths
     *
     * @return  mixed
     */
    public function getPackagesPaths()
    {
        return File::directories(app_path('Packages'));
    }

    /**
     * @return  mixed
     */
    public function getShipPath()
    {
        return File::directories(app_path('Base'));
    }

    /**
     * build and return an object of a class from its file path
     *
     * @param $filePathName
     *
     * @return  mixed
     */
    public function getClassObjectFromFile($filePathName)
    {
        $classString = $this->getClassFullNameFromFile($filePathName);

        $object = new $classString;

        return $object;
    }

    /**
     * get the full name (name \ namespace) of a class from its file path
     * result example: (string) "I\Am\The\Namespace\Of\This\Class"
     *
     * @param $filePathName
     *
     * @return  string
     */
    public function getClassFullNameFromFile($filePathName)
    {
        return $this->getClassNamespaceFromFile($filePathName) . '\\' . $this->getClassNameFromFile($filePathName);
    }

    /**
     * get the class namespace form file path using token
     *
     * @param $filePathName
     *
     * @return  null|string
     */
    protected function getClassNamespaceFromFile($filePathName)
    {
        $src = file_get_contents($filePathName);

        $tokens = token_get_all($src);
        $count = count($tokens);
        $i = 0;
        $namespace = '';
        $namespace_ok = false;
        while ($i < $count) {
            $token = $tokens[$i];
            if (is_array($token) && $token[0] === T_NAMESPACE) {
                // Found namespace declaration
                while (++$i < $count) {
                    if ($tokens[$i] === ';') {
                        $namespace_ok = true;
                        $namespace = trim($namespace);
                        break;
                    }
                    $namespace .= is_array($tokens[$i]) ? $tokens[$i][1] : $tokens[$i];
                }
                break;
            }
            $i++;
        }
        if (!$namespace_ok) {
            return null;
        } else {
            return $namespace;
        }
    }

    /**
     * get the class name form file path using token
     *
     * @param $filePathName
     *
     * @return  mixed
     */
    protected function getClassNameFromFile($filePathName)
    {
        $php_code = file_get_contents($filePathName);

        $classes = array();
        $tokens = token_get_all($php_code);
        $count = count($tokens);
        for ($i = 2; $i < $count; $i++) {
            if ($tokens[$i - 2][0] == T_CLASS
                && $tokens[$i - 1][0] == T_WHITESPACE
                && $tokens[$i][0] == T_STRING
            ) {

                $class_name = $tokens[$i][1];
                $classes[] = $class_name;
            }
        }

        return $classes[0];
    }

    /**
     * check if a word starts with another word
     *
     * @param $word
     * @param $startsWith
     *
     * @return  bool
     */
    public function stringStartsWith($word, $startsWith)
    {
        return (substr($word, 0, strlen($startsWith)) === $startsWith);
    }

    /**
     * @param        $word
     * @param string $splitter
     * @param bool   $uppercase
     *
     * @return  mixed|string
     */
    public function uncamelize($word, $splitter = " ", $uppercase = true)
    {
        $word = preg_replace('/(?!^)[[:upper:]][[:lower:]]/', '$0',
            preg_replace('/(?!^)[[:upper:]]+/', $splitter . '$0', $word));

        return $uppercase ? ucwords($word) : $word;
    }

    /**
     * @return mixed
     * @throws WrongConfigurationsException
     */
    public function getLoginWebPageName()
    {
        $loginPage = Config::get('apiato.containers.login-page-url');

        if (is_null($loginPage)) {
            throw new WrongConfigurationsException();
        }

        return $loginPage;
    }


    /**
     * Build namespace for a class in Package.
     *
     * @param $packageName
     * @param $className
     *
     * @return  string
     */
    public function buildClassFullName($packageName, $className)
    {
        return 'App\Packages\\' . $packageName . '\\' . $this->getClassType($className) . 's\\' . $className;
    }

    /**
     * Get the last part of a camel case string.
     * Example input = helloDearWorld | returns = World
     *
     * @param $className
     *
     * @return  mixed
     */
    public function getClassType($className)
    {
        $array = preg_split('/(?=[A-Z])/', $className);

        return end($array);
    }

    /**
     * @param $packageName
     *
     * @throws MissingContainerException
     */
    public function verifyContainerExist($packageName)
    {
        if (!is_dir(app_path('Packages/' . $packageName))) {
            throw new MissingContainerException("Package ($packageName) is not installed.");
        }
    }

    /**
     * @param $className
     *
     * @throws ClassDoesNotExistException
     */
    public function verifyClassExist($className)
    {
        if (!class_exists($className)) {
            throw new ClassDoesNotExistException("Class ($className) is not installed.");
        }
    }

}
