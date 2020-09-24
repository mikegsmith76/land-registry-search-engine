<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class SearchResultController extends AbstractController
{
    protected $propertyRepository;

    protected $request;

    public function __construct(RequestStack $requestStack, PropertyRepository $propertyRepository)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->propertyRepository = $propertyRepository;
    }

    /**
     * @Route("/search/", name="search_result")
     */
    public function dispatch()
    {
        $postCode = $this->request->get("postcode", "");
        $houseNumber = $this->request->get("house_number", "");

        if (empty($postCode)) {
            return $this->redirectToRoute("home");
        }

        $properties = $this->propertyRepository->search($postCode, $houseNumber);

        return $this->render('search_result/index.html.twig', [
            "properties" => $properties,
        ]);
    }
}
