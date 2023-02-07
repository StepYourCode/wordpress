<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit181177ab4a90f38ae0968c193a5c589e
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\Translation\\' => 30,
        ),
        'F' => 
        array (
            'Faker\\' => 6,
            'FakerPress\\Dev\\' => 15,
            'FakerPress\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\Translation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/translation',
        ),
        'Faker\\' => 
        array (
            0 => __DIR__ . '/..' . '/fzaninotto/faker/src/Faker',
        ),
        'FakerPress\\Dev\\' => 
        array (
            0 => __DIR__ . '/../..' . '/dev/src',
        ),
        'FakerPress\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/FakerPress',
        ),
    );

    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/..' . '/nesbot/carbon/src',
    );

    public static $prefixesPsr0 = array (
        'U' => 
        array (
            'UpdateHelper\\' => 
            array (
                0 => __DIR__ . '/..' . '/kylekatarnls/update-helper/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit181177ab4a90f38ae0968c193a5c589e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit181177ab4a90f38ae0968c193a5c589e::$prefixDirsPsr4;
            $loader->fallbackDirsPsr4 = ComposerStaticInit181177ab4a90f38ae0968c193a5c589e::$fallbackDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit181177ab4a90f38ae0968c193a5c589e::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
