import _ from 'lodash';

const $ = jQuery;

$(document).ready(init);

function init() {
    $('body').on('click', '.delete', removeParent);
}

function removeParent() {
    return $(this).parent().remove();
}
