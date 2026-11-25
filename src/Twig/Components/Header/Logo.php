<?php

declare(strict_types=1);

namespace SymfonyUxDsfr\Twig\Components\Header;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsTwigComponent]
class Logo
{
    #[ExposeInTemplate]
    public ?string $service_logo = null;
    #[ExposeInTemplate]
    public ?string $service_logo_alt = null;
    #[ExposeInTemplate]
    public ?string $title = null; // "République<br>Française" by default, <br> allowed
}
