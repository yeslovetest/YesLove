<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
?>
<form id="top-search-form-two" class="header-search-form header-s2" action="<?php echo esc_url( home_url( '/' ) ) ?>" method="get">
	<div class="input-group">
	    <input type="text" name="s" value="<?php get_search_query() ?>" class="form-control" placeholder="<?php esc_attr_e( 'Search here...', 'cirkle' ); ?>">
	    <div class="input-group-append">
	        <button class="submit-btn" type="button"><i class="icofont-search"></i></button>
	    </div>
	</div>
</form>

<div class="cirkle-search-result search-result-dislogbox">
	<div class="cirkle-search-member">
		<h6><?php esc_html_e( 'Members', 'cirkle' ) ?></h6>
		<ul class="cirkle-search-member-content cirkle-member-list"> 
			<li><span></span></li>
		</ul>
	</div>

	<div class="cirkle-search-group">
		<h6><?php esc_html_e( 'Groups', 'cirkle' ) ?></h6>
		<ul class="cirkle-search-group-content cirkle-member-list">
			<li><span></span></li>
		</ul>
	</div>

	<div class="cirkle-search-post">
		<h6><?php esc_html_e( 'Posts', 'cirkle' ) ?></h6>
		<ul class="cirkle-search-post-content cirkle-member-list">
			<li><span></span></li>
		</ul>
	</div>
	<div class="cirkle-search-product">
		<h6><?php esc_html_e( 'Products', 'cirkle' ) ?></h6>
		<ul class="cirkle-search-product-content cirkle-member-list">
			<li><span></span></li>
		</ul>
	</div>
</div>

