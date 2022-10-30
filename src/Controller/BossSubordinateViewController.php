<?php

namespace App\Controller;

use App\Entity\Boss;
use App\Entity\Subordinate;
use App\Entity\Worker;
use App\Exception\NotFoundWorkerException;
use App\Form\WorkerType;
use App\Repository\BossRepository;
use App\Repository\SubordinateRepository;
use App\Repository\WorkerRepository;
use App\Service\WorkerService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BossSubordinateViewController  extends AbstractController
{
    public function __construct()
    {
    }

    /**
     * @Route("/all", name="app_all")
     */
    public function getAllPeopleAction()
    {


    }

    /**
     * @Route("/search", name="app_search")
     */
    public function searchByNameAction(Request $request, WorkerService $workerService)
    {
        /**
         * @var Worker $worker
         */
        $form = $this->createForm(WorkerType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                return $this->render('app/worker.html.twig', [
                    'worker' => $workerService->tryGetWorkerByName($form['name']->getData())
                ]);
            }catch (NotFoundWorkerException $exception) {
                $form->get('name')
                    ->addError(new FormError( 'Worker not found'));
                return $this->render('app/search.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
        }

            return $this->render('app/search.html.twig', [
                'form' => $form->createView(),
            ]);
    }
}