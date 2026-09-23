<?php

declare(strict_types=1);

use SilverStripe\CMS\Model\SiteTree;

class Page extends SiteTree
{
    private static string $table_name = 'NSWDPC_Tests_Page';

    private static array $db = [
        'TestValue' => 'Varchar'
    ];
}
