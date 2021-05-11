<?php

namespace App\Controller;

use App\Entity\Entreprise;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class EntrepriseController extends AbstractController
{

    // /**
    //  * @Route("/add", name="entreprise_add")
    //  * @Route("/{id}/edit", name="entreprise_edit")
    //  */
    // public function addEntreprise(Entreprise $entreprise = null, Request $request, EntityManagerInterface $manager)
    // {

    //     if (!$entreprise) {
    //         $entreprise = new Entreprise();
    //     }

    //     $form = $this->createFormBuilder($entreprise)
    //         ->add('raisonSociale', TextType::class)
    //         ->add('siret', TextType::class)
    //         ->add('adresse', TextType::class)
    //         ->add('cp', TextType::class)
    //         ->add('ville', TextType::class)
    //         ->add('Valider', SubmitType::class)
    //         ->getForm();

    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {

    //         $manager->persist($entreprise);
    //         $manager->flush();

    //         return $this->redirectToRoute('entreprise');
    //     }

    //     return $this->render('entreprise/add_edit.html.twig', [
    //         'form' => $form->createView(),
    //         'editMode' => $entreprise->getId() !== null
    //     ]);
    // }

    /**
     * @Route("/entreprise", name="entreprise")
     */
    public function index()
    {
        $entreprises = $this->getDoctrine()
            ->getRepository(Entreprise::class)
            ->getAll();

        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entreprises,
        ]);
    }

    // /**
    //  * @Route("/{id}", name="entreprise_show", methods = "GET")
    //  */
    // public function show(Entreprise $entreprise): Response
    // {
    //     return $this->render('entreprise/show.html.twig', ['entreprise' => $entreprise]);
    // }
}
