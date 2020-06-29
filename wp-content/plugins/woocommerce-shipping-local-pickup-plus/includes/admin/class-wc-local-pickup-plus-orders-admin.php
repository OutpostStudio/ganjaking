<?php
/**
 * WooCommerce Local Pickup Plus
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Local Pickup Plus to newer
 * versions in the future. If you wish to customize WooCommerce Local Pickup Plus for your
 * needs please refer to http://docs.woocommerce.com/document/local-pickup-plus/
 *
 * @author      SkyVerge
 * @copyright   Copyright (c) 2012-2020, SkyVerge, Inc.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

defined( 'ABSPATH' ) or exit;

use SkyVerge\WooCommerce\PluginFramework\v5_5_0 as Framework;

/**
 * Admin handler of local pickup data in WooCommerce Orders.
 *
 * @since 2.0.0
 */
class WC_Local_Pickup_Plus_Orders_Admin {


	/**
	 * Add actions/filters for View Orders/Edit Order screen.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

		// add a 'Pickup Locations' column to the orders edit screen
		add_filter( 'manage_edit-shop_order_columns',        array( $this, 'add_pickup_locations_column_header' ), 20 );
		add_action( 'manage_shop_order_posts_custom_column', array( $this, 'add_pickup_locations_column_content' ) );
		add_action( 'admin_head',                            array( $this, 'pickup_locations_column_styles' ) );

		// add a Pickup Location field for each shipping item to edit the Pickup Location ID
		add_action( 'woocommerce_before_order_itemmeta', array( $this, 'output_order_shipping_item_pickup_data_field' ), 1, 2 );

		// filter orders by pickup locations
		add_action( 'restrict_manage_posts', array( $this, 'add_pickup_locations_filter' ), 20, 1 );
		add_filter( 'request',               array( $this, 'filter_orders_by_locations' ), 20, 1 );

		// filter orders by pickup appointment time
		add_action( 'restrict_manage_posts', [ $this, 'add_pickup_appointment_time_filter' ], 20, 1 );
		add_filter( 'request',               [ $this, 'filter_orders_by_appointment_time' ], 20, 1 );
	}


	/**
	 * Adds 'Pickup Locations' column header to 'Orders' page.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 *
	 * @param array $columns
	 * @return array
	 */
	public function add_pickup_locations_column_header( $columns ) {

		$new_columns = array();

		foreach ( $columns as $column_name => $column_info ) {

			$new_columns[ $column_name ] = $column_info;

			if ( 'shipping_address' === $column_name ) {

				$new_columns['pickup_locations'] = __( 'Pickup Locations', 'woocommerce-shipping-local-pickup-plus' );
			}
		}

		return $new_columns;
	}


	/**
	 * Adds 'Pickup Locations' column content to 'Orders' page.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 *
	 * @param array $column name of column being displayed
	 */
	public function add_pickup_locations_column_content( $column ) {
		global $post;

		if ( 'pickup_locations' === $column ) {

			$pickup_location_names = [];
			$order                 = wc_get_order( $post->ID );

			if ( ( $order instanceof \WC_Order || $order instanceof \WC_Order_Refund ) && ! $order instanceof \WC_Subscription ) {

				$order_shipping_items = $order->get_shipping_methods();

				foreach ( $order_shipping_items as $shipping_item_id => $shipping_item ) {

					if ( wc_local_pickup_plus_shipping_method_id() === $shipping_item['method_id'] ) {

						// get name from order item metadata, in case the location was updated after the order was placed
						$pickup_location_name = wc_local_pickup_plus()->get_orders_instance()->get_order_items_instance()->get_order_item_pickup_location_name( $shipping_item_id );

						$pickup_location_id = wc_local_pickup_plus()->get_orders_instance()->get_order_items_instance()->get_order_item_pickup_location_id( $shipping_item_id );
						$pickup_location_id = is_numeric( $pickup_location_id ) ? (int) $pickup_location_id : null;
						$pickup_location    = wc_local_pickup_plus_get_pickup_location( $pickup_location_id );

						if ( $pickup_location instanceof \WC_Local_Pickup_Plus_Pickup_Location ) {

							if ( $pickup_location->get_name() !== $pickup_location_name ) {

								// location name was changed - display both names
								$pickup_location_names[ $pickup_location_name ] = sprintf(
									/* translators: Placeholders: %1$s new location name, %2$s previous location name, %3$s <a> tag, %4$s </a> tag, %5$s <small> tag, %6$s </small> tag */
									__( '%1$s%5$s (renamed to %3$s%2$s%4$s)%6$s', 'woocommerce-shipping-local-pickup-plus' ),
									$pickup_location_name,
									$pickup_location->get_name(),
									'<a href="' . esc_url( get_edit_post_link( $pickup_location->get_id() ) ) . '">',
									'</a>',
									'<small>',
									'</small>'
								);

							} else {

								// location name was not changed
								$pickup_location_names[ $pickup_location_name ] = '<a href="' . esc_url( get_edit_post_link( $pickup_location->get_id() ) ) . '">' . $pickup_location_name . '</a>';
							}

						} elseif ( '' !== $pickup_location_name ) {

							// location was deleted - display without a link
							$pickup_location_names[ $pickup_location_name ] = $pickup_location_name;
						}
					}
				}
			}

			if ( ! empty( $pickup_location_names ) ) {
				// display all the pickup locations for this order
				$output = implode( '<br />', $pickup_location_names );
			} else {
				// this order should have no items for pickup
				$output = '&ndash;';
			}

			echo $output;
		}
	}


