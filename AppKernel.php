<?php
/**
 * AppKernel.php
 * @author ciaran
 * @date 26/11/14 01:15
 *
 */

namespace Ck99\HerokuBundle;

use Symfony\Component\HttpKernel\Kernel;

abstract class AppKernel extends Kernel
{
    /**
     * Override check for Kernel Root Dir.
     * Otherwise, the app will misbehave on Heroku.
     *
     * @return mixed|string
     */
    public function getRootDir()
    {
        if(Utils\HerokuDetector::detected()) {
            return Utils\HerokuDetector::getSymfonyKernelRoot();
        } else {
            return parent::getRootDir();
        }
    }
} 