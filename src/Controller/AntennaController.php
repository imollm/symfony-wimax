<?php

namespace App\Controller;

use App\Entity\Antenna;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Flex\Unpack\Result;

class AntennaController extends AbstractController
{
    /**
     * @Route("/antennas", name="antennas")
     */
    public function index()
    {
        $antennasRepo= $this->getDoctrine()->getRepository(Antenna::class);
        $antennas = $antennasRepo->findAll();

        return $this->render('antenna/index.html.twig', [
            'title' => 'Antennas',
            'header' => 'Listado de antenas',
            'antennas' => $antennas
        ]);
    }

    /**
     * @Route("/getImage/{file}", name="get_antenna_image")
     */
    public function getImage(Request $request)
    {
        if($request){
            $fileName = $request->attributes->get('file');
            $filePath = "assets/img/antennas/" . $fileName . ".jpg";
           
            $response = new BinaryFileResponse($filePath);
            $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_INLINE,
                $fileName
            );
            return $response;
        }   
    }
}
