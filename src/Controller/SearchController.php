<?php

namespace App\Controller;

use App\Form\PropertySearchType;
use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    protected $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @Route("/", name="home")
     */
    public function dispatch()
    {
        $property = new Property();
        $form = $this->createForm(PropertySearchType::class, $property);

        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute("search_result", [
                "postcode" => $property->getPostcode(),
                "house_number" => $property->getHouseNumberOrName(),
            ]);
        }

        return $this->render('search/index.html.twig', [
            "form" => $form->createView(),
        ]);
    }
}
