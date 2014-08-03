<?php
namespace WordPress\L18N;

class WordPressIncluder
{
    private static function getWPPath()
    {
        // The below is very gross, but it is the best solution
        // I can think of short of including a WordPress with
        // autoloading via classmap.

        // Up four, src/package directory/vendor directory/dependencies directory.
        // WordPress is installed in project root, under the directory name 'wordpress'
        // by default.
        return __DIR__ . '/../../../../wordpress';
    }

    public static function get($wordPressFile)
    {
        if (!file_exists(self::getWPPath()))
            throw new \Exception('WordPress could not be found where we thought it should be at: ' . realpath(dirname(self::getWPPath()) . DIRECTORY_SEPARATOR . basename(self::getWPPath())));

        $path = realpath(self::getWPPath() . DIRECTORY_SEPARATOR . ltrim($wordPressFile, DIRECTORY_SEPARATOR));

        if ($path === false)
            throw new \Exception('File ' . $wordPressFile . ' could not be found.');

        return require $path;
    }
}
