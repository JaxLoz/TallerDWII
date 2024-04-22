<?php

namespace controller;

use dao\Athletedao;
use interfaceDao\AthleteDaoInterface;
use model\Athlete;
use view\vista;

require "dao/Athletedao.php";
require "model/Athlete.php";

class AthleteController
{

    private AthleteDaoInterface $athletedao;
    private Vista $view;

    public function __construct(){
        $this->athletedao = new Athletedao();
        $this->view = new Vista();
    }

    public function athletesGet()
    {
        $athletes = $this->athletedao->getAll();
        $this->view->showResponse($athletes, 'Athlete', 'found');
    }

    public function athleteGet($id)
    {
        $athlete = $this->athletedao->getById($id);
        $this->view->showResponse($athlete, 'Athlete', 'found');
    }

    public function insertAthletePost(){
        $infoAthlete = json_decode(file_get_contents("php://input"),true);
        $Athlete = new Athlete();
        $Athlete->setFirstname($infoAthlete["firstname"]);
        $Athlete->setLastname($infoAthlete["lastname"]);
        $Athlete->setAge($infoAthlete["age"]);
        $Athlete->setGender($infoAthlete["gender"]);
        $Athlete->setCountry($infoAthlete["country"]);

        $insertedAthlete = $this->athletedao->insertInformation($Athlete);
        $this->view->showResponse($insertedAthlete, 'Athlete', 'inserted');
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

        $updatedAthlete = $this->athletedao->updateInformation($Athlete);
        $this->view->showResponse($updatedAthlete, 'Athlete', 'updated');
    }

    public function deleteAthleteDelete($id)
    {
        $deletedAthlete = $this->athletedao->deleteInformation($id);
        $this->view->showResponse($deletedAthlete, 'Athlete', 'deleted');
    }

    public function getInfoParticipationAndAthleteGet($id)
    {
        $info = $this->athletedao->getParticipationByAthleteId($id);
        $this->view->showResponse($info, 'Athlete', 'found');
    }

}