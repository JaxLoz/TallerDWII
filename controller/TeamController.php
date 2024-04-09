<?php

namespace controller;

use dao\Teamdao;
use model\Team;

require "dao/Teamdao.php";
require "model/Team.php";

class TeamController
{

    private Teamdao $teamDao;

    public function __construct(){
        $this->teamDao = new Teamdao();
    }

    public function teamsGet()
    {
        $teams = $this->teamDao->getAllTeams();

        if($teams == null){
            $response = [
                "status code" => 404,
                "message" => "No teams found"
            ];
            http_response_code(404);
        }else{
            $response = [
                "status code" => 200,
                "message" => "Teams found",
                "teams" => $teams
            ];
            http_response_code(200);
        }
        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function teamGet($id)
    {
        $team = $this->teamDao->getTeamById($id);

        if(!isset($team)){
            $response = [
                "status code" => 404,
                "message" => "No team found"
            ];
            http_response_code(404);
        }else{
            $response = [
                "status code" => 200,
                "message" => "Team found",
                "team" => $team
            ];
            http_response_code(200);
        }

        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function insertTeamPost(){
        $infoTeam = json_decode(file_get_contents("php://input"),true);
        $team = new Team();
        $team->setName($infoTeam["name"]);
        $team->setCountry($infoTeam["country"]);
        $team->setCity($infoTeam["city"]);
        $team->setYearCreation($infoTeam["year_creation"]);

        $insertedTeam = $this->teamDao->insertTeam($team);

        if($insertedTeam == null){
            $response = [
                "status code" => 400,
                "message" => "Error in insert team"
            ];
            http_response_code(400);
        }else{
            $response = [
                "status code" => 201,
                "message" => "Team inserted",
                "id" => $insertedTeam
            ];
            http_response_code(201);
        }
        header("Content-Type: application/json");
        echo json_encode($response);
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

        if(!$updatedTeam){
            $response = [
                "status code" => 400,
                "message" => "Error in update team"
            ];
            http_response_code(400);
        }else{
            $response = [
                "status code" => 200,
                "message" => "Team updated"
            ];
            http_response_code(200);
        }
        header("Content-Type: application/json");
        echo json_encode($response);

    }

    public function deleteTeamDelete($id)
    {
        $deletedTeam = $this->teamDao->deleteTeam($id);

        if(!$deletedTeam){
            $response = [
                "status code" => 404,
                "message" => "No team found"
            ];
            http_response_code(404);
        }else{
            $response = [
                "status code" => 200,
                "message" => "Team deleted",
            ];
            http_response_code(200);
        }
        header("Content-Type: application/json");
        echo json_encode($response);
    }

}