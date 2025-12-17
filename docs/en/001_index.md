# Documentation

## Administrators

Ensure the project has a functioning Typesense search implementation with appropriate API keys and search server endpoints set up.

## Authors

1. Ensure a 'Typesense search page' is created and available
1. Create a page
1. Add a 'Hero Search (NSWDS)' element to the top content area of a page, configure it
1. Save the page
1. Test search
1. Publish the page

### Hero search element

In this element you can configure a search form and render it using the NSW Design System "Hero Search" component. The Hero Search element lives in the "Top content" area of a page.

You can:
1. Add a title, optionally displayed
2. Add a sub title
3. Add search links for popular items
4. Add optional quick search terms, a visitor can click on search term and view the results
5. Add a background image for the component
6. Configure a search results page - when someone searches for a keyword, results will display on this page.

### Instantsearch

This module supports Typesense instantsearch via a scoped search key. You administrator can set this up for you.

Once this is configured, the hero element will have one or more instant search configurations to choose from in the "Instantsearch" tab (behind the 3-dots menu on the right of the element view). Choose a configuration, save and then when happy publish.

When someone types in the search field of the hero element, a list of found records is displayed. Clicking on or hitting enter on a search result listed will take the user to the linked page relevant to the result.

> Instantsearch setup requires your site administrator to have a working understanding of Typesense scoped searches.
