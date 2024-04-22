<?php

namespace dao;

use EventInterfaceDao;
use model\Event;
use PDO;
use PDOException;
use util\DbConnection;

require "util/DbConnection.php";
require "interfaceDao/EventInterfaceDao.php";

class Eventdao implements EventInterfaceDao
{

    private PDO $con;

    public function __construct()
    {
        $this->con = DbConnection::getInstance()->getConnection();
    }

    public function getAllEvents()
    {

        try {
            $sql = "SELECT * FROM event";
            $stmt = $this->con->prepare($sql);
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (isset($events)) {
                return $events;
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return null;
    }

    public function getEventById(int $id)
    {
        $sql = "SELECT * FROM event WHERE id = :id";

        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $eventData = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return null;
    }

    public function insertEvent(Event $event): bool
    {
        $name = $event->getName();
        $date = $event->getDate();
        $site = $event->getSite();
        $description = $event->getDescription();

        try {
            $sql = "INSERT INTO event (name, date, site, description) values (:name, :date, :site, :description)";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":date", $date);
            $stmt->bindParam(":site", $site);
            $stmt->bindParam(":description", $description);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public function updateEvent(Event $event): bool
    {
        $name = $event->getName();
        $date = $event->getDate();
        $site = $event->getSite();
        $description = $event->getDescription();
        $id = $event->getId();

        $sql = "UPDATE event SET name = :name, date = :date, site = :site, description = :description WHERE id = :id";
        $stmt = $this->con->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':site', $site);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public function deleteEvent(int $id): bool
    {
        $sql = "DELETE FROM event WHERE id = :id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id', $id);

        try {
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return false;
    }



}