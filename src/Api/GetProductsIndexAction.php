<?php

declare(strict_types=1);

namespace BitBag\SyliusVueStorefrontPlugin\Api;

use BitBag\SyliusVueStorefrontPlugin\Bridge\Product\Product;
use BitBag\SyliusVueStorefrontPlugin\Response\VueStorefrontResponse;
use Sylius\Component\Core\Model\ProductInterface;
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

        return VueStorefrontResponse::success(\iterator_to_array($products));
    }

    private function getProducts(): \Traversable
    {
        $products = $this->productRepository->findAll();

        /** @var ProductInterface $product */
        foreach ($products as $product) {
            $bridgeProduct = Product::fromSyliusProduct($product);

            yield $product->getId() => $bridgeProduct->jsonSerialize();
        }
    }
}
