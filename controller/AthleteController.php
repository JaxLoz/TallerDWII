<?php

namespace controller;

use dao\Athletedao;
use model\Athlete;

require "dao/Athletedao.php";
require "model/Athlete.php";

class AthleteController
{

    private Athletedao $athletedao;

    public function __construct(){
        $this->athletedao = new Athletedao();
    }

    public function athletesGet()
    {
        $athlete = $this->athletedao->getAllAthletes();

        if($athlete == null){
            $response = [
                "status code" => 404,
                "message" => "No athlete found"
            ];
            http_response_code(404);
        }else{
            $response = [
                "status code" => 200,
                "message" => "Athlete found",
                "athletes" => $athlete
            ];
            http_response_code(200);
        }
        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function athleteGet($id)
    {
        $athlete = $this->athletedao->getAthleteById($id);

        if(!isset($athlete)){
            $response = [
                "status code" => 404,
                "message" => "No athlete found"
            ];
            http_response_code(404);
        }else{
            $response = [
                "status code" => 200,
                "message" => "Athlete found",
                "athlete" => $athlete
            ];
            http_response_code(200);
        }

        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function insertAthletePost(){
        $infoAthlete = json_decode(file_get_contents("php://input"),true);
        $Athlete = new Athlete();
        $Athlete->setFirstname($infoAthlete["firstname"]);
        $Athlete->setLastname($infoAthlete["lastname"]);
        $Athlete->setAge($infoAthlete["age"]);
        $Athlete->setGender($infoAthlete["gender"]);
        $Athlete->setCountry($infoAthlete["country"]);

        $insertedAthlete = $this->athletedao->createAthlete($Athlete);

        if($insertedAthlete == null){
            $response = [
                "status code" => 400,
                "message" => "Error in insert athlete"
            ];
            http_response_code(400);
        }else{
            $response = [
                "status code" => 201,
                "message" => "Athlete inserted",
                "id" => $insertedAthlete
            ];
            http_response_code(201);
        }
        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function updateAthletePut($id)
    {
        $data = json_decode(file_get_contents("php://input"),true);

        $Athlete = new Athlete();
        $Athlete->setFirstname($data["firstname"]);
        $Athlete->setLastname($data["lastname"]);
        $Athlete->setAge($data["age"]);
        $Athlete->setGender($data["gender"]);
        $Athlete->setCountry($data["country"]);
        $Athlete->setId($id);

        $updatedAthlete = $this->athletedao->updateAthlete($Athlete);

        if(!$updatedAthlete){
            $response = [
                "status code" => 400,
                "message" => "Error in update athlete"
            ];
            http_response_code(400);
        }else{
            $response = [
                "status code" => 200,
                "message" => "Athlete updated"
            ];
            http_response_code(200);
        }
        header("Content-Type: application/json");
        echo json_encode($response);

    }

    public function deleteAthleteDelete($id)
    {
        $deletedAthlete = $this->athletedao->deleteAthlete($id);

        if(!$deletedAthlete){
            $response = [
                "status code" => 404,
                "message" => "No athlete found"
            ];
            http_response_code(404);
        }else{
            $response = [
                "status code" => 200,
                "message" => "Athlete deleted",
            ];
            http_response_code(200);
        }
        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function getInfoParticipationAndAthleteGet($id)
    {
        $info = $this->athletedao->getParticipationByAthleteId($id);

        if(!isset($info)){
            $response = [
                "status code" => 404,
                "message" => "No Info found"
            ];
            http_response_code(404);
        }else{
            $response = [
                "status code" => 200,
                "message" => "Info found",
                "athlete" => $info
            ];
            http_response_code(200);
        }

        header("Content-Type: application/json");
        echo json_encode($response);
    }

}