<?php
/**
 * Environment.php
 * @author ciaran
 * @date 26/11/14 02:16
 *
 */

namespace Ck99\HerokuBundle\Utils;


class Environment
{
    /**
     * Process a list of possible environment variables, returning the first one.
     * @param $envVarList
     * @return null|string
     */
    public static function getFirst($envVarList)
    {
        foreach ($envVarList as $envVar) {
            if($value = getenv($envVar)) {
                return $value;
            }
        }
        return null;
    }
} 