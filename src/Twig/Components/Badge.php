<?php

declare(strict_types=1);

namespace SymfonyUxDsfr\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
class Badge
{
    public const ACCENT_COLORS = [
        'green-tilleul-verveine', 'green-bourgeon', 'green-emeraude', 'green-menthe', 'green-archipel',
        'blue-ecume', 'blue-cumulus', 'purple-glycine', 'pink-macaron', 'pink-tuile',
        'yellow-tournesol', 'yellow-moutarde', 'orange-terre-battue', 'brown-cafe-creme', 'brown-caramel',
        'brown-opera', 'beige-gris-galet',
    ];

    #[ExposeInTemplate]
    public ?string $type = 'info'; // system badge, null for a neutral one

    #[ExposeInTemplate]
    public ?string $color = null; // accent colour, replaces the system type

    #[ExposeInTemplate]
    public string $size = 'md';

    #[ExposeInTemplate]
    public bool $icon = true; // false removes the system type's icon

    #[ExposeInTemplate]
    public bool $ellipsis = false;

    #[ExposeInTemplate]
    public string $tag = 'p'; // span inside a badges group, a link or a table cell

    #[ExposeInTemplate]
    public string $content = '';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined();
        $resolver->setDefaults([
            'type' => 'info',
            'color' => null,
            'size' => 'md',
            'icon' => true,
            'ellipsis' => false,
            'tag' => 'p',
        ]);

        $resolver->setAllowedValues('type', [null, 'info', 'warning', 'error', 'success', 'new']);
        $resolver->setAllowedValues('color', [null, ...self::ACCENT_COLORS]);
        $resolver->setAllowedValues('size', ['sm', 'md']);
        $resolver->setAllowedValues('tag', ['p', 'span']);

        return $resolver->resolve($data) + $data;
    }
}
