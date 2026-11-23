<?php

declare(strict_types=1);

namespace SymfonyUxDsfr\Twig\Components\Tag;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
class Group
{
    #[ExposeInTemplate]
    public string $size = 'md'; // sm sizes every tag of the group (fr-tags-group--sm)

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(true);
        $resolver->setDefaults(['size' => 'md']);
        $resolver->setAllowedValues('size', ['sm', 'md']);

        return $resolver->resolve($data) + $data;
    }
}
