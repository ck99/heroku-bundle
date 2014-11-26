<?php
/**
 * DatabaseConfiguration.php
 * @author ciaran
 * @date 26/11/14 02:11
 *
 */

namespace Ck99\HerokuBundle\DependencyInjection;

use Ck99\HerokuBundle\Utils\Environment;

class DatabaseConfiguration
{
    protected $databaseEnvironmentVariableNames = array(
        'SYMFONY_DATABASE_DSN', // allow explicit override, mainly for testing
        'DATABASE_URL',         // heroku Postgres sets this
        'CLEARDB_DATABASE_URL',
    );

    public function getParameterMap()
    {
        $parameterMap = array();

        // configure database
        $dsn = Environment::getFirst($this->databaseEnvironmentVariableNames);
        if ((null !== $dsn) && (false !== filter_var($dsn, FILTER_VALIDATE_URL))) {
            $parameterMap = $this->populateDatabaseParametersByDsn($dsn);
        }

        return $parameterMap;
    }

    /**
     * Attempt to parse a DSN string into standard parameters
     * @param $dsn
     * @return array
     */
    protected function populateDatabaseParametersByDsn($dsn) {
        $parameters = parse_url($dsn);
        $parameterMap = array(
            'database_host'     => $parameters['host'],
            'database_name'     => substr($parameters['path'],1),
            'database_user'     => $parameters['user'],
            'database_password' => $parameters['pass'],
        );
        if(array_key_exists('port', $parameters)) {
            $parameterMap['database_port'] = $parameters['port'];
        }

        $dbSchemeToDriverMap = array(
            'mysql'    => 'pdo_mysql',
            'postgres' => 'pdo_pgsql',
        );

        $driver = (array_key_exists($parameters['scheme'], $dbSchemeToDriverMap)) ? $dbSchemeToDriverMap[$parameters['scheme']] : null;

        if(null !== $driver) {
            $parameterMap['database_driver'] = $driver;
        }

        return $parameterMap;
    }

} 