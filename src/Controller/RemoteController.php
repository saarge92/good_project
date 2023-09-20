<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\RemoteFormType;
use App\Service\GoodLoaderRemoteServiceInterface as RemoteLoaderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RemoteController extends AbstractController
{
    public function __construct(private readonly RemoteLoaderService $loaderService){}

    #[Route(path: 'remote/parse', name: 'remote_good_parse')]
    public function parseFromURL(Request $request): Response
    {
        $form = $this->createForm(RemoteFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $good = $this->loaderService->loadAndSave($data['url']);

            return $this->redirectToRoute('good_one', ['id' => $good->getId()]);
        }

        return $this->render('good/good-remote-create.html.twig', ['form' => $form->createView()]);
    }
}