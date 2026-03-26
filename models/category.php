<?php
class Category
{
    // DB STUFF
    private $conn;
    private $table = 'categories';

    // Properties
    public $id;
    public $name;
    public $created_at;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = 'SELECT
                id,
                name
            FROM
                ' . $this->table . '
            ORDER BY
                created_at DESC';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();
        return $stmt;
    }
}