	/**
	 * Adds CSS to style the 'Pickup Locations' column.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 */
	public function pickup_locations_column_styles() {

		$screen = get_current_screen();

		if ( $screen && 'edit-shop_order' === $screen->id ) :

			?>
			<style type="text/css">
				.widefat .column-pickup_locations {
					width: 11%;
				}
			</style>
			<?php

		endif;
	}


	/**
	 * Show an input to filter orders by pickup location.
	 *
	 * @see \WC_Local_Pickup_Plus_Orders_Admin::filter_orders_by_locations()
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 *
	 * @param string $screen the screen ID (equivalent to $typenow global)
	 */
	public function add_pickup_locations_filter( $screen ) {

		if ( 'shop_order' === $screen ) {

			$pickup_location_id   = ! empty( $_GET['_pickup_location'] ) ? absint( $_GET['_pickup_location'] ) : '';
			$pickup_location      = $pickup_location_id > 0 ? wc_local_pickup_plus_get_pickup_location( $pickup_location_id ) : null;
			$pickup_location_name = $pickup_location instanceof \WC_Local_Pickup_Plus_Pickup_Location ? esc_html__( $pickup_location->get_name() ) : '';
			$filter_input_args    = array(
				'id'                => 'wc-local-pickup-plus-pickup-location-search',
				'input_name'        => '_pickup_location',
				'class'             => 'wc-local-pickup-plus-pickup-location-search',
				'css'               => 'display:block;float:left;width:100%;max-width:216px;margin-right: 6px;',
				'value'             => $pickup_location,
				'custom_attributes' => array(
					'data-allow_clear' => true,
					'data-placeholder' => __( 'Search for a location&hellip;', 'woocommerce-shipping-local-pickup-plus' ),
				),
			);

			wc_local_pickup_plus()->get_admin_instance()->output_search_pickup_locations_field( $filter_input_args );
		}
	}


	/**
	 * Filter orders query by locations.
	 *
	 * @see \WC_Local_Pickup_Plus_Orders_Admin::add_pickup_locations_filter()
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 *
	 * @param array $query_vars query variables
	 * @return array
	 */
	public function filter_orders_by_locations( $query_vars ) {
		global $typenow;

		if (    'shop_order' === $typenow
		     && isset( $_GET['_pickup_location'] )
		     && $_GET['_pickup_location'] > 0
		     && ( $orders_handler = wc_local_pickup_plus()->get_orders_instance() ) ) {

			$order_ids = $orders_handler->get_pickup_location_order_ids( $_GET['_pickup_location'] );

			// if no orders are found, show no orders then
			$query_vars['post__in'] = ! empty( $order_ids ) ? $order_ids : array( 0 );
		}

		return $query_vars;
	}


