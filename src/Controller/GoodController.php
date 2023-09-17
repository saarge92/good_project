<?php

namespace App\Controller;

use App\DTO\GoodForUpdate;
use App\Form\UpdateGoodType;
use App\Form\NewGoodType;
use App\Service\GoodService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function one(int $id): Response
    {
        $good = $this->goodService->one($id);
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

            return $this->redirectToRoute('goods_list');
        }

        return $this->render('good/create.html.twig', ['form' => $form]);
    }

    #[Route(path: "/update/{id}", name: "good_update")]
    public function update(Request $request, int $id): Response
    {
        $good = $this->goodService->one($id);
        $form = $this->createForm(UpdateGoodType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $listData = $form->getData();

            $this->goodService->update(new GoodForUpdate(
                $id,
                $listData['name'],
                $listData['price'],
                $listData['photo'],
                $listData['description']
            ));

            return $this->redirectToRoute('good_one', ['id' => $id]);
        }

        return $this->render('good/update.html.twig', ['form' => $form, 'good' => $good]);
    }

    #[Route(path: "/list", name: 'goods_list', methods: "GET")]
    public function list(): Response
    {
        $goods = $this->goodService->list();
        return $this->render('good/list.html.twig', ['goods' => $goods]);
    }

    #[Route(path: '/delete/{id}', name: "good_delete", methods: "DELETE")]
    public function delete(int $id): Response
    {
        $this->goodService->delete($id);

        return $this->json(['message' => 'Ok'], Response::HTTP_OK);
    }
}
