<?php

namespace dao;

use model\Athlete;
use model\Participation;
use PDO;
use PDOException;
use util\DbConnection;

class Participationdao
{
    private PDO $con;


    public function __construct(){
        $this->con = DbConnection::getInstance()->getConnection();
    }

    public function getAllParticipation()
    {
        $sql = "SELECT * FROM participation";
        $stmt = $this->con->prepare($sql);

        try {
            $stmt->execute();
            $participation = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(isset($participation)){
                return $participation;
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        return null;
    }

    public function getparticipationById(int $id)
    {
        $sql = "SELECT * FROM participation WHERE id = :id";

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

    public function insertParticipation(Participation $participation)
    {
        $status = $participation->getStatus();
        $result = $participation->getResult();
        $idEvent = $participation->getIdEvent();
        $idTeam = $participation->getIdTeam();
        $idAthlete = $participation->getIdAthlete();

        $sql = "INSERT INTO participation (status, result, id_event, id_team, id_athlete) VALUES (:status, :result, :id_event, :id_team, :id_athlete)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':result', $result);
        $stmt->bindParam(':id_event', $idEvent);
        $stmt->bindParam(':id_team', $idTeam);
        $stmt->bindParam(':id_athlete', $idAthlete);

        try {
            $stmt->execute();
            return $this->con->lastInsertId();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0;
        }
    }

    public function updateParticipation(Participation $participation): bool
    {
        $status = $participation->getStatus();
        $result = $participation->getResult();
        $idEvent = $participation->getIdEvent();
        $idTeam = $participation->getIdTeam();
        $idAthlete = $participation->getIdAthlete();
        $id = $participation->getId();

        $sql = "UPDATE participation SET status = :status, result = :result, id_event = :id_event, id_team = :id_team, id_athlete = :id_athlete WHERE id = :id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':result', $result);
        $stmt->bindParam(':id_event', $idEvent);
        $stmt->bindParam(':id_team', $idTeam);
        $stmt->bindParam(':id_athlete', $idAthlete);
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


    public function deleteParticipation(int $id): bool
    {
        $sql = "DELETE FROM participation WHERE id = :id";
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

    public function getparticipationDetailsById(int $id)
    {
        $sql = "SELECT
    event.name AS event_name,
    event.date AS event_date,
    event.site AS event_site,
    athlete.firstname AS athlete_firstname,
    athlete.lastname AS athlete_lastname,
    athlete.country AS athlete_country,
    team.name AS team_name,
    team.country AS team_country,
    team.city AS team_city,
    participation.status AS participation_status,
    participation.result AS participation_result 
    FROM participation
    INNER JOIN event ON participation.id_event = event.id
    INNER JOIN athlete ON participation.id_athlete = athlete.id
    INNER JOIN team ON participation.id_team = team.id
    WHERE participation.id = :id;";

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


}