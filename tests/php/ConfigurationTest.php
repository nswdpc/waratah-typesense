<?php

declare(strict_types=1);

namespace NSWDPC\Waratah\Typesense\Tests;

use NSWDPC\Search\Forms\Forms\SearchForm;
use NSWDPC\Typesense\CMS\Models\TypesenseSearchPage;
use NSWDPC\Waratah\Typesense\Models\Configuration;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Security\NullSecurityToken;

/**
 * Tests the template global variables, and the global search form lookup,
 * exposed by {@link Configuration}
 */
class ConfigurationTest extends SapphireTest
{
    protected $usesDatabase = true;

    protected static $extra_dataobjects = [
        TypesenseSearchPage::class,
    ];

    public function testGetTemplateGlobalVariablesExposesSearchFormGlobals(): void
    {
        $variables = Configuration::get_template_global_variables();

        $this->assertSame(
            [
                'SearchForm' => 'get_global_search_form',
                'GlobalSearchForm' => 'get_global_search_form'
            ],
            $variables
        );
    }

    public function testGetGlobalSearchFormReturnsAFormWhenAGlobalSearchPageExists(): void
    {
        $page = TypesenseSearchPage::create([
            'Title' => 'Global Search',
            'IsGlobalSearch' => 1,
            'SearchScope' => '{}'
        ]);
        $page->write();

        $form = Configuration::get_global_search_form();

        $this->assertInstanceOf(SearchForm::class, $form);
        $this->assertSame('GlobalSearchForm', $form->getName());
        $this->assertSame('GET', $form->FormMethod());
        $this->assertSame($page->Link(), $form->FormAction());
        $this->assertInstanceOf(NullSecurityToken::class, $form->getSecurityToken());
    }

    public function testGetGlobalSearchFormReturnsNullWithoutAGlobalSearchPage(): void
    {
        // A search page exists, but is not marked as the global search page
        $page = TypesenseSearchPage::create([
            'Title' => 'Section Search',
            'IsGlobalSearch' => 0,
            'SearchScope' => '{}'
        ]);
        $page->write();

        $this->assertNull(Configuration::get_global_search_form());
    }
}
