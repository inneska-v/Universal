
 <footer class="footer">
    <div class="container">
      <div class="footer-menu-bar">
                    <?php dynamic_sidebar( 'sidebar-footer' ); ?>
                </div>
                <!-- footer-menu-bar -->
                <div class="footer-info">
                    <?php
                    if( has_custom_logo() ){
                        echo '<div class="logo">' . get_custom_logo() . '</div>';
                    } else {
                        echo '<span class="logo-name">' . get_bloginfo('name') . '</span>';
                    }

                    wp_nav_menu( [
                        'theme_location'  => 'footer_menu',
                        'container'       => 'nav',
                        'container_class' => 'footer-nav-wrapper',
                        'menu_class'      => 'footer-nav',
                        'echo'            => true,

                    ] );

                    $instance = array(
                        'link_f'  => 'https://facebook.com',
                        'link_i' => 'https://instagram.com',
                        'link_t'   => 'https://twitter.com',
                        'link_y'   => 'https://youtube.com',
                        'title'     => '',
                    );
                    
                    $args = array(
                        'before_widget' => '<div class="footer-social"><div class="widget_content">',
                        'after_widget' => '</div></div>',
                        
                    );
                    
                    the_widget( 'Social_Widget', $instance, $args );

                    ?>
                </div>
                <!-- footer-info -->
                <div class="footer-text-wrapper">
                    <?php dynamic_sidebar( 'sidebar-footer-text' ); ?>
                    <span class="footer-copyright"><?php echo date(' Y ') . '&copy; ' . get_bloginfo(); ?></span>
                </div>
            </div>
        </footer>
        <?php  wp_footer(); ?>
    </body>
</html>
