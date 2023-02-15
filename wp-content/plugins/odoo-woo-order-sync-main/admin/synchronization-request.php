<?php


add_action( 'woocommerce_payment_complete', 'send_request_after_order_complete' );

function send_request_after_order_complete( $order_id ) {
  // Get the order object
  $order = wc_get_order( $order_id );

  // Set up the API URL and request body
  $api_url = get_option( 'odoo_sync_settings' )['odoo_endpoint_url'];
  $pipedream_copy = get_option( 'odoo_sync_settings' )['pipedream_url'];
  $bearer_token = get_option( 'odoo_sync_settings' )['bearer_token'];
  $shipping_reference = get_option( 'odoo_sync_settings' )['shipping_internal'];

  // Create the request body
  $request_body = array(
    'invoice_address' => array(
      'name' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
      'street' => $order->get_billing_address_1(),
      'street2' => $order->get_billing_address_2(),
      'city' => $order->get_billing_city(),
      'zip' => $order->get_billing_postcode(),
      'phone' => $order->get_billing_phone(),
      'email' => $order->get_billing_email(),
      'country' => $order->get_billing_country(),
      'state' => 'NO'
    ),
    'shipping_address' => array(
      'name' => $order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name(),
      'street' => $order->get_shipping_address_1(),
      'street2' => $order->get_shipping_address_2(),
      'city' => $order->get_shipping_city(),
      'zip' => $order->get_shipping_postcode(),
      'phone' => $order->get_billing_phone(),
      'email' => $order->get_billing_email(),
      'country' => $order->get_shipping_country(),
      'state' => 'NO'
    ),
    'items' => array(),
    'order_date' => $order->get_date_created()->format( 'Y-m-d H:i:s' ),
    'order_reference' => $order->get_order_number()
  );

  // Add each item to the items array
  foreach ( $order->get_items() as $item ) {
    $product = $item->get_product();
    $request_body['items'][] = array(
      'product_code' => $product->get_sku(),
      'product_name' => $product->get_name(),
      'qty' => $item->get_quantity(),
      'unit_of_measure' => 'item',
      'price_sold' => $product->get_price(),
      'price' => $product->get_price_excluding_tax(),
    );
  }

  // Add shipping as an item
  $request_body['items'][] = array(
      'product_code' => $shipping_reference,
      'product_name' => 'Shipping',
      'qty' => 1,
      'unit_of_measure' => 'item',
      'price' => $order->get_shipping_total(),
  );

  // Send the copy request to pipedream
  $copy_response = wp_remote_post( $pipedream_copy, array(
    'body' => json_encode( $request_body ),
    'headers' => array(
        'Authorization' => 'Bearer ' . $bearer_token,
        'Content-Type' => 'application/json'
    ),
  ) );

  // Send the request to Odoo
  $response = wp_remote_post( $api_url, array(
    'body' => json_encode( $request_body ),
    'headers' => array(
        'Authorization' => 'Bearer ' . $bearer_token,
        'Content-Type' => 'application/json'
    ),
  ) );

  // Retrieve the answer body (Odoo request)
  $response_body = wp_remote_retrieve_body( $response );

  // Parse the JSON string into a PHP object
  $response_data = json_decode( $response_body );

  // Create message to be filled with response data

  if ( NULL !==  $response_data) {
    $odoo_message = "";
  } else {
    $odoo_message = "NO RESPONSE FROM ODOO";
  }

  // Check if the "message" value is set
  if ( NULL !==  $response_data->result->message ) {
    // Save a custom note on the order
    $order->add_order_note( 'Odoo message: ' . $response_data->result->message );
    // Append odoo message
    $odoo_message .= 'Odoo message: ' . $response_data->result->message ;
  }

  // Check if the "error" value is set
  if ( NULL !==  $response_data->result->error ) {
    // Save a custom note on the order
    $order->add_order_note( 'Odoo error: ' . $response_data->result->error );
    // Append odoo message
    $odoo_message .= "\n" . 'Odoo error: ' . $response_data->result->error ;
  }

  // Check if the "status" value is set
  if ( NULL !==  $response_data->result->status ) {
    // Save a custom note on the order
    $order->add_order_note( 'Odoo status: ' . $response_data->result->status );
    // Append odoo message
    $odoo_message .= "\n" . 'Odoo status: ' . $response_data->result->status ;
  }

  // Update the message field
  update_post_meta( $order->get_id(), 'odoo_raw_answer', $odoo_message );


  // Check if the "order_id" value is set
  if ( NULL !==  $response_data->result->order_id ) {
    // Save a custom note on the order
    $order->add_order_note( 'Odoo order_id: ' . $response_data->result->order_id );
    update_post_meta( $order->get_id(), 'odoo_reference', $response_data->result->order_id );
  } else {
    update_post_meta( $order->get_id(), 'odoo_reference', "FAILED SYNC" );
  }
    
}
