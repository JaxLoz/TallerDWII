<?php

use model\Participation;

interface ParticipationDaoInterface{

    public function getAllParticipation();

    public function getParticipationById(int $id);

    public function insertParticipation(Participation $participation): bool;

    public function updateParticipation(Participation $participation): bool;

    public function deleteParticipation(int $id): bool;

}
