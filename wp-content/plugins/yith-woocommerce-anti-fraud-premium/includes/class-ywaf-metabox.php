<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'YWAF_Metabox' ) ) {

	/**
	 * Shows Meta Box in order's details page
	 *
	 * @class   YWAF_Metabox
	 * @package Yithemes
	 * @since   1.0.0
	 * @author  Your Inspiration Themes
	 *
	 */
	class YWAF_Metabox {

		/**
		 * Constructor
		 *
		 * @since   1.0.0
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function __construct() {

			if ( get_option( 'ywaf_enable_plugin' ) == 'yes' ) {

				add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );

			}

		}

		/**
		 * Add a metabox on product page
		 *
		 * @since   1.0.0
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function add_metabox() {

			foreach ( wc_get_order_types( 'order-meta-boxes' ) as $type ) {
				add_meta_box( 'ywaf-metabox', __( 'Fraud Risk Level', 'yith-woocommerce-anti-fraud' ), array( $this, 'output' ), $type, 'side', 'high' );
			}

		}

		/**
		 * Output Meta Box
		 *
		 * The function to be called to output the meta box in product details page.
		 *
		 * @since   1.0.0
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function output() {

			if ( ! isset( $_GET['post'] ) ) {
				return;
			}

			$order_id = $_GET['post'];
			$order    = wc_get_order( $order_id );

			$is_deposit = ( $order->get_created_via() == 'yith_wcdp_balance_order' );

			if ( $is_deposit ) {
				return;
			}

			$risk_factor = $order->get_meta( 'ywaf_risk_factor' );

			?>

            <div class="ywaf-risk-container ywaf-premium">

				<?php if ( $risk_factor ) : ?>

					<?php $data = YITH_WAF()->get_risk_level( $risk_factor['score'] ); ?>

                    <div class="ywaf-risk-container-knob">
                        <div>
                            <label style="background: <?php echo $data['color'] ?>" for="ywaf_risk"><?php echo $risk_factor['score'] ?>%
                                <span><?php echo $data['tip'] ?></span></label>
                            <input
                                id="ywaf_risk"
                                data-fgColor="<?php echo $data['color'] ?>"
                                data-bgColor="#b5b5b6"
                                data-thickness=".25"
                                data-displayInput="false"
                                data-readOnly="true"
                                data-width="200"
                                value="<?php echo $risk_factor['score'] ?>"
                            />
                        </div>

                    </div>

                    <div class="ywaf-rules">

						<?php if ( ! empty( $risk_factor['failed_rules'] ) ) : ?>

                            <div class="ywaf-failed">
                                <ul>
									<?php foreach ( $risk_factor['failed_rules'] as $failed_rule ) : ?>

										<?php if ( class_exists( $failed_rule ) ) : ?>

											<?php $rule = new $failed_rule; ?>

                                            <li><?php echo $rule->get_message(); ?></li>

										<?php endif; ?>

									<?php endforeach; ?>

                                </ul>
                            </div>

						<?php else: ?>

                            <div class="ywaf-success">

								<?php _e( 'Order check was successful!', 'yith-woocommerce-anti-fraud' ) ?>

                            </div>

						<?php endif; ?>

                        <div class="ywaf-nocheck">
                            <p>
                                <button type="button" class="button button-primary ywaf-repeat-check"><?php _e( 'Repeat Check!', 'yith-woocommerce-anti-fraud' ) ?></button>
                            </p>
                        </div>

                    </div>

                    <div class="ywaf-clear"></div>

				<?php else: ?>

                    <div class="ywaf-rules">
                        <div class="ywaf-nocheck">

							<?php

							$check_status  = $order->get_meta( 'ywaf_check_status' );
							$paypal_status = $order->get_meta( 'ywaf_paypal_check' );

							?>

							<?php if ( $check_status == 'process' && ! $paypal_status == 'process' ) : ?>

                                <p>
									<?php _e( 'This order is currently in queue for a fraud risk check.', 'yith-woocommerce-anti-fraud' ); ?>
                                </p>

							<?php elseif ( $paypal_status == 'process' ): ?>

                                <p>
									<?php _e( 'This order is currently waiting for a PayPal verification.', 'yith-woocommerce-anti-fraud' ); ?>
                                </p>

                                <p>
                                    <button type="button" class="button button-primary ywaf-repeat-check"><?php _e( 'Re-send verification request', 'yith-woocommerce-anti-fraud' ) ?></button>
                                </p>

							<?php else: ?>

                                <p>
									<?php _e( 'Press the button to start a fraud risk check', 'yith-woocommerce-anti-fraud' ) ?>
                                </p>
                                <p>
                                    <button type="button" class="button button-primary ywaf-start-check"><?php _e( 'Start checking!', 'yith-woocommerce-anti-fraud' ) ?></button>
                                </p>

							<?php endif; ?>

                        </div>
                    </div>

				<?php endif; ?>

            </div>

			<?php

		}

	}

	new YWAF_Metabox();

}