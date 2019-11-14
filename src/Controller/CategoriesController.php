<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function index()
    {

        $repository=$this->getDoctrine()->getRepository(Categorie::class);
        //Je fais un select*
        $categories= $repository->findAll();


        return $this->render('categories/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/categories/ajouter",name="categorie_ajouter")
     */
    public function ajouter(Request $request)/* request --> http Foundation*/{
        $categorie=new Categorie()
;

    //créer le formulaire
        //
        $formulaire=$this->createForm(CategorieType::class,$categorie);
    //Récupérer les données du POST
        $formulaire->handleRequest($request);

        if($formulaire->isSubmitted() && $formulaire->isValid()){
            //Récupération de l'entity manager
            $em=$this->getDoctrine()->getManager();

            //je dis au manager de garder cet objet en BDD
            $em->persist($categorie);
            //execute l'insert
            $em->flush();

            //je m'en vais

            return $this->redirectToRoute("categories");
        }

        return $this-> render('categories/formulaire.html.twig',[
            "formulaire"=>$formulaire->createView()
            ,"h1"=>"Ajouter une categorie"
        ]);

    }

    /**
     * @Route("/categories/modifier/{id}",name="categorie_modifier")
     */
    public function modifier(Request $request, $id)/* request --> http Foundation*/{
        //Je vais chercher l'objet à modifier
        $repository=$this->getDoctrine()->getRepository(Categorie::class);
        $categorie=$repository->find($id);

        //créer le formulaire
        //
        $formulaire=$this->createForm(CategorieType::class,$categorie);
        //Récupérer les données du POST
        $formulaire->handleRequest($request);

        if($formulaire->isSubmitted() && $formulaire->isValid()){
            //Récupération de l'entity manager
            $em=$this->getDoctrine()->getManager();

            //je dis au manager de garder cet objet en BDD
            $em->persist($categorie);
            //execute l'insert
            $em->flush();

            //je m'en vais

            return $this->redirectToRoute("categories");
        }

        return $this-> render('categories/formulaire.html.twig',[
            "formulaire"=>$formulaire->createView()
            ,"h1"=>"Modifier une categorie".$categorie->getTitre()
        ]);

    }


}
