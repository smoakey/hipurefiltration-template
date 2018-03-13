import _ from 'lodash';

const $ = jQuery;

$(document).ready(init);

function init() {
    let search = $('.menu').find('li.search');
    search.html(searchFormHtml());
}

function searchFormHtml() {
    return `
        <form class="product-search" method="get" id="searchform" action="/">
            <button type="submit" id="searchsubmit"></button>
            <input type="text" value="" name="s" id="s" placeholder="Search by Keyword or Product #" autocomplete="false" />
            <input type="hidden" name="post_type" value="product" />
        </form>
    `;
}
