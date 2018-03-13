<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" type="image/x-icon" />
        <title>
            <?php wp_title('|', true, 'right'); ?>
            <?php bloginfo('name'); ?>, <?php bloginfo('description'); ?>
        </title>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class('has-navbar-fixed-top'); ?>>
        <header class="site-header">
            <div class="container is-fluid">
                <h1><a title="Home" href="/"><?php bloginfo('name'); ?></a></h1>
                <a href="" class="menu-trigger">
                    Menu
                </a>
                <?php wp_nav_menu(['menu' => 'Main']) ?>

                <nav class="my-nav">
                    <ul>
                        <?php if (is_user_logged_in()) : ?>
                            <li>
                                <a href="/my-account">
                                    <i class="fas fa-user"></i>
                                     My Account
                                </a>
                            </li>
                        <?php else : ?>
                            <li>
                                <a href="/my-account">
                                    <i class="fas fa-sign-in-alt"></i>
                                     Login
                                </a>
                            </li>
                        <?php endif; ?>

                        <li>
                            <a href="/cart">
                                <i class="fas fa-shopping-cart"></i>
                                 Cart 
                                (<?php echo WC()->cart->get_cart_contents_count() ?: 0;?>)
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

