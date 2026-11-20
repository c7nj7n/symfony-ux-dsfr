<?php

declare(strict_types=1);

namespace SymfonyUxDsfr\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
class Notice
{
    #[ExposeInTemplate]
    public string $type = 'info';

    #[ExposeInTemplate]
    public string $title;

    #[ExposeInTemplate]
    public ?string $description = null;

    #[ExposeInTemplate]
    public ?string $link = null; // href of the optional link

    #[ExposeInTemplate]
    public ?string $linkLabel = null;

    #[ExposeInTemplate]
    public bool $newWindow = false; // the link opens in a new window

    #[ExposeInTemplate]
    public string|bool|null $icon = null; // null: the type's icon, a DSFR icon name to replace it, false: no icon

    #[ExposeInTemplate]
    public bool $closable = false;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined();
        $resolver->setRequired('title');
        $resolver->setDefaults([
            'type' => 'info',
            'description' => null,
            'link' => null,
            'linkLabel' => null,
            'newWindow' => false,
            'icon' => null,
            'closable' => false,
        ]);
        $resolver->setAllowedTypes('title', 'string');
        $resolver->setAllowedTypes('description', ['null', 'string']);
        $resolver->setAllowedTypes('link', ['null', 'string']);
        $resolver->setAllowedTypes('linkLabel', ['null', 'string']);
        $resolver->setAllowedTypes('icon', ['null', 'string', 'bool']);
        $resolver->setAllowedValues('icon', static fn ($icon): bool => true !== $icon);
        $resolver->setAllowedValues('type', [
            'info', 'warning', 'alert',
            'weather-orange', 'weather-red', 'weather-purple',
            'kidnapping', 'cyberattack', 'attack', 'witness',
        ]);

        return $resolver->resolve($data) + $data;
    }
}
