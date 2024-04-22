<?php

namespace dao;

use model\Team;
use PDO;
use PDOException;
use TeamInterfaceDao;
use util\DbConnection;
use view\vista;

require "interfaceDao/TeamInterfaceDao.php";


class Teamdao implements TeamInterfaceDao
{

    private PDO $con;

    public function __construct(){
        $this->con = DbConnection::getInstance()->getConnection();
    }

    public function getAllTeams()
    {
        $sql = "SELECT * FROM team";
        $stmt = $this->con->prepare($sql);

        try {
            $stmt->execute();
            $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(isset($teams)){
                return $teams;
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        return null;
    }

    public function getTeamById(int $id)
    {
        $sql = "SELECT * FROM team WHERE id = :id";

        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return null;
    }


    public function insertTeam(Team $team): bool
    {
        $name = $team->getName();
        $country = $team->getCountry();
        $city = $team->getCity();
        $yearCreation = $team->getYearCreation();

        $sql = "INSERT INTO team (name, country, city, year_creation) VALUES (:name, :country, :city, :year_creation)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':year_creation', $yearCreation);

        try {
            $stmt->execute();
            return $this->con->lastInsertId();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        return 0;
    }

    public function updateTeam(Team $team): bool
    {
        $name = $team->getName();
        $country = $team->getCountry();
        $city = $team->getCity();
        $yearCreation = $team->getYearCreation();
        $id = $team->getId();

        $sql = "UPDATE team SET name = :name, country = :country, city = :city, year_creation = :year_creation WHERE id = :id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':year_creation', $yearCreation);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();

        }
        return false;
    }


    public function deleteTeam(int $id): bool
    {
        $sql = "DELETE FROM team WHERE id = :id";
        $stmt = $this->con->prepare($sql);

        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return false;
    }

}