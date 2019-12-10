<?php

namespace spec\BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer;

use BitBag\SyliusVueStorefrontPlugin\Sylius\Transformer\SyliusProductTransformer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SyliusProductTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SyliusProductTransformer::class);
    }
}
