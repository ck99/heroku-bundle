<?php
/**
 * HerokuDetector.php
 * @author ciaran
 * @date 26/11/14 01:20
 *
 */

namespace Ck99\HerokuBundle\Utils;


class HerokuDetector
{
    const SYMFONY_ON_HEROKU        = 'SYMFONY_ON_HEROKU';
    const SYMFONY_KERNEL_ROOT_DIR  = 'SYMFONY_KERNEL_ROOT_DIR';
    const DYNO                     = 'DYNO';
    const HOME                     = 'HOME';
    const APP                      = '/app';


    public static function getSymfonyKernelRoot()
    {
        // allow explicit overriding, mainly used for testing
        if($rootDir = getenv(self::SYMFONY_KERNEL_ROOT_DIR)) {
            return $rootDir;
        } else {
            return getenv(self::HOME).self::APP;
        }
    }

    public static function detected()
    {
        return (getenv(self::SYMFONY_ON_HEROKU) || getenv(self::DYNO)) ? true : false;
    }
} 