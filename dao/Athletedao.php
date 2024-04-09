<?php

namespace dao;

use model\Athlete;
use PDO;
use PDOException;
use util\DbConnection;

class Athletedao
{

    private PDO $con;


    public function __construct(){
        $this->con = DbConnection::getInstance()->getConnection();
    }

    public function getAllAthletes()
    {
        $sql = "SELECT * FROM athlete";
        $stmt = $this->con->prepare($sql);

        try {
            $stmt->execute();
            $athleteData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(isset($athleteData)){
                return $athleteData;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();

        }

        return null;
    }

    public function getAthleteById(int $id)
    {
        $sql = "SELECT * FROM athlete WHERE id = :id";

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

    public function createAthlete(Athlete $athlete)
    {
        $sql = "INSERT INTO athlete (firstname, lastname, age, gender, country) VALUES (:firstname, :lastname, :age, :gender, :country)";
        $stmt = $this->con->prepare($sql);

        $firstName = $athlete->getFirstName();
        $lastName = $athlete->getLastName();
        $age = $athlete->getAge();
        $gender = $athlete->getGender();
        $country = $athlete->getCountry();

        $stmt->bindParam(':firstname', $firstName);
        $stmt->bindParam(':lastname', $lastName);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':country', $country);

        try {
            $stmt->execute();
            return $this->con->lastInsertId();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return 0;
    }

    public function updateAthlete(Athlete $athlete): bool
    {
        $sql = "UPDATE athlete SET firstname = :firstname, lastname = :lastname, age = :age, gender = :gender, country = :country WHERE id = :id";
        $stmt = $this->con->prepare($sql);

        $firstName = $athlete->getFirstName();
        $lastName = $athlete->getLastName();
        $age = $athlete->getAge();
        $gender = $athlete->getGender();
        $country = $athlete->getCountry();
        $id = $athlete->getId();

        $stmt->bindParam(':firstname', $firstName);
        $stmt->bindParam(':lastname', $lastName);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':country', $country);
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

    public function deleteAthlete(int $id): bool
    {
        $sql = "DELETE FROM athlete WHERE id = :id";
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

    public function getParticipationByAthleteId($id)
    {
        $sql = "SELECT
    participation.id AS participation_id,
    participation.status AS participation_status,
    participation.result AS participation_result,
    athlete.firstname AS athlete_firstname,
    athlete.lastname AS athlete_lastname,
    athlete.country AS athlete_country
FROM participation
INNER JOIN athlete ON participation.id_athlete = athlete.id
WHERE athlete.id = :athlete_id;";

        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':athlete_id', $id);

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


}