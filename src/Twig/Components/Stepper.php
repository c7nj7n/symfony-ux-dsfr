<?php

declare(strict_types=1);

namespace SymfonyUxDsfr\Twig\Components;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent]
class Stepper
{
    /** @var list<string> */
    #[ExposeInTemplate]
    public array $steps = []; // step titles, in order

    #[ExposeInTemplate]
    public int $current = 1; // current step, from 1

    #[ExposeInTemplate]
    public string $titleTag = 'h2';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined();
        $resolver->setRequired(['steps', 'current']);
        $resolver->setDefaults(['titleTag' => 'h2']);
        $resolver->setAllowedTypes('steps', 'string[]');
        $resolver->setAllowedTypes('current', 'int');
        $resolver->setAllowedValues('titleTag', ['h2', 'h3', 'h4', 'h5', 'h6']);
        $resolver->setNormalizer('steps', static fn (Options $options, array $steps): array => array_values($steps));
        $resolver->setAllowedValues('steps', static fn (array $steps): bool => [] !== $steps);
        $resolver->setNormalizer('current', static function (Options $options, int $current): int {
            if ($current < 1 || $current > \count($options['steps'])) {
                throw new \InvalidArgumentException(\sprintf('The "current" step must be between 1 and %d, %d given.', \count($options['steps']), $current));
            }

            return $current;
        });

        return $resolver->resolve($data) + $data;
    }

    #[ExposeInTemplate]
    public function getNextStep(): ?string
    {
        return $this->steps[$this->current] ?? null;
    }
}
