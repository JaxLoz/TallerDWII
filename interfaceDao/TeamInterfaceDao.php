<?php

use model\Team;

interface TeamInterfaceDao{
    public function getAllTeams();

    public function getTeamById(int $id);

    public function insertTeam(Team $team): bool;

    public function updateTeam(Team $team): bool;

    public function deleteTeam(int $id): bool;
}