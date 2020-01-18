<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Image;
use App\Form\AnnonceType;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/annonceCreate", name="annonce_create")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     * @throws Exception
     */
    public function createAnnonce(Request $request, EntityManagerInterface $manager)
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            if (!$annonce->getId()) {//if $article has no id which means it is not in DB
                $annonce->setCreatedAt(new DateTime());
                $annonce->setLimitDate((new DateTime())->add(new DateInterval('P'. $this->getParameter
                                                                              ('validityDays') .'D')));
                $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
                $annonce->setAuthor($this->getUser());
            }

            $uploads_directory = $this->getParameter('uploads_directory');

            $files = $request->files->get('annonce')['images'];
            dump($files, $uploads_directory, $request->files);
            foreach ($files as $file) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $image = new Image();
                $image->setSrc($this->getParameter('uploads_directory') .'/'. $filename);
                $annonce->addImage($image);
                $manager->persist($image);

                $file->move($uploads_directory, $filename);
            }
            $manager->persist($annonce);
            $manager->flush();
            return $this->redirectToRoute('annonce', ['id' => $annonce->getId()]);
        }

        return $this->render('user/createAnnonce.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
