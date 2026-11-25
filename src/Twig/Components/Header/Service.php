<?php

declare(strict_types=1);

namespace SymfonyUxDsfr\Twig\Components\Header;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsTwigComponent]
class Service
{
    #[ExposeInTemplate]
    public ?string $link = null; // "/" by default
    #[ExposeInTemplate]
    public ?string $link_title = null; // "Accueil - <title>" by default
    #[ExposeInTemplate]
    public ?string $title = null;
    #[ExposeInTemplate]
    public ?string $tagline = null;
    #[ExposeInTemplate]
    public string|\Stringable|null $badges = null; // markup after the title, e.g. a fr-badge
}
