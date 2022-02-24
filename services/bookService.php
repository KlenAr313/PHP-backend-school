<?php

include_once('../model/book.php');
include('../database.php');

class BookService
{
    private $conn;

    function __construct()
    {
        $db = new DB();
        $this->conn = $db->getConnection();
    }

    function getAll()
    {
        $query = "SELECT * FROM `books`";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->get_result()->fetch_all();
    }

    function getById($id) //should check idExists
    {
        $query = "SELECT * FROM `books` WHERE `id` like ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    function getByWrierId($id)
    {
        $query = "SELECT * FROM `books` WHERE `writerId` like ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($stmt->affected_rows == 0) return false;
        return $stmt->get_result()->fetch_all();
    }

    function create(Book $book)
    {
        $query = "INSERT INTO `books`(`title`, `category`, `publiched`, `writerId`) VALUES (?,?,?,?)";
        $stmt = $this->conn->prepare($query);

        $book->title = htmlspecialchars(strip_tags($book->title));
        $book->category = htmlspecialchars(strip_tags($book->category));

        $stmt->bind_param("ssii", $book->title, $book->category, $book->published, $book->writerId);

        $stmt->execute();
        return $stmt->get_result();
    }

    function modify(Book $book)
    {
        $query = "UPDATE `books` SET `title` = ?, `category` = ?, `publiched` = ?, `writerId`= ? WHERE `id` = ?";
        $stmt = $this->conn->prepare($query);

        $book->title = htmlspecialchars(strip_tags($book->title));
        $book->category = htmlspecialchars(strip_tags($book->category));

        $stmt->bind_param("ssiii", $book->title, $book->category, $book->published, $book->writerId, $book->id);

        $stmt->execute();
        if ($stmt->affected_rows == 0) return false;
        return true;
    }

    function delete($id) //should check idExists
    {
        $query = "DELETE FROM `books` WHERE `id = ?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("i", $id);

        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    function idExists($id)
    {
        $query = "SELECT * FROM `books` WHERE `id` like ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows == 0) return false;
        return true;
    }
}
