<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categorie")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="category_index", methods={"GET", "POST"})
     * @param CategoryRepository $categoryRepository
     * @param Request $request
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository, Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('admin-success', 'La création de la catégorie a bien été effectuée');

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'form' => $form->createView(),
            'edit' => false,
        ]);
    }


    /**
     * @Route("/{id}/modifier", name="category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('admin-success', 'La modification de la catégorie a bien été effectuée');

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/index.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
            'categories' => $categoryRepository->findAll(),
            'edit' => true,
        ]);
    }

    /**
     * @Route("/{id}", name="category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }

        $this->addFlash('admin-success', 'Votre suppression a bien été effectuée');

        return $this->redirectToRoute('category_index');
    }
}
