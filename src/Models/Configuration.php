<?php

namespace NSWDPC\Waratah\Typesense\Models;

use NSWDPC\Typesense\CMS\Models\TypesenseSearchPage;
use NSWDPC\Typesense\CMS\Controllers\TypesenseSearchPageController;
use NSWDPC\Search\Forms\Forms\SearchForm;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\View\TemplateGlobalProvider;

/**
 * Provides configuration for search forms and global search forms
 */
class Configuration implements TemplateGlobalProvider {

    use Configurable;

    /**
     * Provide a global search form
     */
    public static function get_global_search_form(): ?SearchForm {
        if($searchPage = TypesenseSearchPage::get()->filter(['IsGlobalSearch' => 1])->first()) {
            $controller = TypesenseSearchPageController::create($searchPage);
            return SearchForm::create(
                $controller,
                'GlobalSearchForm'
            )->setFormMethod('GET')
            ->setFormAction($controller->Link())
            ->disableSecurityToken();
        } else {
            return null;
        }
    }

    /**
     * Provide template global variables
     */
    public static function get_template_global_variables()
    {
        return [
            'SearchForm' => 'get_global_search_form',// provided for BC
            'GlobalSearchForm' => 'get_global_search_form'
        ];
    }


}
