<?php
/**
 * HerokuContainerPopulator.php
 * @author ciaran
 * @date 26/11/14 01:38
 *
 */

namespace Ck99\HerokuBundle\DependencyInjection;

use Ck99\HerokuBundle\Utils\HerokuDetector;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class HerokuContainerPopulator
{
    const LOG_OUTPUT = 'log_output';

    /** @var ContainerBuilder  */
    private $container;

    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    public function populateFromEnvironment()
    {
        if(HerokuDetector::detected()) {
            $this->logToStandardError();
            $this->applyParameterMap(
                (new DatabaseConfiguration())->getParameterMap()
            );
        }
    }

    protected function logToStandardError()
    {
        $this->container->setParameter(self::LOG_OUTPUT, 'php://stderr');
    }

    protected function applyParameterMap($parameterMap)
    {
        foreach ($parameterMap as $key => $value) {
            $this->container->setParameter($key, $value);
        }
    }
}