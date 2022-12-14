<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit981d2084df2e72c617ba51bb424552a6
{
    public static $prefixLengthsPsr4 = array (
        'i' => 
        array (
            'iutnc\\location\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'iutnc\\location\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/classes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit981d2084df2e72c617ba51bb424552a6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit981d2084df2e72c617ba51bb424552a6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit981d2084df2e72c617ba51bb424552a6::$classMap;

        }, null, ClassLoader::class);
    }
}
