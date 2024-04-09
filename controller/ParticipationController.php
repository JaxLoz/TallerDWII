<?php

namespace controller;

use dao\Participationdao;
use model\Participation;

require "dao/Participationdao.php";
require "model/Participation.php";

class ParticipationController
{

    private Participationdao $parDao;

    public function __construct(){
        $this->parDao = new Participationdao();
    }

    public function participationsGet()
    {
        $participation = $this->parDao->getAllParticipation();

        if($participation == null){
            $response = [
                "status code" => 404,
                "message" => "No participation found"
            ];
            http_response_code(404);
        }else{
            $response = [
                "status code" => 200,
                "message" => "Participation found",
                "participation" => $participation
            ];
            http_response_code(200);
        }
        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function participationGet($id)
    {
        $participation = $this->parDao->getparticipationById($id);

        if(!isset($participation)){
            $response = [
                "status code" => 404,
                "message" => "No participation found"
            ];
            http_response_code(404);
        }else{
            $response = [
                "status code" => 200,
                "message" => "Participation found",
                "Participation" => $participation
            ];
            http_response_code(200);
        }

        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function insertParticipationPost()
    {
        $infoParticipation = json_decode(file_get_contents("php://input"), true);
        $participation = new Participation();
        $participation->setStatus($infoParticipation["status"]);
        $participation->setResult($infoParticipation["result"]);
        $participation->setIdEvent($infoParticipation["id_event"]);
        $participation->setIdTeam($infoParticipation["id_team"]);
        $participation->setIdAthlete($infoParticipation["id_athlete"]);

        $insertedParticipation = $this->parDao->insertParticipation($participation);

        if ($insertedParticipation == null) {
            $response = [
                "status code" => 400,
                "message" => "Error in insert participation"
            ];
            http_response_code(400);
        } else {
            $response = [
                "status code" => 201,
                "message" => "Participation inserted",
                "id" => $insertedParticipation
            ];
            http_response_code(201);
        }
        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function updateParticipationPut($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $participation = new Participation();
        $participation->setStatus($data["status"]);
        $participation->setResult($data["result"]);
        $participation->setIdEvent($data["id_event"]);
        $participation->setIdTeam($data["id_team"]);
        $participation->setIdAthlete($data["id_athlete"]);
        $participation->setId($id);

        $updatedParticipation = $this->parDao->updateParticipation($participation);

        if (!$updatedParticipation) {
            $response = [
                "status code" => 400,
                "message" => "Error in update participation"
            ];
            http_response_code(400);
        } else {
            $response = [
                "status code" => 200,
                "message" => "Participation updated"
            ];
            http_response_code(200);
        }
        header("Content-Type: application/json");
        echo json_encode($response);
    }


    public function deleteParticipationDelete($id)
    {
        $deletedPart = $this->parDao->deleteParticipation($id);

        if(!$deletedPart){
            $response = [
                "status code" => 404,
                "message" => "No participation found"
            ];
            http_response_code(404);
        }else{
            $response = [
                "status code" => 200,
                "message" => "Participation deleted",
            ];
            http_response_code(200);
        }
        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function threeFildPerTableGet($id)
    {
        $info = $this->parDao->getparticipationDetailsById($id);

        if(!isset($info)){
            $response = [
                "status code" => 404,
                "message" => "No info found"
            ];
            http_response_code(404);
        }else{
            $response = [
                "status code" => 200,
                "message" => "Info found",
                "Participation" => $info
            ];
            http_response_code(200);
        }

        header("Content-Type: application/json");
        echo json_encode($response);
    }
}