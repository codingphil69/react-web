<?php

declare(strict_types=1);

namespace ReactWeb\Connection;

use PDO;

/**
 * DatabaseConnection
 *
 * @package ReactWeb\Connection
 * @author Philipp Lohmann <lohmann.philipp@gmx.net>
 */
class DatabaseConnection
{
    public readonly PDO $pdo;

    public function __construct(
        private readonly string $username,
        private readonly string $password,
        private readonly string $host,
        private readonly int $port,
        private readonly string $charset,
        private readonly string $dbname
    )
    {
        $this->connect();
    }

    private function connect(): void
    {
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $this->host, $this->port, $this->dbname, $this->charset);
        $this->pdo = new PDO($dsn, $this->username, $this->password);
    }
}