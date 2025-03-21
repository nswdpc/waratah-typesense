
<%-- results listing for typesense --%>

<% if $Results %>

    <% if $SearchQuery %>
        <% include nswds/ResultsBar ResultsBar_Total=$Results.TotalItems, ResultsBar_Start=$Results.FirstItem, ResultsBar_End=$Results.LastItem, ResultsBar_ResultType='items', ResultsBar_ResultTypeSingular='item' %>
    <% end_if %>

    <% loop $Results %>
        <%-- see Result.ss template --%>
        {$Me}
    <% end_loop %>

    <% include nswds/Pagination Pagination_PaginatedItems=$Results %>

<% else_if $SearchQuery %>

    <div class="nsw-m-top-md">
        <% include nswds/InPageAlert InPageAlert_Icon='search', InPageAlert_Title='No results', InPageAlert_Content='Sorry, your search did not return any results.' %>
    </div>

<% else %>

    <div class="nsw-m-top-md">
        <% include nswds/InPageAlert InPageAlert_Icon='search', InPageAlert_Title='Search term required', InPageAlert_Content='Enter a search term to find matching records' %>
    </div>

<% end_if %>
