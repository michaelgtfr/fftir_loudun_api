<?php

namespace App\Controller;

use App\Entity\SportsShootingDisciplines;
use App\Services\CustomResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadController extends AbstractController
{
    private $customResponse;

    public function __construct(SerializerInterface $serializer)
    {
        $this->customResponse = new CustomResponse($serializer);
    }
 
    /**
     * @Route("/api/upload", methods={"POST"})
     */
    public function uploadFile(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {   
        $file = $request->files->get('file');

        if($file instanceof UploadedFile) {
            $sportShooting = new SportsShootingDisciplines();
            $sportShooting->setDiscipline('discipline un');
            $sportShooting->setPresentation('une presentation');
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $originalExtension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$originalExtension;
            
            try {
                $file->move($this->getParameter('discipline_img'), $newFilename);
            } catch(FileException $e) {
                dd($e);
            }

            $sportShooting->setDisciplinePicture($newFilename);
            $entityManager->persist($sportShooting);
            $entityManager->flush();

            return new Response();


        };
    }
}