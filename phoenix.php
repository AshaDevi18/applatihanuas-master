<?php

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

return [
    'migration_dirs' => [
        // 'first' => __DIR__ . '/../first_dir',
        // 'second' => __DIR__ . '/../second_dir',
        'main' => __DIR__ . DIRECTORY_SEPARATOR . 'migrations',
    ],
    'environments' => [
        'local' => [
            'adapter' => 'mysql',
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'], // optional
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'db_name' => $_ENV['DB_NAME'],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci', // optional, if not set default collation for utf8mb4 is used
        ],
        'production' => [
            'adapter' => 'mysql',
            'host' => 'production_host',
            'port' => 3306, // optional
            'username' => 'user',
            'password' => 'pass',
            'db_name' => 'my_production_db',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci', // optional, if not set default collation for utf8mb4 is used
        ],
    ],
    'default_environment' => 'local',
    'log_table_name' => 'phoenix_log',
];

<?php

declare(strict_types=1);

use Phoenix\Database\Element\Index;
use Phoenix\Migration\AbstractMigration;

final class FirstInit extends AbstractMigration
{
    protected function up(): void
    {
        $this->table('user')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('username', 'string')
            ->addColumn('email', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addIndex('username', Index::TYPE_UNIQUE)
            ->addIndex('email', Index::TYPE_UNIQUE)
            ->create();

        $this->table('post')
            ->addColumn('id', 'integer', ['autoincrement' => true])
            ->addColumn('user_id', 'integer')
            ->addColumn('article', 'string')
            ->addColumn('jenis', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addForeignKey('user_id', 'user', 'id', 'restrict', 'no action')
            ->create();

        $this->insert('user', [
            [
                'username' => 'luffy',
                'email' => 'luffy@pirate.com',
                'created_at' => date('Y-m-d'),
            ],
            [
                'username' => 'zorro',
                'email' => 'zorro@pirate.com',
                'created_at' => date('Y-m-d'),
            ],
            [
                'username' => 'sanji',
                'email' => 'sanji@pirate.com',
                'created_at' => date('Y-m-d'),
            ],
            [
                'username' => 'nami',
                'email' => 'nami@pirate.com',
                'created_at' => date('Y-m-d'),
            ],
            [
                'username' => 'franky',
                'email' => 'franky@pirate.com',
                'created_at' => date('Y-m-d'),
            ],
        ]);
    }

    protected function down(): void
    {
        $this->table('post')
            ->drop();

        $this->table('user')
            ->drop();
    }
//
}