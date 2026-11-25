<?php

declare(strict_types=1);

namespace SymfonyUxDsfr\Twig\Components\Layout;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
class SideMenu
{
    private static int $count = 0;

    #[ExposeInTemplate]
    public ?string $title = null; // labels the menu (aria-labelledby) when set

    #[ExposeInTemplate]
    public ?string $id = null; // prefix of the ids (title, collapsed list), unique by default

    #[ExposeInTemplate]
    public ?string $buttonLabel = null; // mobile button, "Dans cette rubrique" by default

    #[ExposeInTemplate]
    public bool|string $sticky = false; // true for fr-sidemenu--sticky, 'full-height' for fr-sidemenu--sticky-full-height

    #[ExposeInTemplate]
    public bool $right = false; // fr-sidemenu--right

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(true);
        $resolver->setDefaults([
            'title' => null,
            'menu_title' => null, // former name of title
            'id' => null,
            'buttonLabel' => null,
            'sticky' => false,
            'right' => false,
        ]);
        $resolver->setAllowedTypes('title', ['null', 'string']);
        $resolver->setAllowedTypes('menu_title', ['null', 'string']);
        $resolver->setAllowedTypes('id', ['null', 'string']);
        $resolver->setAllowedTypes('buttonLabel', ['null', 'string']);
        $resolver->setAllowedValues('sticky', [false, true, 'full-height']);
        $resolver->setAllowedTypes('right', 'bool');
        $resolver->setNormalizer('title', static fn (Options $options, ?string $title) => $title ?? $options['menu_title']);
        $resolver->setNormalizer('id', static fn (Options $options, ?string $id) => $id ?? 'fr-sidemenu-'.++self::$count);

        $options = $resolver->resolve($data);
        unset($options['menu_title'], $data['menu_title']);

        return $options + $data;
    }
}
