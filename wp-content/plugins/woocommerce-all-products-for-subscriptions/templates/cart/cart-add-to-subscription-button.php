<?php
/**
 * Add-Cart-to-Subscription Button Template.
 *
 * Override this template by copying it to 'yourtheme/woocommerce/cart/cart-add-product-to-subscription-button.php'.
 *
 * On occasion, this template file may need to be updated and you (the theme developer) will need to copy the new files to your theme to maintain compatibility.
 * We try to do this as little as possible, but it does happen.
 * When this occurs the version of the template file will be bumped and the readme will list any important changes.
 *
 * @version 2.2.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<button type="submit" class="wcsatt-add-to-subscription-button button add alt" name="add-cart-to-subscription" value="<?php echo $subscription_id; ?>"><?php _e( 'Add', 'woocommerce-all-products-for-subscriptions' ); ?></button>

