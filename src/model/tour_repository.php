<?php

namespace Mototour\Model;

use Mysqli;
use Mototour\Util\Config;

class TourRepository
{
    private $conn;

    function __construct()
    {
        $this->conn = new mysqli(Config::$servername, Config::$username, Config::$password, Config::$dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function findTours()
    {
        return $this->conn->query("SELECT id, name, photo FROM tour");
    }

    public function findTourById($id)
    {
        $stmt = $this->conn->prepare("SELECT id, name, description, photo FROM tour WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($id, $name, $description, $photo);
        if ($stmt->fetch()) {
            $result = array('id' => $id, 'name' => $name, 'description' => $description, 'photo' => $photo);
        } else {
            $result = false;
        }
        $stmt->close();

        return $result;
    }

    function __destruct()
    {
        $this->conn->close();
    }
}