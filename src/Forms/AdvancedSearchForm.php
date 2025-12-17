<?php

namespace NSWDPC\Waratah\Typesense\Forms;

use NSWDPC\Search\Forms\Forms\AdvancedSearchForm as BaseAdvancedSearchForm;
use NSWDPC\Waratah\Traits\FilterFormTrait;

/**
 * Waratah smarts for the advanced search form
 * triggers the FilterForm handling on the advanced search form
 */
class AdvancedSearchForm extends BaseAdvancedSearchForm
{
    use FilterFormTrait;

}
