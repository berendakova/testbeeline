<?php

namespace App\Service;

use App\Entity\Worker;
use App\Repository\WorkerRepository;
use Doctrine\ORM\EntityManagerInterface;

class DataHandler
{
    /**
     *
     * @param array $data
     * @return void
     */
    public function saveData(array $data, EntityManagerInterface $em, WorkerRepository $workerRepository): void
    {
        //Сотрудник - Босс(null)
        foreach ($data as $datum){
            if($datum[1]) {
                $boss = $workerRepository->findOneBy(['name' => $datum[1]]);
                if(!$boss) {
                   $boss = new Worker();
                   $boss->setName($datum[1]);
                }
                $em->persist($boss);
            }
            $worker = new Worker();
            $worker->setName($datum[0]);
            if(isset($boss)) {
                $worker->setParent($boss);
            }
            $em->persist($worker);
            $em->flush();
        }
    }

}