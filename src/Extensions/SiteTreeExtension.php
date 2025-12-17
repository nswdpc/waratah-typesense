<?php

namespace NSWDPC\Waratah\Typesense\Extensions;

use SilverStripe\Core\Extension;

/**
 * Provides an extension to manage SiteTree search and results
 * @extends \SilverStripe\Core\Extension<(\SilverStripe\CMS\Model\SiteTree & static)>
 */
class SiteTreeExtension extends Extension
{
    /**
     * Provide specific updates to the search result data
     */
    public function afterGetTypesenseSearchResult(array &$data): void
    {
        $owner = $this->getOwner();
        if (($owner instanceof \Page) && ($lastUpdated = $owner->PageLastUpdated())) {
            $data['Date'] = $lastUpdated->Human;
        }
    }

}
