<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $entityManager = $this->doctrine->getManager();
        $productList =  $entityManager->getRepository(Product::class)->findAll();
        dd($productList);

        return $this->render('main/default/index.html.twig', []);
    }

    #[Route('/product-add', name: 'product_add')]
    public function productAdd(): Response
    {
        $product = new Product();
        $product->setTitle('Product ' . rand(1, 100))
                ->setDescription('smth')
                ->setPrice(10)
                ->setQuantity(1);

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($product);
        $entityManager->flush();

        return $this->redirectToRoute('homepage');
    }
}
