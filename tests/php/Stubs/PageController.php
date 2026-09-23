<?php

declare(strict_types=1);

use SilverStripe\CMS\Controllers\ContentController;

/**
* @template T of \Page
* @extends \SilverStripe\CMS\Controllers\ContentController<T> @phpstan-ignore generics.notSupportedBound
*/
class PageController extends ContentController
{
}
