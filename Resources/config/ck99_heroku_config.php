<?php

use Ck99\HerokuBundle\DependencyInjection\HerokuContainerPopulator;
(new HerokuContainerPopulator($container))->populateFromEnvironment();
