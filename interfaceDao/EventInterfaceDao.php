<?php

use model\Event;

interface EventInterfaceDao
{
    public function getAllEvents();

    public function getEventById(int $id);

    public function insertEvent(Event $event): bool;

    public function updateEvent(Event $event): bool;

    public function deleteEvent(int $id): bool;
}