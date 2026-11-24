<?php

declare(strict_types=1);

namespace SymfonyUxDsfr\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
class Callout
{
    public const COLORS = [
        'green-tilleul-verveine', 'green-bourgeon', 'green-emeraude', 'green-menthe', 'green-archipel', 'blue-ecume',
        'blue-cumulus', 'purple-glycine', 'pink-macaron', 'pink-tuile', 'yellow-tournesol', 'yellow-moutarde',
        'orange-terre-battue', 'brown-cafe-creme', 'brown-caramel', 'brown-opera', 'beige-gris-galet',
    ];

    #[ExposeInTemplate]
    public string $color = '';

    #[ExposeInTemplate]
    public ?string $icon = null; // DSFR icon name without "fr-icon-", e.g. information-line

    #[ExposeInTemplate]
    public ?string $title = null; // fr-callout__title

    #[ExposeInTemplate]
    public string $titleTag = 'h3';

    #[ExposeInTemplate]
    public ?string $text = null; // fr-callout__text

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(true);
        $resolver->setDefaults(['color' => '', 'icon' => null, 'title' => null, 'titleTag' => 'h3', 'text' => null]);
        // "grey" has no DSFR class: still accepted, it renders the default callout
        $resolver->setAllowedValues('color', ['', 'grey', ...self::COLORS]);
        $resolver->setAllowedTypes('icon', ['null', 'string']);
        $resolver->setAllowedTypes('title', ['null', 'string']);
        $resolver->setAllowedValues('titleTag', ['h2', 'h3', 'h4', 'h5', 'h6', 'p']);
        $resolver->setAllowedTypes('text', ['null', 'string']);

        return $resolver->resolve($data) + $data;
    }
}
