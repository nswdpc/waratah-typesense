<?php

declare(strict_types=1);

namespace NSWDPC\Waratah\Typesense\Tests;

use NSWDPC\Typesense\CMS\Models\TypesenseSearchPage;
use NSWDPC\Waratah\Typesense\Models\Elements\HeroSearch;
use SilverStripe\Dev\SapphireTest;

/**
 * Tests the "quick search terms" logic on {@link HeroSearch}:
 * - splitting/filtering the raw SuggestedTerms value
 * - building linked, sanitised terms for display
 */
class HeroSearchTest extends SapphireTest
{
    protected $usesDatabase = true;

    protected static $extra_dataobjects = [
        HeroSearch::class,
        TypesenseSearchPage::class,
    ];

    public function testGetSuggestedTermsAsArrayReturnsEmptyArrayWhenNotSet(): void
    {
        $element = HeroSearch::create();
        $this->assertSame([], $element->getSuggestedTermsAsArray());
    }

    public function testGetSuggestedTermsAsArrayFiltersOutEmptyValues(): void
    {
        $element = HeroSearch::create();
        $element->SuggestedTerms = 'foo,,bar,';

        $this->assertSame(['foo', 'bar'], array_values($element->getSuggestedTermsAsArray()));
    }

    public function testGetSuggestedTermsAsArrayDoesNotTrimWhitespace(): void
    {
        $element = HeroSearch::create();
        $element->SuggestedTerms = ' foo , bar ';

        $this->assertSame([' foo ', ' bar '], array_values($element->getSuggestedTermsAsArray()));
    }

    public function testGetLinkedSuggestedTermsReturnsEmptyListWithoutASearchPage(): void
    {
        $element = HeroSearch::create();
        $element->SuggestedTerms = 'foo,bar';

        $terms = $element->getLinkedSuggestedTerms();

        $this->assertCount(0, $terms);
    }

    public function testGetLinkedSuggestedTermsTrimsWhitespaceAndStripsTags(): void
    {
        $page = TypesenseSearchPage::create(['Title' => 'Search', 'SearchScope' => '{}']);
        $page->write();

        $element = HeroSearch::create();
        $element->SearchPageID = $page->ID;
        $element->SuggestedTerms = ' <b>foo</b> , bar ';

        $terms = $element->getLinkedSuggestedTerms();

        $this->assertCount(2, $terms);
        $this->assertSame('foo', $terms[0]->Title);
        $this->assertSame('bar', $terms[1]->Title);
    }

    public function testGetLinkedSuggestedTermsUrlEncodesTheQueryString(): void
    {
        $page = TypesenseSearchPage::create(['Title' => 'Search', 'SearchScope' => '{}']);
        $page->write();

        $element = HeroSearch::create();
        $element->SearchPageID = $page->ID;
        $element->SuggestedTerms = 'foo & bar';

        $terms = $element->getLinkedSuggestedTerms();

        $this->assertCount(1, $terms);
        $this->assertStringContainsString('q=foo+%26+bar', (string) $terms[0]->Link);
    }
}
