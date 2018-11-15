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
	global $product;
	if ( $product->is_type( 'variable' ) ) { // product_type= variable, sample, downloads and so on;
		$text = $product->is_purchasable() ? __( 'My Favourite Name', 'woocommerce' ) : __( 'Read more', 'woocommerce' );
	}
	return $text;
}, 10 );

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

?>
