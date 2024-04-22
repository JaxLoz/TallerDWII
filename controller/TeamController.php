<?php

namespace controller;

use dao\Teamdao;
use model\Team;
use TeamInterfaceDao;
use view\vista;
use viewInterface;

require "dao/Teamdao.php";
require "model/Team.php";

class TeamController
{

    private TeamInterfaceDao $teamDao;
    private viewInterface $view;

    public function __construct(){
        $this->teamDao = new Teamdao();
        $this->view = new vista();
    }

    public function teamsGet()
    {
        $teams = $this->teamDao->getAllTeams();
        $this->view->showResponse($teams, 'team', 'found');
    }

    public function teamGet($id)
    {
        $team = $this->teamDao->getTeamById($id);
        $this->view->showResponse($team, 'team', 'found');
    }

    public function insertTeamPost(){
        $infoTeam = json_decode(file_get_contents("php://input"),true);
        $team = new Team();
        $team->setName($infoTeam["name"]);
        $team->setCountry($infoTeam["country"]);
        $team->setCity($infoTeam["city"]);
        $team->setYearCreation($infoTeam["year_creation"]);

        $insertedTeam = $this->teamDao->insertTeam($team);
        $this->view->showResponse($insertedTeam, 'team', 'inserted');
    }

    public function updateTeamPut($id)
    {
        $data = json_decode(file_get_contents("php://input"),true);

        $team = new Team();
        $team->setName($data["name"]);
        $team->setCountry($data["country"]);
        $team->setCity($data["city"]);
        $team->setYearCreation($data["year_creation"]);
        $team->setId($id);

        $updatedTeam = $this->teamDao->updateTeam($team);
        $this->view->showResponse($updatedTeam, 'team', 'updated');
    }

    public function deleteTeamDelete($id)
    {
        $deletedTeam = $this->teamDao->deleteTeam($id);
        $this->view->showResponse($deletedTeam, 'team', 'deleted');
    }

}