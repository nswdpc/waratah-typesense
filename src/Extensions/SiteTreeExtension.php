<?php

namespace NSWDPC\Waratah\Typesense\Extensions;

use SilverStripe\Core\Extension;

/**
 * Waratah smarts for the advanced search form
 */
class SiteTreeExtension extends Extension {

    /**
     * Provide specific updates to the search result data
     */
    public function afterGetTypesenseSearchResult(array &$data): void {
        $owner = $this->getOwner();
        if($lastupdated = $owner->PageLastUpdated()) {
            $data['Date'] = $lastUpdated->Human;
        }
    }

}
