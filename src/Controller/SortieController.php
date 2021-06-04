<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Sortie;
use App\Form\SortieListType;
use App\Form\SortieType;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/sortie")
 */
class SortieController extends AbstractController
{
    /**
     * @Route("", name="sortie_index")
     */
    public function index(Request $request, EtatRepository $etatRepository): Response
    {
        $sortie = new Sortie();
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sortie = $form->getData();

            $etatCree = new Etat();
            $etatCree = $etatRepository->find(6);
            $sortie->SetEtat($etatCree);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute('sortie_index');
        }
        return $this->render('sortie/index.html.twig', [
            'form' => $form->createView()
        ]);
    }








    /**
     * @Route("all", name="sortie_all")
     */
    public function showList(Request $request, SortieRepository $sortieRepository): Response
    {
        //$sorties = null;
        $sorties = $sortieRepository->findAll();

        $sortie = new Sortie();
        $form = $this->createForm(SortieListType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $campus = $form->get('campus');
            $rechercheNom = $form->get('rechercheNom');

            if($campus || $rechercheNom){
                $sorties = $sortieRepository->findSortieByCriteria($campus, $rechercheNom);
            }
        }
        return $this->render('sortie/listSorties.html.twig', [
            'sorties' => $sorties,
            'form' => $form->createView()
        ]);
    }
}
