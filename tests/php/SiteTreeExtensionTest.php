<?php

declare(strict_types=1);

namespace NSWDPC\Waratah\Typesense\Tests;

use NSWDPC\Waratah\Typesense\Extensions\SiteTreeExtension;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\SapphireTest;

/**
 * Tests the search result data added by {@link SiteTreeExtension}
 */
class SiteTreeExtensionTest extends SapphireTest
{

    protected $usesDatabase = true;

    public function testAfterGetTypesenseSearchResultAddsHumanDateForPages(): void
    {
        Config::modify()->set(\Page::class, 'show_last_updated', true);

        $page = \Page::create(['Title' => 'A page']);
        $page->LastEdited = '2024-01-15 10:00:00';

        $extension = new SiteTreeExtension();
        $extension->setOwner($page);

        $data = [];
        $extension->afterGetTypesenseSearchResult($data);

        $lastUpdated = $page->PageLastUpdated();
        $this->assertNotNull($lastUpdated);
        $this->assertArrayHasKey('Date', $data);
        $this->assertSame($lastUpdated->Human, $data['Date']);
    }

    public function testAfterGetTypesenseSearchResultLeavesDataUntouchedWhenLastUpdatedUnavailable(): void
    {
        // show_last_updated defaults to false, so PageLastUpdated() returns null
        $page = \Page::create(['Title' => 'A page']);
        $page->LastEdited = '2024-01-15 10:00:00';

        $extension = new SiteTreeExtension();
        $extension->setOwner($page);

        $data = ['Existing' => 'value'];
        $extension->afterGetTypesenseSearchResult($data);

        $this->assertSame(['Existing' => 'value'], $data);
    }

    public function testAfterGetTypesenseSearchResultIgnoresNonPageOwners(): void
    {
        Config::modify()->set(\Page::class, 'show_last_updated', true);

        $record = SiteTree::create(['Title' => 'Not a page']);
        $record->LastEdited = '2024-01-15 10:00:00';

        $extension = new SiteTreeExtension();
        $extension->setOwner($record);

        $data = ['Existing' => 'value'];
        $extension->afterGetTypesenseSearchResult($data);

        $this->assertSame(['Existing' => 'value'], $data);
    }
}
