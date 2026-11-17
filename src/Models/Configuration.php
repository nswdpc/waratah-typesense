<?php

namespace NSWDPC\Waratah\Typesense\Models;

use NSWDPC\Search\Forms\Models\SiteSearchChoice;
use NSWDPC\Typesense\CMS\Models\TypesenseSearchPage;
use NSWDPC\Typesense\CMS\Controllers\TypesenseSearchPageController;
use NSWDPC\Search\Forms\Forms\SearchForm;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\View\TemplateGlobalProvider;

/**
 * Provides configuration for search forms and global search forms
 */
class Configuration implements TemplateGlobalProvider
{
    use Configurable;

    private static string $global_search_label = 'Typesense search';

    protected static ?SearchForm $global_search_form = null;

    /**
     * Provide a global search form, only if this provider is the global search provider
     */
    public static function get_global_search_form(): ?SearchForm
    {
        if(!is_null(self::$global_search_form)) {
            return self::$global_search_form;
        }
        if((SiteSearchChoice::getGlobalProvider() === self::class) && ($searchPage = TypesenseSearchPage::get()->filter(['IsGlobalSearch' => 1])->first())) {
            $controller = TypesenseSearchPageController::create($searchPage);
            self::$global_search_form = SiteSearchChoice::getGlobalSearchForm($controller, 'typesensesearch');
            return self::$global_search_form;
        }

        return null;
    }

    /**
     * Provide template global variables
     */
    public static function get_template_global_variables()
    {
        $vars = [];
        if(static::get_global_search_form()) {
            $vars = [
                'GlobalSearchForm' => 'get_global_search_form'
            ];
        }
        return $vars;
    }


}
