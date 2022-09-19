<?php

namespace App\Controller;

use App\Entity\Applications;
use App\Form\ApplicationsType;
use App\Form\EditApplicationsType;
use App\Repository\ApplicationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;


#[Route('/applications')]
class ApplicationsController extends AbstractController
{
    #[Route('/', name: 'app_applications_index', methods: ['GET'])]
    public function index(ApplicationsRepository $applicationsRepository): Response
    { 
        return $this->render('applications/index.html.twig', [
            'applications' => $applicationsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_applications_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ApplicationsRepository $applicationsRepository): Response
    {
        $application = new Applications();
        $form = $this->createForm(ApplicationsType::class, $application);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {

            $pictures = $form->get('file_1')->getData();
            
            $arrNamePicture = array();

            if (count($pictures) != 0) {
                for ($i = 0; $i < count($pictures); $i++) {                    
                    $name =  $pictures[$i]->getClientOriginalName(); 
                    array_push($arrNamePicture, $name);                   
                    try {
                        $pictures[$i]->move($this->getParameter('pictures_directory'), $name);
                    } catch (FileException $e) {
                        return $this->json(['message' => 'Что - то пошло не так']);
                    }
                }                               
            }                        
            $applicationsRepository->add($application->setStatus('Новое'), true);
            
            if (count($arrNamePicture) == 1) {
                
                $applicationsRepository->add($application
                    ->setFile1($arrNamePicture[0]), 
                    true
                );
            }
            
            if (count($arrNamePicture) == 2) {
                
                $applicationsRepository->add($application
                    ->setFile1($arrNamePicture[0])
                    ->setFile2($arrNamePicture[1]), 
                    true
                );
            }
            
            if (count($arrNamePicture) == 3) {
                
                $applicationsRepository->add($application
                    ->setFile1($arrNamePicture[0])
                    ->setFile2($arrNamePicture[1])
                    ->setFile3($arrNamePicture[2]), 
                    true
                );
            }            
            

            return $this->redirectToRoute('app_applications_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('applications/new.html.twig', [
            'application' => $application,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_applications_show', methods: ['GET'])]
    public function show(Applications $application): Response
    {
        return $this->render('applications/show.html.twig', [
            'application' => $application,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_applications_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Applications $application, ApplicationsRepository $applicationsRepository): Response
    {
        $form = $this->createForm(EditApplicationsType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            
            
            //dd($application);
            
            $applicationsRepository->add($application, true);

            return $this->redirectToRoute('app_applications_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('applications/edit.html.twig', [
            'application' => $application,
            'formedit' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_applications_delete', methods: ['POST'])]
    public function delete(Request $request, Applications $application, ApplicationsRepository $applicationsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$application->getId(), $request->request->get('_token'))) {
            
            function del ($name) {
                if ($name != '') {
                
                    $filesystem = new Filesystem();
                    $filesystem->remove(['/var/www/symfony/mfc/public/download/' . $name]);                    
                }
            }

            del($application->getFile1());
            del($application->getFile2());
            del($application->getFile3());

            

            $applicationsRepository->remove($application, true);
        }

        return $this->redirectToRoute('app_applications_index', [], Response::HTTP_SEE_OTHER);
    }    

}
