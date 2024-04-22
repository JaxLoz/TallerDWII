<?php

namespace interfaceDao;
interface AthleteDaoInterface
{
    public function getAll();

    public function getById(int $id);

    public function insertInformation($model);

    public function updateInformation($model): bool;

    public function deleteInformation(int $id): bool;

}
