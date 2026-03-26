<?php
class Post
{
    private $conn;
    private $table = 'quotes';

    public $id;
    public $quote;
    public $author_id;
    public $category_id;
    public $category;
    public $category_name;
    public $author_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Posts
    public function read()
    {
        $query = 'SELECT
                c.category as category,
                c.category as category_name,
                a.author as author,
                a.author as author_name,
                q.id,
                q.quote,
                q.quote as title,
                q.quote as body,
                q.author_id,
                q.category_id
            FROM
                ' . $this->table . ' q
            LEFT JOIN
                authors a ON q.author_id = a.id
            LEFT JOIN
                categories c ON q.category_id = c.id
            ORDER BY
                q.id DESC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get Single Post
    public function read_single()
    {
        $query = 'SELECT
                c.category as category,
                c.category as category_name,
                a.author as author,
                a.author as author_name,
                q.id,
                q.quote,
                q.quote as title,
                q.quote as body,
                q.author_id,
                q.category_id
            FROM
                ' . $this->table . ' q
            LEFT JOIN
                authors a ON q.author_id = a.id
            LEFT JOIN
                categories c ON q.category_id = c.id
            WHERE
                q.id = ?
            LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a row exists before assigning
        if ($row) {
            $this->quote = $row['quote'];
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->author_name = $row['author_name'];
            $this->author_id = $row['author_id'];
            $this->category_id = $row['category_id'];
            $this->category = $row['category'];
            $this->category_name = $row['category_name'];
        }
    }

    // Create Post
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' (quote, author_id, category_id)
                  VALUES (:quote, :author_id, :category_id)';

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->errorInfo()[2]);
        return false;
    }

    // Update Post
    public function update()
    {
        $query = 'UPDATE ' . $this->table . '
                  SET quote = :quote, author_id = :author_id, category_id = :category_id
                  WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->errorInfo()[2]);
        return false;
    }

    // Delete Post
    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->errorInfo()[2]);
        return false;
    }
}