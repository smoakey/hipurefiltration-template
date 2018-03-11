<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( empty( $breadcrumb ) ) {
    return;
}
?>

<nav class="breadcrumb" aria-label="breadcrumbs">
    <ul>
        <?php foreach ($breadcrumb as $crumb) : ?>
            <?php $isLast = $crumb[1] == ''; ?>
            <li <?php echo $isLast ? 'class="is-active"': ''; ?>>
                <a href="<?php echo $isLast ? '#' : $crumb[1]; ?>">
                    <?php echo $crumb[0]; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
