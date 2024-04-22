<?php

namespace controller;

use dao\Participationdao;
use model\Participation;
use view\vista;

require "dao/Participationdao.php";
require "model/Participation.php";

class ParticipationController
{

    private Participationdao $parDao;
    private Vista $view;

    public function __construct(){
        $this->parDao = new Participationdao();
        $this->view = new Vista();
    }

    public function participationsGet()
    {
        $participation = $this->parDao->getAllParticipation();
        $this->view->showResponse($participation, 'participation', 'found');
    }

    public function participationGet($id)
    {
        $participation = $this->parDao->getparticipationById($id);
        $this->view->showResponse($participation, 'participation', 'found');
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
        $this->view->showResponse($insertedParticipation, 'participation', 'inserted');
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
        $this->view->showResponse($updatedParticipation, 'participation', 'updated');
    }


    public function deleteParticipationDelete($id)
    {
        $deletedPart = $this->parDao->deleteParticipation($id);
        $this->view->showResponse($deletedPart, 'participation', 'deleted');
    }

    public function threeFildPerTableGet($id)
    {
        $info = $this->parDao->getparticipationDetailsById($id);
        $this->view->showResponse($info, 'participation', 'found');
    }
}