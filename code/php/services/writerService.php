<?php

include_once('../../model/writer.php');
include_once('../../database.php');

class WriterService
{
    private $conn;

    function __construct()
    {
        $db = new DB();
        $this->conn = $db->getConnection();
    }

    function getAll()
    {
        $query = "SELECT * FROM writers";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->get_result()->fetch_all();
    }

    function getById($id)
    {
        $query = "SELECT * FROM `writers` WHERE `id` like ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    function create(WriterModel $writer)
    {
        $query = "INSERT INTO `writers`(`firstName`, `lastName`, `bornIn`, `bornAt`, `died`) VALUES (?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);

        $writer->firstName = htmlspecialchars(strip_tags($writer->firstName));
        $writer->lastName = htmlspecialchars(strip_tags($writer->lastName));
        $writer->bornIn = htmlspecialchars(strip_tags($writer->bornIn));

        $stmt->bind_param("sssii", $writer->firstName, $writer->lastName, $writer->bornIn, $writer->bornAt, $writer->died);

        $stmt->execute();
        return $stmt->get_result();
    }

    function modify(WriterModel $writer)
    {
        $query = "UPDATE `writers` SET `firstName`= ?,`lastName`= ?,`bornIn`= ?, `bornAt`= ?, `died` = ? WHERE `id` = ?";
        $stmt = $this->conn->prepare($query);

        $writer->firstName = htmlspecialchars(strip_tags($writer->firstName));
        $writer->lastName = htmlspecialchars(strip_tags($writer->lastName));
        $writer->bornIn = htmlspecialchars(strip_tags($writer->bornIn));

        $stmt->bind_param("sssiii", $writer->firstName, $writer->lastName, $writer->bornIn, $writer->bornAt, $writer->died, $writer->id);

        $stmt->execute();
        if ($stmt->affected_rows == 0) return false;
        return true;
    }

    function delete($id)
    {
        $query = "DELETE FROM `writers` WHERE `id` = ?;";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("i", $id);

        $stmt->execute();
        return $stmt->get_result();
    }

    function idExists($id)
    {
        $query = "SELECT * FROM `writers` WHERE `id` like ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows == 0) return false;
        return true;
    }
}
