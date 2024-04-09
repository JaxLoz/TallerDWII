<?php

namespace model;

class Participation
{

    private int $id;
    private string $status;
    private string $result;
    private int $idEvent;
    private int $idTeam;
    private int $idAthlete;

    public function __construct()
    {
        $this->id = 0;
        $this->status = "";
        $this->result = "";
        $this->idEvent = 0;
        $this->idTeam = 0;
        $this->idAthlete = 0;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function setResult(string $result): void
    {
        $this->result = $result;
    }

    public function getIdEvent(): int
    {
        return $this->idEvent;
    }

    public function setIdEvent(int $idEvent): void
    {
        $this->idEvent = $idEvent;
    }

    public function getIdTeam(): int
    {
        return $this->idTeam;
    }

    public function setIdTeam(int $idTeam): void
    {
        $this->idTeam = $idTeam;
    }

    public function getIdAthlete(): int
    {
        return $this->idAthlete;
    }

    public function setIdAthlete(int $idAthlete): void
    {
        $this->idAthlete = $idAthlete;
    }

}