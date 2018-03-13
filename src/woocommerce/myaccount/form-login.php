<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php wc_print_notices(); ?>

<form class="" method="post">
    <?php do_action( 'woocommerce_login_form_start' ); ?>

    <div class="field">
        <label class="label">Username</label>
        <div class="control">
            <input name="username" class="input" type="text" placeholder="Username" required />
        </div>
    </div>

    <div class="field">
        <label class="label">Password</label>
        <div class="control">
            <input name="password" class="input" type="password" placeholder="Password" required />
        </div>
    </div>

    <?php do_action( 'woocommerce_login_form' ); ?>

    <div class="field is-grouped">
        <div class="control">
            <button type="submit" name="login" value="Login" class="button is-link">Submit</button>
        </div>
        <div class="control">
            <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="button is-text">Lost your password?</a>
        </div>
    </div>

    <?php if ($_GET['redirect']) : ?>
        <input type="hidden" name="redirect" value="<?php echo $_GET['redirect']; ?>" />
    <?php endif; ?>

    <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>

    <?php do_action( 'woocommerce_login_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
