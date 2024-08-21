<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
?>
<a href="#header-search" title="<?php esc_attr_e( 'Search', 'cirkle' ); ?>"><i class="icofont-search"></i></a>
<!--=====================================-->
<!--=      Header Search Start          =-->
<!--=====================================-->
<div id="header-search" class="header-search">
    <button type="button" class="close">×</button>
    <form id="top-search-form" class="header-search-form" action="<?php echo esc_url( home_url( '/' ) ) ?>" method="get">
        <input type="search" name='s' value="<?php get_search_query() ?>" class="search-input" placeholder="<?php esc_attr_e( 'Search here...', 'cirkle' ); ?>">
        <button type="submit" class="search-btn">
            <i class="flaticon-search"></i>
        </button>
    </form>
</div>
