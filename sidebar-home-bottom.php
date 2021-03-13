<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package universal-theme
 */

if ( ! is_active_sidebar( 'post-sidebar' ) ) {
	return;
}
?>

<aside id="secondary" class="sidebar-front-page">
	<?php dynamic_sidebar( 'post-sidebar' ); ?>
</aside><!-- #secondary -->