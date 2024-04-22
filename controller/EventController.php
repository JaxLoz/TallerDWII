<?php

namespace controller;

use Couchbase\View;
use dao\Eventdao;
use model\Event;
use view\vista;

require "dao/Eventdao.php";
require "model/Event.php";
require "view/Vista.php";

class EventController
{
    private Eventdao $eventDao;
    private Vista $view;

    public function __construct(){
        $this->eventDao = new Eventdao();
        $this->view = new Vista();
    }

    public function eventsGet()
    {
        $events = $this->eventDao->getAllEvents();
        $this->view->showResponse($events, "event", "found");
    }

    public function eventGet($id)
    {
        $event = $this->eventDao->getEventById($id);
        $this->view->showResponse($event, "event", "found");
    }

    public function insertEventPost(){
        $infoEvent = json_decode(file_get_contents("php://input"),true);
        $event = new Event();
        $event->setName($infoEvent["name"]);
        $event->setDate($infoEvent["date"]);
        $event->setSite($infoEvent["site"]);
        $event->setDescription($infoEvent["description"]);

        $insertedEvent = $this->eventDao->insertEvent($event);
        $this->view->showResponse($insertedEvent, 'event', 'inserted');

    }

    public function updateEventPut($id)
    {
        $data = json_decode(file_get_contents("php://input"),true);

        $event = new Event();
        $event->setId($id);
        $event->setName($data["name"]);
        $event->setDate($data["date"]);
        $event->setSite($data["site"]);
        $event->setDescription($data["description"]);


        $updatedEvent = $this->eventDao->updateEvent($event);
        $this->view->showResponse($updatedEvent, 'event', 'updated');
    }

    public function deleteEventDelete($id)
    {
        $events = $this->eventDao->deleteEvent($id);
        $this->view->showResponse($events, 'event', 'deleted');
    }

}