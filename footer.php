
 <footer class="footer">
    <div class="container">
        <div class="footer-form-wrapper">
                    <h3 class="footer-form-title">Подпишитесь на нашу рассылку</h3>
                    <form action="https://app.getresponse.com/add_subscriber.html" accept-charset="utf-8" method="post" class="footer-form">
                        <!-- Поле Email (обязательно) -->
                        <input required type="text" name="email" placeholder="Введите email" class="input footer-form-input"/>
                        <input type="hidden" name="campaign_token" value="KEOQZ" />
                        <!-- Страница благодарности -->
                        <input type="hidden" name="thankyou_url" value="<?php echo home_url( 'thankyou' )?>"/>
                        <!-- Добавить подписчика в цикл на определенный день (по желанию) -->
                        <input type="hidden" name="start_day" value="0" />
                        <!-- Кнопка подписаться -->
                        <button type="submit">Подписаться</button>
                    </form>
        </div>
                <!-- /.footer-form -->
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
