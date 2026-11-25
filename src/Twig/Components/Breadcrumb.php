<?php

declare(strict_types=1);

namespace SymfonyUxDsfr\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
class Breadcrumb
{
    #[ExposeInTemplate]
    public array $items = []; // each item: ['label' => '...', 'href' => null], the item without href is the current page

    #[ExposeInTemplate]
    public string $id = 'breadcrumb'; // id of the collapsed list, controlled by the mobile button

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(true);
        $resolver->setDefaults(['items' => [], 'id' => 'breadcrumb']);
        $resolver->setAllowedTypes('items', 'array');
        $resolver->setAllowedTypes('id', 'string');

        return $resolver->resolve($data) + $data;
    }
}
