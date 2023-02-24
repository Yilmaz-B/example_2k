<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/{name}/{price}', name: 'create_product')]
    public function createProduct(ManagerRegistry $doctrine,string $name,int $price): Response
    {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('<html><body>Saved new product with id '.$product->getId().'<body></body></html>');
    }

    #[Route('/product/{id}', name: 'product_show')]
    public function show(ManagerRegistry $doctrine, string $id): Response
    {
        $product = $doctrine->getRepository(Product::class)->findBy(["$id"=>'mouse']);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$product->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }

    #[Route('/products', name: 'products_show')]
    public function showProducts(ManagerRegistry $doctrine):Response {
        $products=$doctrine->getRepository(Product::class)->findAll();
        //dd($products);
        return $this->render('bezoeker/products.html.twig',[
            'products'=>$products
        ]);
    }

    #[Route('/product/{cat}/{prod}/{price}', name: 'product')]
    public function index(ManagerRegistry $doctrine,string $cat, string $prod, int $price): Response
    {
        $category = new Category();
        $category->setName($cat);

        $product = new Product();
        $product->setName($prod);
        $product->setPrice($price);


        // relates this product to the category
        $product->setCategory($category);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($category);
        $entityManager->persist($product);
        $entityManager->flush();

        return new Response(
            'Saved new product with id: '.$product->getId()
            .' and new category with id: '.$category->getId()
        );
    }

}