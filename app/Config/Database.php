<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    /**
     * Directory containing migrations and seeds.
     */
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Default database group.
     */
    public string $defaultGroup = 'default';

    /**
     * Default database connection.
     *
     * Supports:
     * - Local XAMPP MySQL
     * - TiDB Cloud on Vercel
     */
    public array $default = [
        'DSN'          => '',

        // Database connection details
        'hostname'     => 'localhost',
        'username'     => 'root',
        'password'     => 'prabhanshu@123',
        'database'     => 'balaji_computech',

        // Database driver
        'DBDriver'     => 'MySQLi',
        'DBPrefix'     => '',
        'pConnect'     => false,

        // Show detailed errors only outside production
        'DBDebug'      => (ENVIRONMENT !== 'production'),

        // Character set
        'charset'      => 'utf8mb4',
        'DBCollat'     => 'utf8mb4_general_ci',

        'swapPre'      => '',

        // SSL enabled for TiDB Cloud
        'encrypt'      => true,

        'compress'     => false,
        'strictOn'     => false,
        'failover'     => [],
        'port'         => 3306,

        'numberNative' => false,
        'foundRows'    => false,

        // Date format
        'dateFormat'   => [
            'date'     => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time'     => 'H:i:s',
        ],
    ];

    /**
     * Database connection used for PHPUnit tests.
     */
    public array $tests = [
        'DSN'         => '',
        'hostname'    => '127.0.0.1',
        'username'    => '',
        'password'    => '',
        'database'    => ':memory:',
        'DBDriver'    => 'SQLite3',
        'DBPrefix'    => 'db_',
        'pConnect'    => false,
        'DBDebug'     => true,
        'charset'     => 'utf8',
        'DBCollat'    => '',
        'swapPre'     => '',
        'encrypt'     => false,
        'compress'    => false,
        'strictOn'    => true,
        'failover'    => [],
        'port'        => 3306,
        'foreignKeys' => true,
        'busyTimeout' => 1000,
        'synchronous' => null,

        'dateFormat'  => [
            'date'     => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time'     => 'H:i:s',
        ],
    ];

    /**
     * Initialize database configuration.
     */
    public function __construct()
    {
        parent::__construct();

        // Use the testing database during automated tests.
        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
            return;
        }

        // Read Vercel environment variables.
        $this->default['hostname'] = env(
            'DATABASE_DEFAULT_HOSTNAME',
            'localhost'
        );

        $this->default['username'] = env(
            'DATABASE_DEFAULT_USERNAME',
            'root'
        );

        $this->default['password'] = env(
            'DATABASE_DEFAULT_PASSWORD',
            ''
        );

        $this->default['database'] = env(
            'DATABASE_DEFAULT_DATABASE',
            'balaji_computech'
        );

        $this->default['port'] = (int) env(
            'DATABASE_DEFAULT_PORT',
            3306
        );

        // Enable SSL for remote database connections.
        $this->default['encrypt'] =
            ($this->default['hostname'] !== 'localhost'
            && $this->default['hostname'] !== '127.0.0.1');
    }
}