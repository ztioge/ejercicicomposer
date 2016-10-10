<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite017c5f5c574b489f02de204c80c0e0a
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Mascame\\VideoChecker\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Mascame\\VideoChecker\\' => 
        array (
            0 => __DIR__ . '/..' . '/mascame/video-checker/src/Mascame/VideoChecker',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite017c5f5c574b489f02de204c80c0e0a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite017c5f5c574b489f02de204c80c0e0a::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}