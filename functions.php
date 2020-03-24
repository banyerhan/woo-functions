<?php

// No.1
function exclude_cat( $q ) {
	
	if( is_shop() || is_page('my-page') ) { // set conditions here
	    $tax_query = (array) $q->get( 'tax_query' );
	
	    $tax_query[] = array(
	           'taxonomy' => 'product_cat',
	           'field'    => 'slug',
	           'terms'    => array('free-book'), // set product categories here
	           'operator' => 'NOT IN'
	    );
	
	
	    $q->set( 'tax_query', $tax_query );
	}
}
add_action('woocommerce_product_query', 'exclude_cat' );

// No.2 
function add_my_content_before_woo_shop() {

        if( is_shop() ){
            echo do_shortcode('[cherry_search_form]');

        }
}
add_action('woo_main_content','add_my_content_before_woo_shop');

// No.3 
add_filter( 'woocommerce_product_add_to_cart_text', function( $text ) {
    if ( 'Read more' == $text ) {
        $text = __( 'View Details', 'woocommerce' );
    }

    return $text;
} );

// No.4
function remove_featured_image($html, $attachment_id, $post_id) {
    $featured_image = get_post_thumbnail_id($post_id);
    if ($attachment_id != $featured_image) {
        return $html;
    }
    return '';
}
add_filter('woocommerce_single_product_image_thumbnail_html', 'remove_featured_image', 10, 3);

// No.5
function custom_override_checkout_fields( $fields )    
{
unset($fields['billing']['billing_country']); // just sample field you can on stackoverflow for related filed name 
return $fields;
}
add_filter('woocommerce_checkout_fields','custom_override_checkout_fields');

// Hide add to cart for ecommerce
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 20);
add_action( 'woocommerce_single_product_summary', 'remove_simple_product_add_to_cart_button', 1 );
function remove_simple_product_add_to_cart_button() {
    global $product;

    // For simple products type
    if( $product->is_type( 'simple' ) && $product->is_purchasable() ) {
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
        add_action( 'woocommerce_single_product_summary', 'show_stock_info', 30 );
    }
}
add_filter( 'woocommerce_is_purchasable', '__return_false' );
// Function that stock info
function show_stock_info() {
    global $product;

    echo wc_get_stock_html( $product );
}

// Hide Price function
add_filter( 'woocommerce_get_price_html', 'react2wp_woocommerce_hide_product_price' );
function react2wp_woocommerce_hide_product_price( $price ) {
    return '';
}

function woo_related_products_limit() {
  global $product;
	
	$args['posts_per_page'] = 6;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'nf_related_products_args', 20 );
  function nf_related_products_args( $args ) {
	$args['posts_per_page'] = 6; // 6 related products
	$args['columns'] = 6; // arranged in 5 columns
	return $args;
}

?>
