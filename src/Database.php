<?php

namespace App\Database;

use PDO;
use PDOException;

/**
 * Simple PDO-based MySQL Database wrapper for the Copy tool.
 *
 * Usage:
 *   $db = new Database(getenv('DB_HOST'), (int)getenv('DB_PORT'), getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASS'));
 *   $pdo = $db->getConnection();
 */
class Database
{
    private PDO $connection;

    /**
     * Database constructor.
     *
     * @param string $host
     * @param int $port
     * @param string $dbname
     * @param string $user
     * @param string $password
     */
    public function __construct(
        string $host = '127.0.0.1',
        int $port = 3306,
        string $dbname = 'storyclash',
        string $user = 'root',
        string $password = ''
    ) {
        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $host, $port, $dbname);

        try {
            $this->connection = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            throw new \RuntimeException('Database connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Get raw PDO connection for advanced usage.
     *
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Run a SELECT that returns multiple rows.
     *
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Run a SELECT that returns a single row (or null).
     *
     * @param string $sql
     * @param array $params
     * @return array|null
     */
    public function fetchOne(string $sql, array $params = []): ?array
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result === false ? null : $result;
    }

    /**
     * Execute a statement (INSERT/UPDATE/DELETE). Returns number of affected rows.
     *
     * @param string $sql
     * @param array $params
     * @return int
     */
    public function execute(string $sql, array $params = []): int
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    /**
     * Insert and return last insert id as int.
     *
     * @param string $sql
     * @param array $params
     * @return int
     */
    public function insertAndGetId(string $sql, array $params = []): int
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return (int)$this->connection->lastInsertId();
    }

    /**
     * Begin transaction.
     */
    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
    }

    /**
     * Commit transaction.
     */
    public function commit(): void
    {
        $this->connection->commit();
    }

    /**
     * Rollback transaction.
     */
    public function rollBack(): void
    {
        if ($this->connection->inTransaction()) {
            $this->connection->rollBack();
        }
    }

    /**
     * Convenience: fetch many rows in chunks to avoid high memory usage.
     * Generator yields rows as associative arrays.
     *
     * @param string $sql
     * @param array $params
     * @param int $fetchSize
     * @return \Generator
     */
    public function fetchCursor(string $sql, array $params = [], int $fetchSize = 1000): \Generator
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        // Use a simple cursor: fetch one row at a time to keep memory low
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            yield $row;
        }
    }
}
