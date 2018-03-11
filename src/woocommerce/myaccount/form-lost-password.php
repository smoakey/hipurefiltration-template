<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
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
    exit;
}

wc_print_notices(); ?>

<form method="post" class="">

    <p>Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.</p>

    <div class="field">
        <label class="label">Username</label>
        <div class="control">
            <input name="user_login" class="input" type="text" placeholder="Username" required />
        </div>
    </div>

    <?php do_action( 'woocommerce_lostpassword_form' ); ?>

    <input type="hidden" name="wc_reset_password" value="true" />

    <div class="field is-grouped">
        <div class="control">
            <button type="submit" value="Reset Password" class="button is-link">Reset Password</button>
        </div>
    </div>
    <?php wp_nonce_field( 'lost_password' ); ?>
</form>
