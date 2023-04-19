<?php

namespace App\Models;

class Comment
{
    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $text;

    /**
     * Comment constructor.
     *
     * @param string $name
     * @param string $email
     * @param string $title
     * @param string $text
     */
    public function __construct(
        string $name,
        string $email,
        string $title,
        string $text
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->title = $title;
        $this->text = $text;
    }

    /**
     * Returns all comments from the database.
     *
     * @return array
     * @throws \PDOException
     */
    public static function all(): array
    {
        $pdo = (new Database())->getInstance()->getConnection();
        try {
            $stmt = $pdo->query('SELECT * FROM comments ORDER BY created_at DESC');
        } catch (\PDOException $e) {
            if (str_contains($e->getMessage(), 'no such table: comments')) die('No such table `comments`. <br>  From project dir execute: <pre><code>php .\database\migrate.php up</code></pre>');
            throw new \PDOException($e);
        }
        return $stmt->fetchAll($pdo::FETCH_ASSOC);
    }

    /**
     * Saves the comment to the database.
     *
     * @return array last comment
     * @throws \InvalidArgumentException if the comment is invalid.
     */
    public function save(): array
    {
        $this->validate();
        $db = new Database();
        $pdo = $db->getConnection();
        $stmt = $pdo->prepare('INSERT INTO comments (name, email, title, text) VALUES (:name, :email, :title, :text)');
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':text', $this->text);
        $stmt->execute();

        $id = $pdo->lastInsertId();
        $stmt = $pdo->prepare('SELECT * FROM comments WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch($pdo::FETCH_ASSOC);
    }

    /**
     * Validates the comment.
     *
     * @return bool
     * @throws \InvalidArgumentException if the comment is invalid.
     */
    public function validate(): bool
    {
        $errors = [];

        if (empty($this->name)) {
            $errors[] = 'Name is required.';
        }

        if (empty($this->email)) {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format.';
        }

        if (empty($this->title)) {
            $errors[] = 'Title is required.';
        }

        if (empty($this->text)) {
            $errors[] = 'Text is required.';
        }

        if (!empty($errors)) {
            throw new \InvalidArgumentException(implode(' ', $errors));
        }

        return true;
    }
}
