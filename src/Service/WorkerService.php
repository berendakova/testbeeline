<?php

namespace App\Service;

use App\DTO\WorkerCsvDTO;
use App\Entity\Worker;
use App\Exception\NotFoundWorkerException;
use App\Factory\WorkerFactory;
use App\Repository\WorkerRepository;
use Doctrine\ORM\EntityManagerInterface;

class WorkerService
{
    private EntityManagerInterface $em;
    private WorkerFactory $factory;
    public function __construct(EntityManagerInterface $em, WorkerFactory $factory)
    {
        $this->em = $em;
        $this->factory = $factory;
    }

    /**
     * @param WorkerCsvDTO[] $data
     */
    public function createFromCSV(array $data): void
    {
        foreach ($data as $datum){
            $boss = null;
            $bossName = $datum->getBossName();
            if($bossName) {
                $boss = $this->getWorkerByName($bossName);
                if(!$boss) {
                    $boss = $this->factory->createWorkerByName($bossName);
                }
                $this->em->persist($boss);
            }
            $worker = $this->factory->createWorkerByName($datum->getName());
            $this->populateWithBoss($worker, $boss);
            $this->em->persist($worker);
            $this->em->flush();
        }
    }

    public function getWorkerByName(string $name): ?Worker
    {
        return $this->em->getRepository(Worker::class)->findOneBy(['name' => $name]);
    }

    public function tryGetWorkerByName(string $name): Worker
    {
        $worker = $this->em->getRepository(Worker::class)->findOneBy(['name' => $name]);
        if(!$worker) {
            throw new NotFoundWorkerException();
        }
        return $worker;
    }

    public function populateWithBoss(Worker $worker, ?Worker $boss): void
    {
        if($boss) {
            $worker->setParent($boss);
        }
    }
}