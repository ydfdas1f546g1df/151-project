<?php

namespace core;

use PDOException;

class Database
{
    private $host = DB_HOST; // Database host
    private $user = DB_USER; // Database username
    private $password = DB_PASS; // Database password
    private $dbname = DB_NAME; // Database name
    private $dbport = DB_PORT; // Database port

    private $dbh; // Define database handler
    private $stmt; // Define SQL statement
    private $error; // Define error message

    public function __construct()
    {
        // Data Source Name (DSN) for the PDO connection
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';port=' . $this->dbport;

        // Options for the PDO connection
        $options = [
            // Use persistent connection
            // (i.e., This prevents establishing a new connection each time when an instance of Database (object) is created.
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION // Throw exceptions on errors
        ];

        // Try to connect to the database by creating a new PDO instance
        try {
            $this->dbh = new \PDO($dsn, $this->user, $this->password, $options);
        } catch (\PDOException $e) {
            // If an error occurs, store the error message
            $this->error = $e->getMessage();
            // Display error message
            echo $this->error;
        }
    }

    // Method to prepare an SQL query
    public function query($sql)
    {
        // Prepare the SQL statement
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Method to execute the prepared statement
    public function execute()
    {
        // Execute the statement and return the result
        return $this->stmt->execute();
    }

    public function executeFile($file)
    {
        $this->dbh->beginTransaction();
        // Read the SQL file content
        $sql = file_get_contents($file);
        try {
            $ret = $this->dbh->exec($sql);
        } catch (PDOException $e) {
            // If an error occurs, roll back the transaction
            $this->dbh->rollBack();
            // Display error message
            echo "Error executing file $file: " . $e->getMessage();
            return $ret;
        }
        // Commit the transaction if successful
        $this->dbh->commit();
        return $ret;
    }


// Method to fetch all results as an associative array
    public
    function results()
    {
        // Fetch all results to an associative array and return them
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public
    function single()
    {
        // identical behaviour; keeps older code working
        return $this->result();
    }

// Method to fetch a single result to an associative array
    public
    function result()
    {
        // Execute the statement
        $this->execute();
        // Fetch and return a single result
        return $this->stmt->fetch(\PDO::FETCH_ASSOC);
    }

// Method to bind a value to a parameter in the SQL statement
    public
    function bind($param, $value): void
    {
        // Bind the value to the parameter
        $this->stmt->bindValue($param, $value);
    }

    public
    function prepare($sql)
    {
        // Prepare the SQL statement
        $this->stmt = $this->dbh->prepare($sql);
    }
}