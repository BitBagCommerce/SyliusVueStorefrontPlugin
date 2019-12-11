<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusVueStorefrontPlugin\DependencyInjection;

use BitBag\SyliusVueStorefrontPlugin\DependencyInjection\Configuration;
use PhpParser\Node\Arg;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

final class ConfigurationSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(Configuration::class);
    }

    function it_gets_config_tree_builder(TreeBuilder $treeBuilder): void
    {
        $this->getConfigTreeBuilder()->shouldReturnAnInstanceOf(TreeBuilder::class);
    }
}
