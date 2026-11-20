<?php

declare(strict_types=1);

namespace SymfonyUxDsfr\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
class Button
{
    #[ExposeInTemplate]
    public string $variant = 'primary';

    #[ExposeInTemplate]
    public string $size = 'md';

    #[ExposeInTemplate]
    public ?string $icon = null; // DSFR icon name without its fr-icon- prefix, e.g. "delete-line"

    #[ExposeInTemplate]
    public ?string $iconPosition = 'left'; // "only" hides the label, which becomes the title; null in a group that sets it

    #[ExposeInTemplate]
    public ?string $href = null;

    #[ExposeInTemplate]
    public ?string $type = 'button';

    #[ExposeInTemplate]
    public bool $disabled = false;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'variant' => 'primary',
            'size' => 'md',
            'icon' => null,
            'iconPosition' => 'left',
            'type' => 'button',
            'disabled' => false,
        ]);
        $resolver->setIgnoreUndefined();
        $resolver->setAllowedValues('variant', ['primary', 'secondary', 'tertiary', 'tertiary-no-outline']);
        $resolver->setAllowedValues('size', ['sm', 'md', 'lg']);
        $resolver->setAllowedTypes('icon', ['null', 'string']);
        $resolver->setAllowedValues('iconPosition', [null, 'left', 'right', 'only']);
        $resolver->setAllowedValues('type', ['button', 'submit', 'reset']);

        return $resolver->resolve($data) + $data;
    }
}
