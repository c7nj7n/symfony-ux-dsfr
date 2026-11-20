<?php

declare(strict_types=1);

namespace SymfonyUxDsfr\Twig\Components\Button;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
class Group
{
    #[ExposeInTemplate]
    public string $size = 'md';

    #[ExposeInTemplate]
    public ?string $iconPosition = null; // icon position of every button in the group

    #[ExposeInTemplate]
    public ?string $inline = null; // null stacks the buttons, "always" or a breakpoint (sm, md, lg) puts them in a row

    #[ExposeInTemplate]
    public string $align = 'left';

    #[ExposeInTemplate]
    public bool $reverse = false; // reversed order, inline and right-aligned groups only

    #[ExposeInTemplate]
    public bool $equisized = false;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined();
        $resolver->setDefaults([
            'size' => 'md',
            'iconPosition' => null,
            'inline' => null,
            'align' => 'left',
            'reverse' => false,
            'equisized' => false,
        ]);
        $resolver->setAllowedValues('size', ['sm', 'md', 'lg']);
        $resolver->setAllowedValues('iconPosition', [null, 'left', 'right']);
        $resolver->setAllowedValues('inline', [null, 'always', 'sm', 'md', 'lg']);
        $resolver->setAllowedValues('align', ['left', 'right', 'center']);

        return $resolver->resolve($data) + $data;
    }
}
