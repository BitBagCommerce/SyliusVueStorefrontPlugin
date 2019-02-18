<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Controller;

use BitBag\SyliusVueStorefrontPlugin\Bridge\Product\Product;
use BitBag\SyliusVueStorefrontPlugin\Response\VueStorefrontResponse;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetProductsIndexAction
{
    /** @var RepositoryInterface */
    private $productRepository;

    public function __construct(RepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(): JsonResponse
    {
        try {
            $products = $this->getProducts();
        } catch (\Exception $exception) {
            return VueStorefrontResponse::error($exception->getMessage());
        }

        return VueStorefrontResponse::success((array) $products);
    }

    private function getProducts(): iterable
    {
        $products = $this->productRepository->findAll();

        foreach ($products as $product) {
            yield Product::fromSyliusProduct($product);
        }
    }
}
