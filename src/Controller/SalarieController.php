<?php

namespace App\Controller;

use App\Entity\Salarie;
use App\Entity\Entreprise;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager as PersistenceObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SalarieController extends AbstractController
{

    /**
     * @Route("/delete", name="salarie_delete")
     * @Route("/{id}/delete", name="salarie_delete")
     */
    public function deleteSalarie(Salarie $salarie = null, Request $request, EntityManagerInterface $manager)
    {
        $manager->remove($salarie);
        $manager->flush();
        return $this->redirectToRoute('salarie');
    }

    /**
     * @Route("/add", name="salarie_add")
     * @Route("/{id}/edit", name="salarie_edit")
     */
    public function addSalarie(Salarie $salarie = null, Request $request, EntityManagerInterface $manager)
    {

        if (!$salarie) {
            $salarie = new Salarie();
        }

        $form = $this->createFormBuilder($salarie)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('datenaissance', DateType::class, [
                'years' => range(date('Y'), date('Y') - 70),
                'label' => 'Date de naissance',
                'format' => 'ddMMMMyyyy'
            ])
            ->add('adresse', TextType::class)
            ->add('cp', TextType::class)
            ->add('ville', TextType::class)
            ->add('dateEmbauche', DateType::class, [
                'years' => range(date('Y'), date('Y') - 70),
                'label' => 'Date d\' embauche',
                'format' => 'ddMMMMyyyy'
            ])
            ->add('Entreprise', EntityType::class, [
                'class' => Entreprise::class,
                'choice_label' => 'raisonSociale',
            ])
            ->add('Valider', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($salarie);
            $manager->flush();

            return $this->redirectToRoute('salarie');
        }

        return $this->render('salarie/add_edit.html.twig', [
            'form' => $form->createView(),
            'editMode' => $salarie->getId() !== null
        ]);
    }

    /**
     * @Route("/salarie", name="salarie")
     */
    public function index()
    {
        $salaries = $this->getDoctrine()
            ->getRepository(Salarie::class)
            ->getAll();

        return $this->render('salarie/index.html.twig', [
            'salaries' => $salaries,
        ]);
    }

    /**
     * @Route("/{id}", name="salarie_show", methods = "GET")
     */
    public function show(Salarie $salarie): Response
    {
        return $this->render('salarie/show.html.twig', ['salarie' => $salarie]);
    }
}
