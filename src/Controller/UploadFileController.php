<?php

namespace App\Controller;
use App\Form\BossSubordinateFileType;
use App\Repository\BossRepository;
use App\Repository\SubordinateRepository;
use App\Repository\WorkerRepository;
use App\Service\CSVHandler;
use App\Service\DataHandler;
use App\Service\WorkerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileUploader;
use Symfony\Component\Routing\Annotation\Route;

class UploadFileController extends AbstractController
{

    /**
     * @Route("/test-upload", name="app_test_upload")
     */
    public function testAction(Request $request, WorkerService $workerService,FileUploader $fileUploader, CSVHandler  $CSVHandler)
    {
        $form = $this->createForm(BossSubordinateFileType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['upload_file']->getData();
            $fullPath = $fileUploader->uploadFile($file);
            $data = $CSVHandler->read($fullPath);
            $workerService->createFromCSV($data);
        }
        return $this->render('app/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}