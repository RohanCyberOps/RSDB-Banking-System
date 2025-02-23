<?php
namespace php;

/**
 * Generic datasource class for handling DB operations.
 * Uses MySQLi and PreparedStatements.
 *
 * @version 2.4
 */
class DataSource
{
    // Constants for database connection details
    const HOST = 'localhost';
    const USERNAME = 'root';
    const PASSWORD = 'Rohan15@';
    const DATABASENAME = 'bank';

    private $conn;

    /**
     * Constructor to initialize the database connection.
     */
    public function __construct()
    {
        $this->conn = $this->getConnection();
    }

    /**
     * Establishes a connection to the database.
     *
     * @return \mysqli
     * @throws \Exception If connection fails.
     */
    public function getConnection()
    {
        $conn = new \mysqli(self::HOST, self::USERNAME, self::PASSWORD, self::DATABASENAME);

        if (mysqli_connect_errno()) {
            throw new \Exception("Failed to connect to MySQL: " . mysqli_connect_error());
        }

        $conn->set_charset("utf8mb4"); // Use utf8mb4 for better character support
        return $conn;
    }

    /**
     * Executes a SELECT query and returns the results as an array.
     *
     * @param string $query The SQL query.
     * @param string $paramType Types of parameters (e.g., 's', 'i', 'd', 'b').
     * @param array $paramArray Parameters to bind to the query.
     * @return array|null Fetched results or null if no results.
     */
    public function select($query, $paramType = "", $paramArray = [])
    {
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new \Exception("Prepare failed: " . $this->conn->error);
        }

        if (!empty($paramType) && !empty($paramArray)) {
            $this->bindQueryParams($stmt, $paramType, $paramArray);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $resultset = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }

        $stmt->close();
        return !empty($resultset) ? $resultset : null;
    }

    /**
     * Executes an INSERT query and returns the last inserted ID.
     *
     * @param string $query The SQL query.
     * @param string $paramType Types of parameters.
     * @param array $paramArray Parameters to bind to the query.
     * @return int Last inserted ID.
     */
    public function insert($query, $paramType, $paramArray)
    {
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new \Exception("Prepare failed: " . $this->conn->error);
        }

        $this->bindQueryParams($stmt, $paramType, $paramArray);
        $stmt->execute();
        $insertId = $stmt->insert_id;
        $stmt->close();

        return $insertId;
    }

    /**
     * Executes a query (e.g., UPDATE, DELETE).
     *
     * @param string $query The SQL query.
     * @param string $paramType Types of parameters.
     * @param array $paramArray Parameters to bind to the query.
     * @return bool True on success, false on failure.
     */
    public function execute($query, $paramType = "", $paramArray = [])
    {
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new \Exception("Prepare failed: " . $this->conn->error);
        }

        if (!empty($paramType) && !empty($paramArray)) {
            $this->bindQueryParams($stmt, $paramType, $paramArray);
        }

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /**
     * Binds parameters to a prepared statement.
     *
     * @param \mysqli_stmt $stmt Prepared statement.
     * @param string $paramType Types of parameters.
     * @param array $paramArray Parameters to bind.
     */
    private function bindQueryParams($stmt, $paramType, $paramArray = [])
    {
        $paramValueReference[] = &$paramType;
        for ($i = 0; $i < count($paramArray); $i++) {
            $paramValueReference[] = &$paramArray[$i];
        }
        call_user_func_array([$stmt, 'bind_param'], $paramValueReference);
    }

    /**
     * Returns the number of rows matching a query.
     *
     * @param string $query The SQL query.
     * @param string $paramType Types of parameters.
     * @param array $paramArray Parameters to bind to the query.
     * @return int Number of rows.
     */
    public function numRows($query, $paramType = "", $paramArray = [])
    {
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new \Exception("Prepare failed: " . $this->conn->error);
        }

        if (!empty($paramType) && !empty($paramArray)) {
            $this->bindQueryParams($stmt, $paramType, $paramArray);
        }

        $stmt->execute();
        $stmt->store_result();
        $recordCount = $stmt->num_rows;
        $stmt->close();

        return $recordCount;
    }

    /**
     * Closes the database connection.
     */
    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}