	/**
	 * Shows an input to filter orders by pickup appointment time, if appointments are offered.
	 *
	 * @see \WC_Local_Pickup_Plus_Orders_Admin::filter_orders_by_appointment_time()
	 *
	 * @internal
	 *
	 * @since 2.7.0
	 *
	 * @param string $screen the screen ID (equivalent to $typenow global)
	 */
	public function add_pickup_appointment_time_filter( $screen ) {

		if ( 'shop_order' === $screen && 'disabled' !== wc_local_pickup_plus()->get_shipping_method_instance()->pickup_appointments_mode() ) :

			$appointment_time = ! empty( $_GET['_appointment_time'] ) ? $_GET['_appointment_time'] : '';
			$options          = [
				''          => __( 'All pickup dates', 'woocommerce-shipping-local-pickup-plus' ),
				'today'     => __( 'Pickup today', 'woocommerce-shipping-local-pickup-plus' ),
				'tomorrow'  => __( 'Pickup tomorrow', 'woocommerce-shipping-local-pickup-plus' ),
				'this_week' => __( 'Pickup this week', 'woocommerce-shipping-local-pickup-plus' ),
				'next_week' => __( 'Pickup next week', 'woocommerce-shipping-local-pickup-plus' ),
			];

			?>
			<select
				name="_appointment_time"
				id="wc-local-pickup-plus-appointment-time-search"
				class="wc-local-pickup-plus-appointment-time-search">
				<?php foreach ( $options as $key => $label ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>"
						<?php selected( $appointment_time, $key ); ?>
					><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
			<?php

		endif;
	}


	/**
	 * Filter orders query by pickup appointment time.
	 *
	 * @see \WC_Local_Pickup_Plus_Orders_Admin::add_pickup_appointment_time_filter()
	 *
	 * @internal
	 *
	 * @since 2.7.0
	 *
	 * @param array $query_vars query variables
	 * @return array
	 * @throws Exception
	 */
	public function filter_orders_by_appointment_time( $query_vars ) {
		global $typenow;

		if (      'shop_order' === $typenow
		     && ! empty( $_GET['_appointment_time'] )
		     &&   ( $orders_handler = wc_local_pickup_plus()->get_orders_instance() ) ) {

			switch ( $_GET['_appointment_time'] ) {

				case 'today':
					$start = new DateTime( 'today', new DateTimeZone( wc_timezone_string() ) );
					$end   = new DateTime( 'tomorrow', new DateTimeZone( wc_timezone_string() ) );
					$end->sub( new DateInterval( 'PT1S' ) );
				break;

				case 'tomorrow':
					$start = new DateTime( 'tomorrow', new DateTimeZone( wc_timezone_string() ) );
					$end   = new DateTime( 'tomorrow', new DateTimeZone( wc_timezone_string() ) );
					$end->add( new DateInterval( 'P1D' ) );
					$end->sub( new DateInterval( 'PT1S' ) );
				break;

				case 'this_week':
					$today = new DateTime( 'today' );
					$week  = get_weekstartend( $today->format( 'Y-m-d' ) );
					$start = new DateTime( date( 'Y-m-d H:i:s', $week['start'] ), new DateTimeZone( wc_timezone_string() ) );
					$end   = new DateTime( date( 'Y-m-d H:i:s', $week['end'] ), new DateTimeZone( wc_timezone_string() ) );
				break;

				case 'next_week':
					$one_week_from_today = new DateTime( 'today' );
					$one_week_from_today->add( new DateInterval( 'P1W' ) );
					$week  = get_weekstartend( $one_week_from_today->format( 'Y-m-d' ) );
					$start = new DateTime( date( 'Y-m-d H:i:s', $week['start'] ), new DateTimeZone( wc_timezone_string() ) );
					$end   = new DateTime( date( 'Y-m-d H:i:s', $week['end'] ), new DateTimeZone( wc_timezone_string() ) );
				break;
			}

			if ( ! empty( $start ) && ! empty( $end ) ) {

				$order_ids = $orders_handler->get_orders_by_appointment_range( $start->getTimestamp(), $end->getTimestamp() );

				// if no orders are found, show no orders then
				$query_vars['post__in'] = ! empty( $order_ids ) ? $order_ids : [ 0 ];
			}
		}

		return $query_vars;
	}


	/**
	 * Get a special composite field for handling order shipping item pickup data.
	 *
	 * @internal
	 *
	 * @since 2.0.0
	 *
	 * @param int $item_id order shipping item ID
	 * @param array $item order shipping item array
	 */
	public function output_order_shipping_item_pickup_data_field( $item_id, $item ) {
		global $post;

		$order = wc_get_order( $post );

		if ( empty( $order ) && ! empty( $_POST['order_id'] ) && is_ajax() ) {
			$order = wc_get_order( $_POST['order_id'] );
		}

		$shipping_method = isset( $item['method_id'] ) ? $item['method_id'] : null;

		if (      $order instanceof \WC_Order
			 && ! $order instanceof \WC_Subscription
			 &&   ( wc_local_pickup_plus_shipping_method_id() === $shipping_method ) ) :

			$local_pickup_plus = wc_local_pickup_plus();
			$items_to_choose   = $order->get_items();
			$items_to_pickup   = ! empty( $item['pickup_items'] ) ? array_map( 'absint', maybe_unserialize( $item['pickup_items'] ) ) : array();
			$pickup_location   = isset( $item['pickup_location_id'] ) ? wc_local_pickup_plus_get_pickup_location( $item['pickup_location_id'] ) : null;
			$pickup_date       = null;
			$appointment       = $local_pickup_plus->get_appointments_instance()->get_shipping_item_appointment( $item_id );

			if ( $appointment ) {
				$pickup_date = $appointment->get_start();
			}

			$anytime_appointments_enabled = $pickup_location ? $pickup_location->get_appointments()->is_anytime_appointments_enabled() : wc_local_pickup_plus_shipping_method()->is_anytime_appointments_enabled();

			$pickup_locations_field = $local_pickup_plus->get_admin_instance()->get_search_pickup_locations_field( [
				'id'                => 'wc-local-pickup-plus-pickup-location-search-for-item-' . $item_id,
				'input_name'        => '_pickup_location[' . $item_id .']',
				'class'             => 'wc-local-pickup-plus-pickup-location-search',
				'css'               => 'display:block;float:left;width:100%;max-width:376px;margin-right: 6px;',
				'value'             => $pickup_location,
				'custom_attributes' => [
					'data-item-id'     => $item_id,
					'data-allow_clear' => true,
					'data-placeholder' => __( 'Search for a location&hellip;', 'woocommerce-shipping-local-pickup-plus' ),
					'data-selected'    => $pickup_location instanceof \WC_Local_Pickup_Plus_Pickup_Location ? htmlspecialchars( $pickup_location->get_name() ) : '',
				],
			] );

			?>
			<div
				id="wc-local-pickup-plus-order-shipping-item-pickup-data-<?php echo $item_id; ?>"
				class="wc-local-pickup-plus wc-local-pickup-plus-order-shipping-item-pickup-data view">
				<table
					class="display_meta">

					<tbody>

						<tr>
							<th><label for="<?php echo 'wc-local-pickup-plus-pickup-location-search-for-item-' . $item_id; ?>"><?php esc_html_e( 'Pickup Location:', 'woocommerce-shipping-local-pickup-plus' ); ?></label></th>
							<td class="pickup-location">
								<div class="value">
									<?php echo esc_html( wc_local_pickup_plus()->get_orders_instance()->get_order_items_instance()->get_order_item_pickup_location_name( $item_id ) ); ?><br />
									<?php echo esc_html( wc_local_pickup_plus()->get_orders_instance()->get_order_items_instance()->get_order_item_pickup_location_address( $item_id, 'plain' ) ); ?><br />
									<?php echo esc_html( wc_local_pickup_plus()->get_orders_instance()->get_order_items_instance()->get_order_item_pickup_location_phone( $item_id, false ) ); ?>
								</div>
								<div class="field" style="display:none;">
									<?php echo $pickup_locations_field; ?>
								</div>
							</td>
						</tr>

						<?php // display appointment information if the shipping item has appointment data, whether appointments are currently enabled or not ?>
						<?php if ( $appointment && $pickup_date ) : ?>

							<?php // we will hide appointment date and time form fields if appointments are disabled ?>
							<tr class="<?php echo esc_attr( 'disabled' === wc_local_pickup_plus_appointments_mode() ? 'js-wc-local-pickup-plus-hide-on-edit' : '' ); ?>">
								<th><label for="<?php echo 'wc-local-pickup-plus-pickup-date-for-item-' . $item_id; ?>"><?php esc_html_e( 'Pickup Date:', 'woocommerce-shipping-local-pickup-plus' ); ?></label></th>
								<td class="pickup-date">
									<div class="value">
										<?php if ( $pickup_date && $appointment->is_anytime() ) : ?>
											<?php echo esc_html( date_i18n( wc_date_format(), $pickup_date->getTimestamp() + $pickup_date->getOffset() ) ); ?>
										<?php elseif ( $pickup_date ) : ?>
											<?php /* translators: %1$s - the formatted date, %2$s - the formatted time */ ?>
											<?php echo esc_html( sprintf( __( '%1$s at %2$s', 'woocommerce' ), date_i18n( wc_date_format(), $pickup_date->getTimestamp() + $pickup_date->getOffset() ), date_i18n( wc_time_format(), $pickup_date->getTimestamp() + $pickup_date->getOffset() ) ) ); ?>
										<?php else : ?>
											&mdash;
										<?php endif; ?>
									</div>
									<div class="field" style="display:none;">
										<input
											name="_pickup_date[<?php echo $item_id; ?>]"
											id="<?php echo 'wc-local-pickup-plus-pickup-date-for-item-' . $item_id; ?>"
											class="pickup-date"
											type="text"
											value="<?php echo $pickup_date ? date( 'Y-m-d', $pickup_date->getTimestamp() + $pickup_date->getOffset() ) : ''; ?>"
											readonly="readonly"
										/>
										<?php if ( ! $anytime_appointments_enabled ) : ?>
											<span class="wc-local-pickup-plus-date-time-separator">@</span>
											<?php $selected_offset = $pickup_date ? ( $pickup_date->getTimestamp() - ( clone $pickup_date )->setTime( 0, 0, 0 )->getTimestamp() ) : 0; ?>
											<select
												id="wc-local-pickup-plus-pickup-appointment-offset-for-item-<?php echo $item_id; ?>"
												class="wc-local-pickup-plus-appointment-offset"
												name="_pickup_appointment_offset[<?php echo $item_id; ?>]"
												style="width:100%;">
												<?php for ( $t = 0; $t <= DAY_IN_SECONDS; $t += 0.25 * HOUR_IN_SECONDS ) : ?>
													<option value="<?php echo esc_attr( $t ); ?>" <?php selected( $t, $selected_offset ); ?>><?php echo esc_html( date_i18n( wc_time_format(), $t ) ); ?></option>
												<?php endfor; ?>
											</select>
										<?php endif; ?>
									</div>
								</td>
							</tr>

						<?php endif; ?>

						<tr>
							<th><label for="<?php echo 'wc-local-pickup-plus-pickup-items-for-item-' . $item_id; ?>"><?php esc_html_e( 'Items to Pickup:', 'woocommerce-shipping-local-pickup-plus' ); ?></label></th>
							<td class="pickup-items">
								<div class="value">
									<?php $items = array(); ?>
									<?php foreach ( $items_to_choose as $id => $item_data ) : ?>
										<?php if ( isset( $item_data['name'], $item_data['qty'] ) && in_array( $id, $items_to_pickup, false ) ) : ?>
											<?php $items[] = is_rtl() ? '&times; ' . $item_data['qty'] . ' ' . $item_data['name'] : $item_data['name'] . ' &times; ' . $item_data['qty']; ?>
										<?php endif; ?>
									<?php endforeach; ?>
									<?php echo ! empty( $items ) ? implode( ', ', $items ) : '&mdash;'; ?>
								</div>
								<div class="field" style="display:none;">
									<select
										name="_pickup_items[<?php echo $item_id; ?>]"
										id="<?php echo 'wc-local-pickup-plus-pickup-items-for-item-' . $item_id; ?>"
										class="wc-enhanced-select"
										style="width: 100%;"
										multiple="multiple">
										<option value=""></option>
										<?php foreach ( $items_to_choose as $id => $item_data ) : ?>
											<?php $name = isset( $item_data['name'] ) ? $item_data['name'] : null; ?>
											<?php $qty  = isset( $item_data['qty'] )  ? $item_data['qty']  : null; ?>
											<?php if ( $name && $qty ) : ?>
												<?php $label = is_rtl() ? '&times; ' . $qty . ' ' . $name : $name . ' &times; ' . $qty; ?>
												<option value="<?php echo $id; ?>" <?php selected( true, in_array( $id, $items_to_pickup, false ) ); ?>><?php esc_html_e( $label ); ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							</td>
						</tr>

					</tbody>

					<?php if ( $order->is_editable() ) : ?>

					<tfoot>
						<tr>
							<td><button class="button edit-pickup-data"><?php esc_html_e( 'Edit', 'woocommerce-shipping-local-pickup-plus' ); ?></button></td>
							<td><button class="button-primary update-pickup-data" style="display:none;"><?php esc_html_e( 'Update Pickup Information', 'woocommerce-shipping-local-pickup-plus' ); ?></button></td>
						</tr>
					</tfoot>

					<?php endif; ?>

				</table>
			</div>
			<?php

			wc_enqueue_js( '

				jQuery( document ).ready( function( $ ) {

					var $field     = $( "#wc-local-pickup-plus-order-shipping-item-pickup-data-' . $item_id . '" ),
						$row       = $field.parent( "td" ).parent( "tr" ),
						$pencil    = $row.find( ".edit-order-item" ),
						$locationV = $field.find( "td.pickup-location .value" ),
						$locationF = $field.find( "td.pickup-location .field" ),
						$dateV     = $field.find( "td.pickup-date .value" ),
						$dateF     = $field.find( "td.pickup-date .field" ),
						$itemsV    = $field.find( "td.pickup-items .value" ),
						$itemsF    = $field.find( "td.pickup-items .field" ),
						$editBtn   = $field.find( "button.edit-pickup-data" ),
						$updateBtn = $field.find( "button.update-pickup-data" ),
						originalValues, updateShippingItemPickupData;

					originalValues = {
						pickupDate:              $dateF.find( "input" ).val(),
						pickupAppointmentOffset: $dateF.find( ".wc-local-pickup-plus-appointment-offset" ).val(),
					};

					updateShippingItemPickupData = function( force ) {

						var data = {
							"action" :                    "wc_local_pickup_plus_update_order_shipping_item_pickup_data",
							"item_id" :                   ' . (int) $item_id . ',
							"pickup_location" :           $locationF.find( "select#wc-local-pickup-plus-pickup-location-search-for-item-' . $item_id . '" ).val(),
							"pickup_date" :               $dateF.find( "input" ).val(),
							"pickup_appointment_offset" : $dateF.find( ".wc-local-pickup-plus-appointment-offset" ).val(),
							"pickup_items" :              $itemsF.find( "select" ).val(),
							"security" :                  wc_local_pickup_plus_admin.update_order_pickup_data_nonce,
							"force" :                     force ? 1 : 0
						};

						$.post( wc_local_pickup_plus_admin.ajax_url, data, function( response ) {

							if ( response && response.success ) {

								location.reload();

							} else if ( response && response.data && "appointment-time-not-available" === response.data.error && response.data.message ) {

								if ( window.confirm( response.data.message ) ) {
									updateShippingItemPickupData( true );
								} else {
									$dateF.find( "input" ).val( originalValues.pickupDate ).trigger( "change" );
									$dateF.find( ".wc-local-pickup-plus-appointment-offset" ).val( originalValues.pickupAppointmentOffset ).trigger( "change" );
								}

							} else {

								console.log( response );
							}
						} );
					};

					$editBtn.on( "click", function( e ) {
						e.preventDefault();

						$locationF.show();
						$locationV.hide();
						$itemsF.show();
						$itemsV.hide();
						$( this ).hide();
						$updateBtn.show();

						if ( $dateF.closest( "tr" ).hasClass( "js-wc-local-pickup-plus-hide-on-edit" ) ) {
							$dateF.closest( "tr" ).hide();
						} else {
							$dateF.show();
							$dateV.hide();
						}
					} );

					$updateBtn.on( "click", function( e ) {

						e.preventDefault();

						updateShippingItemPickupData();
					} );

					$pencil.hide();
				} );
			' );

		endif;
	}


}
