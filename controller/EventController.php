<?php

namespace controller;

use dao\Eventdao;
use model\Event;

require "dao/Eventdao.php";
require "model/Event.php";

class EventController
{
    private Eventdao $eventDao;

    public function __construct(){
        $this->eventDao = new Eventdao();
    }

    public function eventsGet()
    {
        $events = $this->eventDao->getEvents();

        if($events == null){
            $response = [
                "status code" => 404,
                "message" => "No events found"
            ];
            http_response_code(404);
        }else{
            $response = [
                "status code" => 200,
                "message" => "Events found",
                "events" => $events
            ];
            http_response_code(200);
        }
        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function eventGet($id)
    {
        $event = $this->eventDao->getEventById($id);

        if(!isset($event)){
            $response = [
                "status code" => 404,
                "message" => "No event found"
            ];
            http_response_code(404);
        }else{
            $response = [
                "status code" => 200,
                "message" => "Event found",
                "event" => $event
            ];
            http_response_code(200);
        }

        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function insertEventPost(){
        $infoEvent = json_decode(file_get_contents("php://input"),true);
        $event = new Event();
        $event->setName($infoEvent["name"]);
        $event->setDate($infoEvent["date"]);
        $event->setSite($infoEvent["site"]);
        $event->setDescription($infoEvent["description"]);

        $insertedEvent = $this->eventDao->insertEvent($event);

        if($insertedEvent == null){
            $response = [
                "status code" => 400,
                "message" => "Error in insert event"
            ];
            http_response_code(400);
        }else{
            $response = [
                "status code" => 201,
                "message" => "Event inserted"
            ];
            http_response_code(201);
        }
        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function updateEventPost($id)
    {
        $data = json_decode(file_get_contents("php://input"),true);

        $event = new Event();
        $event->setId($id);
        $event->setName($data["name"]);
        $event->setDate($data["date"]);
        $event->setSite($data["site"]);
        $event->setDescription($data["description"]);


        $updatedEvent = $this->eventDao->updateEvent($event);

        if(!$updatedEvent){
            $response = [
                "status code" => 400,
                "message" => "Error in update event"
            ];
            http_response_code(400);
        }else{
            $response = [
                "status code" => 200,
                "message" => "Event updated"
            ];
            http_response_code(200);
        }
        header("Content-Type: application/json");
        echo json_encode($response);

    }

    public function deleteEventDelete($id)
    {
        $events = $this->eventDao->deleteEvent($id);

        if(!$events){
            $response = [
                "status code" => 404,
                "message" => "No events found"
            ];
            http_response_code(404);
        }else{
            $response = [
                "status code" => 200,
                "message" => "Events deleted",
            ];
            http_response_code(200);
        }
        header("Content-Type: application/json");
        echo json_encode($response);
    }

}