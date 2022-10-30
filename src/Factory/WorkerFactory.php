<?php

namespace App\Factory;

use App\DTO\WorkerCsvDTO;
use App\Entity\Worker;

class WorkerFactory
{

    public function createWorkerByName(string $name): Worker
    {
        $worker = new Worker();
        $worker->setName($name);
        return $worker;
    }
}