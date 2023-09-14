<?php

namespace App\Controller;

use App\Form\NewGoodType;
use App\Service\GoodService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "/good")]
class GoodController extends AbstractController
{
    public function __construct(private readonly GoodService $goodService)
    {
    }

    #[Route(path: "/one/{id}", name: "good_one", methods: "GET")]
    public function get(int $id): Response
    {
        $good = $this->goodService->get($id);
        return $this->render('good/one.html.twig', ['good' => $good]);
    }

    #[Route(path: "/create", name: "good_create")]
    public function create(Request $request): Response
    {
        $form = $this->createForm(NewGoodType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dto = $form->getData();
            $this->goodService->create($dto);

            return $this->render('good/create.html.twig', ['form' => $form]);
        }

        return $this->render('good/create.html.twig', ['form' => $form]);
    }
}
