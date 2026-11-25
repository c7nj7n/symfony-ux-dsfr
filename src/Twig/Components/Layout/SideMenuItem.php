<?php

declare(strict_types=1);

namespace SymfonyUxDsfr\Twig\Components\Layout;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
class SideMenuItem
{
    private static int $count = 0;

    #[ExposeInTemplate]
    public ?string $href = null; // renders the item's link, its label being the content; the link or submenu block otherwise

    #[ExposeInTemplate]
    public bool $current = false; // the link to the current page (aria-current="page")

    #[ExposeInTemplate]
    public bool $active = false; // fr-sidemenu__item--active, on the item holding the current page

    #[ExposeInTemplate]
    public ?string $title = null; // makes the item a submenu: this button, then its content as a nested list

    #[ExposeInTemplate]
    public ?string $id = null; // id of the submenu's collapsed list, unique by default

    #[ExposeInTemplate]
    public bool $expanded = false; // submenu open on load, by default when active

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(true);
        $resolver->setDefaults(['href' => null, 'current' => false, 'active' => false, 'title' => null, 'id' => null, 'expanded' => null]);
        $resolver->setAllowedTypes('href', ['null', 'string']);
        $resolver->setAllowedTypes('current', 'bool');
        $resolver->setAllowedTypes('active', 'bool');
        $resolver->setAllowedTypes('title', ['null', 'string']);
        $resolver->setAllowedTypes('id', ['null', 'string']);
        $resolver->setAllowedTypes('expanded', ['null', 'bool']);
        $resolver->setNormalizer('id', static fn (Options $options, ?string $id) => $id ?? 'fr-sidemenu-item-'.++self::$count);
        $resolver->setNormalizer('expanded', static fn (Options $options, ?bool $expanded) => $expanded ?? $options['active']);

        return $resolver->resolve($data) + $data;
    }
}
