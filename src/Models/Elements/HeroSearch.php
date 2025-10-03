<?php

namespace NSWDPC\Waratah\Typesense\Models\Elements;

use NSWDPC\Typesense\Elemental\Models\Elements\TypesenseSearchElement;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\TextField;
use SilverStripe\LinkField\Form\MultiLinkField;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;

/**
 * Provides a hero search element conforming to the NSW Design System Hero Search Component
 * @property string $Title
 * @property ?string $Subtitle
 * @property ?string $SuggestedTerms
 * @property int $BackgroundImageID
 * @method \SilverStripe\Assets\Image BackgroundImage()
 * @method \SilverStripe\ORM\HasManyList<\SilverStripe\LinkField\Models\Link> Links()
 */
class HeroSearch extends TypesenseSearchElement
{
    private static string $icon = 'font-icon-search';

    private static string $table_name = 'TypesenseHeroSearch';

    private static string $singular_name = 'Hero Search (NSWDS)';

    private static string $plural_name = 'Hero Search (NSWDS)';

    private static array $has_one = [
        'BackgroundImage' => Image::class
    ];

    private static array $db = [
        'Title' => 'Varchar',
        'Subtitle' => 'Varchar',
        'SuggestedTerms' => 'Text'
    ];

    private static array $owns = [
        'Links',
        'BackgroundImage'
    ];

    private static array $has_many = [
        'Links' => Link::class . '.Owner',
    ];

    private static array $cascade_deletes = [
        'Links'
    ];

    private static array $cascade_duplicates = [
        'Links'
    ];

    /**
     * @inheritdoc
     */
    #[\Override]
    public function getType()
    {
        return _t(static::class . '.BlockType', $this->i18n_singular_name());
    }

    /**
     * Update CMS fields
     */
    #[\Override]
    public function getCmsFields()
    {
        $fields = parent::getCmsFields();
        $fields->removeByName(['Links']);
        $fields->addFieldsToTab(
            'Root.Main',
            [
                TextField::create(
                    'Subtitle',
                    _t(self::class . '.SUBTITLE', 'Subtitle')
                ),
                TextField::create(
                    'SuggestedTerms',
                    _t(self::class . '.QUICK_SEARCH_TERMS', 'Quick search terms (comma separated)')
                )->setDescription(
                    _t(
                        self::class . '.QUICK_SEARCH_TERMS_DESCRIPTION',
                        'Quick search terms will only display if no links are present'
                    )
                ),
                UploadField::create(
                    'BackgroundImage',
                    _t(self::class . '.BACKGROUND_IMAGE', 'Background image')
                )->setAllowedExtensions(['jpg','jpeg','png'])
                ->setIsMultiUpload(false)
                ->setFolderName('searchbg')
            ]
        );
        $fields->insertAfter(
            'Subtitle',
            MultiLinkField::create(
                'Links',
                _t(self::class . '.LINKS', 'Links')
            )
        );
        return $fields;
    }

    public function getSuggestedTermsAsArray(): array
    {
        $list = explode(",", $this->SuggestedTerms ?? '');
        return array_filter($list);
    }

    public function getLinkedSuggestedTerms(): ArrayList
    {
        $list = ArrayList::create();
        $page = $this->SearchPage();
        if (!$page || !$page->isInDB()) {
            return $list;
        }

        $terms = $this->getSuggestedTermsAsArray();
        foreach ($terms as $term) {
            $term = strip_tags(trim((string) $term));
            $list->push(
                ArrayData::create([
                    'Title' => $term,
                    'Link' => $page->Link('?q=' . $term)
                ])
            );
        }

        return $list;
    }

    /**
     * Render element into template
     */
    #[\Override]
    public function forTemplate($holder = true)
    {
        $templates = $this->getRenderTemplates();
        /** @var \NSWDPC\Typesense\Elemental\Controllers\TypesenseSearchElementController $controller */
        $controller = $this->getController();
        $templateData = ArrayData::create([
            'Title' => $this->Title,
            'Subtitle' => $this->Subtitle,
            'Form' => $controller->SearchForm(),
            'Image' => $this->BackgroundImage(),
            'Links' => $this->Links(),
            'Terms' => $this->getLinkedSuggestedTerms()
        ]);
        if ($templates) {
            return $this->customise($templateData)->renderWith($templates);
        }

        return null;
    }

}
