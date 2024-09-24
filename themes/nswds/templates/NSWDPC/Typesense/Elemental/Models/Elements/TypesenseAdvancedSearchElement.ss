<% include NSWDPC/Waratah/ElementTitle ShowTitle=$ShowTitle, Title=$Title, HeadingLevel=$HeadingLevel %>
<div class="nsw-grid">

    <div class="nsw-col nsw-col-md-3">
        {$SearchForm}
    </div>

    <div class="nsw-col nsw-col-md-9">
        <% if $SearchResults %>
            <% loop $SearchResults %>
                {$Me}
            <% end_loop %>
        <% else %>
            <p>No results</p>
        <% end_if %>
    </div>

</div>
