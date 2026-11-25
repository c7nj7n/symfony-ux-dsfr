<?php

declare(strict_types=1);

namespace SymfonyUxDsfr\Twig\Components;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\UX\TwigComponent\Attribute\PreMount;
use SymfonyUxDsfr\Service\SearchOptions;

#[AsTwigComponent]
class Header
{
    #[ExposeInTemplate]
    public ?string $service_title = null;
    #[ExposeInTemplate]
    public ?string $service_tagline = null;
    #[ExposeInTemplate]
    public ?string $service_link = null; // "/" by default
    #[ExposeInTemplate]
    public ?string $service_link_title = null; // "Accueil - <service> - <logo>" by default
    #[ExposeInTemplate]
    public ?string $service_logo = null;
    #[ExposeInTemplate]
    public ?string $service_logo_alt = null;
    #[ExposeInTemplate]
    public ?string $logo_title = null; // "République<br>Française" by default
    #[ExposeInTemplate]
    public string $menu_id = 'header-menu';
    #[ExposeInTemplate]
    public bool $show_menu_button = false;
    #[ExposeInTemplate]
    public bool $show_search_button = false;
    #[ExposeInTemplate]
    public array $availables_languages = [];
    #[ExposeInTemplate]
    public string $search_modal_id = 'search-modal';
    #[ExposeInTemplate]
    public string $navigation_id = 'navigation';
    #[ExposeInTemplate]
    public array $skiplinks = []; // [{label, href}], rendered before the header

    #[ExposeInTemplate]
    public ?SearchOptions $search = null;

    public function __construct(SearchOptions $search)
    {
        $this->search = $search;
    }

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined();
        $resolver->setDefaults([
            'service_title' => null,
            'service_tagline' => null,
            'header_service_title' => null, // former name of service_title
            'header_service_tag' => null, // former name of service_tagline
            'show_menu_button' => false,
            'show_search_button' => false,
        ]);
        $resolver->setAllowedTypes('service_title', ['null', 'string']);
        $resolver->setAllowedTypes('service_tagline', ['null', 'string']);
        $resolver->setAllowedTypes('header_service_title', ['null', 'string']);
        $resolver->setAllowedTypes('header_service_tag', ['null', 'string']);
        $resolver->setNormalizer('service_title', static fn (Options $options, ?string $title) => $title ?? $options['header_service_title']);
        $resolver->setNormalizer('service_tagline', static fn (Options $options, ?string $tagline) => $tagline ?? $options['header_service_tag']);
        // "true" and "false" strings from HTML-like attributes
        $resolver->setNormalizer('show_menu_button', static fn (Options $options, mixed $value) => filter_var($value, \FILTER_VALIDATE_BOOL));
        $resolver->setNormalizer('show_search_button', static fn (Options $options, mixed $value) => filter_var($value, \FILTER_VALIDATE_BOOL));

        $options = $resolver->resolve($data);
        unset($options['header_service_title'], $options['header_service_tag'], $data['header_service_title'], $data['header_service_tag']);

        return $options + $data;
    }
}
