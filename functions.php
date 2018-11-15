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


?>
