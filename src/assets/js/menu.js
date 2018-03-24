import _ from 'lodash';

const $ = jQuery;

$(document).ready(init);

function init() {
    $('.menu-trigger').on('click', toggleMenu);
    $('.menu a').on('click', toggleSubMenus);
}

function toggleMenu(event) {
    event.preventDefault();

    if ($(this).hasClass('active') && $('body').scrollTop() == 0) {
        $('header').removeClass('scrolled');
    } else {
        $('header').addClass('scrolled');
    }

    $(this).toggleClass('active');
    $('header .menu').toggle();
}

function toggleSubMenus(event) {
    var $this = $(this);
    var next = $this.next();
    var windowWidth = $(window).width();
    if (next.hasClass('sub-menu') && windowWidth <= 1080) {
        event.preventDefault();
        $this.toggleClass('active')
        next.slideToggle();
    }
}
