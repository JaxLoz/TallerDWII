<?php

namespace model;

class Team
{

    private int $id;
    private string $name;
    private string $country;
    private string $city;
    private int  $yearCreation;

    public function __construct()
    {
        $this->id = 0;
        $this->name = "";
        $this->country = "";
        $this->city = "";
        $this->yearCreation = 0;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getYearCreation(): int
    {
        return $this->yearCreation;
    }

    public function setYearCreation(int $yearCreation): void
    {
        $this->yearCreation = $yearCreation;
    }

}