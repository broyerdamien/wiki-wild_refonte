<?php

namespace App\Controller;

use App\Entity\Documentation;
use App\Form\DocumentationType;
use App\Repository\DocumentationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/documentation')]
class DocumentationController extends AbstractController
{
    #[Route('/', name: 'app_documentation_index', methods: ['GET'])]
    public function index(DocumentationRepository $documentationRepository): Response
    {
        return $this->render('documentation/index.html.twig', [
            'documentations' => $documentationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_documentation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DocumentationRepository $documentationRepository): Response
    {
        $documentation = new Documentation();
        $form = $this->createForm(DocumentationType::class, $documentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $documentationRepository->save($documentation, true);

            return $this->redirectToRoute('app_documentation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('documentation/new.html.twig', [
            'documentation' => $documentation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_documentation_show', methods: ['GET'])]
    public function show(Documentation $documentation): Response
    {
        return $this->render('documentation/show.html.twig', [
            'documentation' => $documentation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_documentation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Documentation $documentation, DocumentationRepository $documentationRepository): Response
    {
        $form = $this->createForm(DocumentationType::class, $documentation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $documentationRepository->save($documentation, true);

            return $this->redirectToRoute('app_documentation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('documentation/edit.html.twig', [
            'documentation' => $documentation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_documentation_delete', methods: ['POST'])]
    public function delete(Request $request, Documentation $documentation, DocumentationRepository $documentationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$documentation->getId(), $request->request->get('_token'))) {
            $documentationRepository->remove($documentation, true);
        }

        return $this->redirectToRoute('app_documentation_index', [], Response::HTTP_SEE_OTHER);
    }
}
