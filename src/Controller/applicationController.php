<?php

namespace App\Controller;

use App\Entity\Applications;
use App\Entity\ApplicationFile;
use App\Form\ApplicationsType;
use App\Form\EditApplicationsType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ApplicationsRepository;
use App\Repository\ApplicationFileRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\ArrayCollection;


#[Route('/applications')]
class applicationController extends AbstractController
{

    #[Route('/', name: 'app_index', methods: ['GET', 'POST'])]
    public function index(Request $request, ApplicationsRepository $applicationsRepository,  ApplicationFileRepository $applicationFileRepository): Response
    {
        $app = new ArrayCollection($applicationsRepository->allApplication());
        $files = new ArrayCollection($applicationFileRepository->allFiles());
        
        $newApp = $app->map(function ($row) use ($files) {
            
            $fl = $files->filter(function($el) use ($row) {
                if ($el["name_file_id"] == $row["id"]) {
                    return $el;
                };                
            });

            $row['name_file'] = $fl->map(function($el) {
                return $el["name"];
            })->getValues();
            return $row;
            
        });
        
                                
        if(!$request->isXmlHttpRequest()) {

            return $this->render('applications/index.html.twig', [
                'applications' => $newApp->getValues(),                
            ]);       

        } else {
                      

            return $this->json(['message' => 'ups']);

        }
    }

    #[Route('/new', name: 'app_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
                
        $application = new Applications();
                
        $form = $this->createForm(ApplicationsType::class, $application);               
        $form->handleRequest($request);         
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $pictures = $form->get('application_file')->getData();

            $saveElement = $doctrine->getManager();
            if (count($pictures) != 0) {
                for ($i = 0; $i < count($pictures); $i++) { 

                    $name =  $pictures[$i]->getClientOriginalName();
                    
                    $applicationFile = new ApplicationFile();
                    $fl = $applicationFile->setName($name);
                    $application->addApplicationFile($fl);
                    $saveElement->persist($applicationFile);
                                       
                    try {
                        $pictures[$i]->move($this->getParameter('pictures_directory'), $name);
                    } catch (FileException $e) {
                        return $this->json(['message' => 'Что - то пошло не так: ' . $e->getMessage()]);
                    }
                }
            }           

            $application->setStatus('Новое');
            $saveElement->persist($application);
            $saveElement->flush();            

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('applications/new.html.twig', [
            'application' => $application,
            'form' => $form,            
        ]);
    }

    #[Route('/{id}', name: 'app_show', methods: ['GET'])]
    public function show(Applications $applications, ApplicationFileRepository $applicationFileRepository): Response
    {    
        $files = $applicationFileRepository->findBy(array('name_file' => $applications->getId()));
        
        return $this->render('applications/show.html.twig', [
            'application' => $applications,
            'file' => $files,            
        ]);
    }

    #[Route('/{id}/edit', name: 'app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, 
                        Applications $application, 
                        ApplicationsRepository $applicationsRepository, 
                        ApplicationFileRepository $applicationFileRepository, 
                        ManagerRegistry $managerRegistry, Filesystem $fs): Response
    {
        
        $files = $applicationFileRepository->findBy(array('name_file' => $application->getId()));
        
        $form = $this->createForm(EditApplicationsType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Отдельно от формы забираем checkbox элементы и обрабатываем их
            $arrPOST = new ArrayCollection($request->request->all());
            
            if ($arrPOST->containsKey("edit_applications")) {
                $arrPOST->remove("edit_applications");                
            }            
            if (count($arrPOST) > 0) {
                foreach ($arrPOST as $key => $name) {                    
                    $delFile = $applicationFileRepository->find($key);
                    $applicationFileRepository->remove($delFile, true);
                                        
                    try {
                        $fs->remove($this->getParameter('pictures_directory') . $name);
                    } catch (FileException $e) {
                        return $this->json(['message' => 'Файл не существует: ' . $e->getMessage()]);
                    }
                };
            }
            //====================================================================
                       
            $addFiles = $form->get('application_file')->getData();
            $addNewFile = $managerRegistry->getManager();            
            if ( count($addFiles) != 0 ) {
                foreach ($addFiles as $objFile) {                    
                    $fileName = $objFile->getClientOriginalName();                 

                    $appFile = new ApplicationFile();
                    $newFile = $appFile->setName($fileName);
                    $application->addApplicationFile($newFile);
                    $addNewFile->persist($application);

                    try {
                        $objFile->move($this->getParameter('pictures_directory'), $fileName);
                    } catch (FileException $err) {
                        return $this->json(['message' => 'Файлы не загрузились: ' . $err->getMessage()]);

                    };
                }
            }
            
            $applicationsRepository->save ($application, true);
            $addNewFile->flush();

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('applications/edit.html.twig', [
            'application' => $application,
            'file' => $files,
            'formedit' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_delete', methods: ['POST'])]
    public function delete(Request $request, 
                            Applications $application, 
                            ApplicationsRepository $applicationsRepository, 
                            ApplicationFileRepository $applicationFileRepository, 
                            Filesystem $fs): Response
    {
        if ($this->isCsrfTokenValid('delete'.$application->getId(), $request->request->get('_token'))) {

            $delRowFile = $applicationFileRepository->findBy(array('name_file' => $application->getId()));
            if (count($delRowFile) > 0) {
                $applicationFileRepository->removeArray($delRowFile, true);
                foreach ($delRowFile as $file) {                    
                    $fs->remove($this->getParameter('pictures_directory') . $file->getName());                    
                }
                $applicationsRepository->remove($application, true);
            } else {
                $applicationsRepository->remove($application, true);
            }
        }
        
        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/api', name: 'api_time', methods: ['POST'])]
    public function time(Request $request, ApplicationsRepository $applicationsRepository): JsonResponse 
    {         
        $expired = function ( string $time, string $color ) use ($applicationsRepository): array {
            $expiredApplication = array ();
            foreach ($applicationsRepository->timeApp() as $data) {
                
                $timeApplication = $data['created_at']; 
                $timeNow = new \DateTime('now'); 
                $timeApplication->add(new \DateInterval($time));                
                
                if ($timeNow > $timeApplication) {                     
                    $expiredApplication += ["{$data['id']}" => $color];
                }

            };

            return $expiredApplication;
        };
        
        if($request->isXmlHttpRequest()) { 
            
            return $this->json($expired('PT1H', '#FA8072'));            

        } else {

            return $this->json(['message' => 'ups']);
            
        }
    }
}