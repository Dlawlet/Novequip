<?php
/**
 * The client-specific functionality of the plugin.
 *
 * @link       https://flutterwave.com
 * @since      2.3.2
 * @class      FLW_WC_Payment_Gateway_Request
 * @package    Flutterwave\WooCommerce\Client
 * @subpackage FLW_WC_Payment_Gateway/includes
 */

namespace Flutterwave\WooCommerce\Client;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class FLW_WC_Gateway_Request file.
 *
 * @package Flutterwave\WooCommerce\Client
 */
final class FLW_WC_Payment_Gateway_Request {

	/**
	 * Count of requests made.
	 *
	 * @var int - count of requests made.
	 */
	protected static int $count = 0;

	/**
	 * Redirect url where the user will be redirected to after payment.
	 *
	 * @var string - redirect url where the user will be redirected to after payment.
	 */
	protected string $notify_url;
	/**
	 * Endpoint request for
	 *
	 * @var string
	 */
	protected string $base_url = 'https://api.flutterwave.com/v3/';

	/**
	 *  Pointer to gateway making the request.
	 */
	public function __construct() {
		$this->notify_url = WC()->api_request_url( 'FLW_WC_Payment_Gateway' );
	}

	/**
	 * Generate a request hash for the request.
	 *
	 * @param array $data This is the request data.
	 *
	 * @return string
	 */
	private function generate_checkout_hash( array $data ): string {
		// format: sha256(amount+currency+customeremail+txref+sha256(secretkey)).
		$complete_hash = '';
		foreach ( $data as $key => $value ) {
			if ( 'secret_key' === $key ) {
				$complete_hash .= hash( 'sha256', $value );
			} else {
				$complete_hash .= $value;
			}
		}
		return hash( 'sha256', $complete_hash );
	}

	/**
	 * This method prepares the payload for the request
	 *
	 * @param \WC_Order $order Order object.
	 * @param string    $secret_key APi key.
	 * @param bool      $testing is ci.
	 * @throws \InvalidArgumentException When the secret key is not spplied.
	 *
	 * @return array
	 */
	public function get_prepared_payload( \WC_Order $order, string $secret_key, bool $testing = false ): array {
		$order_id = $order->get_id();
		$txnref   = 'WOOC_' . $order_id . '_' . time();
		$amount   = (float) $order->get_total();
		$currency = $order->get_currency();
		$email    = $order->get_billing_email();

		if ( $testing ) {
			$txnref = 'WOOC_' . $order_id . '_TEST';
		}

		if ( empty( $secret_key ) ) {
			// let admin know that the secret key is not set.
			throw new \InvalidArgumentException( 'This Payment Method is current unavailable as Administrator is yet to Configure it.Please contact Administrator for more information.' );
		}

		$data_to_hash = array(
			'amount'     => $amount,
			'currency'   => $currency,
			'email'      => $email,
			'tx_ref'     => $txnref,
			'secret_key' => $secret_key,
		);

		$checkout_hash = $this->generate_checkout_hash( $data_to_hash );

		// Parse the base URL to check for existing query parameters.
		$url_parts = wp_parse_url( $this->notify_url );

		// If the base URL already has query parameters, merge them with new ones.
		if ( isset( $url_parts['query'] ) ) {
			// Convert the query string to an array.
			parse_str( $url_parts['query'], $query_array );

			// Add the new parameters to the existing query array.
			$query_array['order_id'] = $order_id;

			// Rebuild the query string with the new parameters.
			$new_query_string = http_build_query( $query_array );

			// Rebuild the final URL with the new query string.
			$callback_url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $new_query_string;
		} else {
			// If no existing query parameters, simply append the new ones.
			$callback_url = add_query_arg(
				array(
					'order_id' => $order_id,
				),
				$this->notify_url
			);
		}

		return array(
			'amount'          => $amount,
			'tx_ref'          => $txnref,
			'currency'        => $currency,
			'payment_options' => 'card',
			'redirect_url'    => $callback_url,
			'payload_hash'    => $checkout_hash,
			'customer'        => array(
				'email'        => $email,
				'phone_number' => $order->get_billing_phone(),
				'name'         => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
			),
			'meta'            => array(
				'consumer_id' => $order->get_customer_id(),
				'ip_address'  => $order->get_customer_ip_address(),
				'user-agent'  => $order->get_customer_user_agent(),
			),
			'customizations'  => array(
				'title'       => get_bloginfo( 'name' ),
				'description' => __( 'Payment for order ', 'rave-woocommerce-payment-gateway' ) . $order->get_order_number(),
			),
		);
	}
}
