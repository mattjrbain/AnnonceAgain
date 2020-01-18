<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Rubrique;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonces/rubrique/{id}", name="annonce_rubrique")
     * @param Rubrique $rubrique
     * @return Response
     */
    public function getByRubrique(Rubrique $rubrique)
    {
//        $rubrique = $this->getDoctrine()->getRepository(Rubrique::class)->find($id);
        $annonces = $this->getDoctrine()->getRepository(Annonce::class)->findBy(['rubrique' => $rubrique]);
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
            'rubrique' => $rubrique
        ]);
    }

    /**
     * @Route("/annonce/{id}", name="annonce")
     * @param Annonce $annonce
     * @return Response
     */
    public function getOne(Annonce $annonce)
    {
        return $this->render('annonce/annonce.html.twig', [
            'annonce' => $annonce,
        ]);

    }
}
