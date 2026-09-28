<?php

namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    public string $defaultGroup = 'default';

    public array $default = [
        'DSN'          => '',
        'hostname'     => 'localhost',
        'username'     => 'root',
        'password'     => '',
        'database'     => 'balaji_computech',
        'DBDriver'     => 'MySQLi',
        'DBPrefix'     => '',
        'pConnect'     => false,
        'DBDebug'      => (ENVIRONMENT !== 'production'),
        'charset'      => 'utf8mb4',
        'DBCollat'     => 'utf8mb4_general_ci',
        'swapPre'      => '',
        'encrypt'      => false,
        'compress'     => false,
        'strictOn'     => false,
        'failover'     => [],
        'port'         => 3306,
        'numberNative' => false,
        'foundRows'    => false,

        'dateFormat'   => [
            'date'     => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time'     => 'H:i:s',
        ],
    ];

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

    public function __construct()
    {
        parent::__construct();

        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
            return;
        }

        // Support both Vercel environment variables (DATABASE_DEFAULT_*) and CI4 .env format (database.default.*)
        $hostname = env('DATABASE_DEFAULT_HOSTNAME', env('database.default.hostname', $this->default['hostname'] ?? 'localhost'));
        $username = env('DATABASE_DEFAULT_USERNAME', env('database.default.username', $this->default['username'] ?? 'root'));
        $password = env('DATABASE_DEFAULT_PASSWORD', env('database.default.password', $this->default['password'] ?? ''));
        $database = env('DATABASE_DEFAULT_DATABASE', env('database.default.database', $this->default['database'] ?? 'balaji_computech'));
        $port     = (int) env('DATABASE_DEFAULT_PORT', env('database.default.port', $this->default['port'] ?? 3306));

        $this->default['hostname'] = $hostname;
        $this->default['username'] = $username;
        $this->default['password'] = $password;
        $this->default['database'] = $database;
        $this->default['port']     = $port;

        // Determine if SSL is needed (TiDB Cloud / remote database)
        $isRemoteHost = ($hostname !== 'localhost' && $hostname !== '127.0.0.1' && !empty($hostname));
        $sslRequired  = filter_var(env('DATABASE_DEFAULT_SSL', env('database.default.encrypt', $isRemoteHost)), FILTER_VALIDATE_BOOLEAN);

        if ($sslRequired) {
            $sslVerify = filter_var(env('DATABASE_DEFAULT_SSL_VERIFY', env('database.default.ssl_verify', true)), FILTER_VALIDATE_BOOLEAN);
            $sslCa     = (string) env('DATABASE_DEFAULT_SSL_CA', env('database.default.ssl_ca', ''));

            // Auto-detect system CA bundle on Linux/Lambda/Vercel if not explicitly provided
            if (empty($sslCa)) {
                $caLocations = [
                    '/etc/pki/tls/certs/ca-bundle.crt',   // Amazon Linux 2 / Vercel Lambda
                    '/etc/ssl/certs/ca-certificates.crt', // Debian / Ubuntu
                    '/etc/ssl/cert.pem',                  // Alpine / macOS
                ];
                foreach ($caLocations as $loc) {
                    if (is_file($loc) && is_readable($loc)) {
                        $sslCa = $loc;
                        break;
                    }
                }
            }

            // CodeIgniter 4 MySQLi driver requires an array to properly set MYSQLI_CLIENT_SSL flag
            $sslOptions = [
                'ssl_verify' => $sslVerify,
            ];
            if (!empty($sslCa)) {
                $sslOptions['ssl_ca'] = $sslCa;
            }

            $this->default['encrypt'] = $sslOptions;
        } else {
            $this->default['encrypt'] = false;
        }
    }
}