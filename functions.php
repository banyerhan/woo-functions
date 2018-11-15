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
