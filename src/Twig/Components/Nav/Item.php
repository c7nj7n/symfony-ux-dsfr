<?php

declare(strict_types=1);

namespace SymfonyUxDsfr\Twig\Components\Nav;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsTwigComponent]
class Item
{
    private static int $count = 0;

    #[ExposeInTemplate]
    public ?string $href = null;

    #[ExposeInTemplate]
    public ?bool $current = null; // null: current when href is the request path

    #[ExposeInTemplate]
    public ?string $id = null; // id of the sub-menu, unique by default

    public function getSubMenuId(): string
    {
        return $this->id ??= 'fr-nav-menu-'.++self::$count;
    }
}
