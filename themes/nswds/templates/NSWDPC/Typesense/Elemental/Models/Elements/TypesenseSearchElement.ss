<% include NSWDPC/Waratah/ElementTitle ShowTitle=$ShowTitle, Title=$Title, HeadingLevel=$HeadingLevel %>
foo
<% if $UseAdvancedSearch %>
    <% include nswds/FilterForm ClearLink=$CurrentPage.Link %>
<% else %>
    {$SearchForm}
<% end_if %>
</div>
