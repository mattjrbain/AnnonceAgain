<?php

namespace App\Controller;

use App\Repository\RubriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RubriqueController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     * @param RubriqueRepository $repository
     * @return Response
     */
    public function index(RubriqueRepository $repository)
    {
        $rubriques = $repository->findAll();
        return $this->render('rubrique/index.html.twig', [
            'rubriques' => $rubriques,
        ]);
    }
}
