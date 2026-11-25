<?php

declare(strict_types=1);

namespace SymfonyUxDsfr\Twig\Components\Header;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\UX\TwigComponent\Attribute\PreMount;

/**
 * A dropdown among the header tools, on the DSFR language selector pattern (fr-translate).
 */
#[AsTwigComponent]
class ToolsMenu
{
    private static int $count = 0;

    #[ExposeInTemplate]
    public string $label = '';
    #[ExposeInTemplate]
    public ?string $hint = null; // after the label below lg, e.g. the language name
    #[ExposeInTemplate]
    public ?string $title = null;
    #[ExposeInTemplate]
    public ?string $icon = null; // DSFR icon name without "fr-icon-"
    #[ExposeInTemplate]
    public string $id = '';
    #[ExposeInTemplate]
    public array $items = []; // [{label, href, current, lang}]

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(true);
        $resolver->setRequired(['label', 'items']);
        $resolver->setDefaults(['id' => null, 'hint' => null, 'title' => null, 'icon' => null]);
        $resolver->setAllowedTypes('label', 'string');
        $resolver->setAllowedTypes('items', 'array');
        $resolver->setAllowedTypes('id', ['null', 'string']);
        $resolver->setAllowedTypes('hint', ['null', 'string']);
        $resolver->setAllowedTypes('title', ['null', 'string']);
        $resolver->setAllowedTypes('icon', ['null', 'string']);
        $resolver->setNormalizer('id', static fn (Options $options, ?string $id) => $id ?? 'fr-header-menu-'.++self::$count);

        return $resolver->resolve($data) + $data;
    }
}
