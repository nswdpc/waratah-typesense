<%-- context: \NSWDPC\Search\Typesense\Models\Result --%>
<% if $TypesenseSearchResult %>
    <% with $TypesenseSearchResult %>
        <% include nswds/ListItem ListItem_Title=$Title, ListItem_LinkURL=$Link, ListItem_Abstract=$Abstract, ListItem_Info=$Info, ListItem_DateString=$Date, ListItem_Tags=$Labels, ListItem_ImageURL=$ImageURL, ListItem_ImageAlt=$ImageAlt, ListItem_PrimaryLabel=$Label %>
    <% end_with %>
<% end_if %>
