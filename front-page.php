<?php get_header(); ?>

<main class="front-page-header">
    <div class="container">
        <div class="hero">
            <div class="left">
                <?php
                    global $post;

                    $myposts = get_posts([ 
                    	'numberposts' => 1,
                    	'category_name'  => 'javaScript, css, html, webdesign',
                    ]);

                    if( $myposts ){
                    	foreach( $myposts as $post ){
                    		setup_postdata( $post );
                    ?>
                    <img class="post-thumb" 
                     src="<?php 
                    if( has_post_thumbnail() ) {
                        echo get_the_post_thumbnail_url(null, 'post-thumb');
                            }
                            else {
                                echo get_template_directory_uri().'/assets/images/default-images.png" />';
                            }
                ?>" alt="<?php echo mb_strimwidth(get_the_title(), 0, 40, "...") ; ?>">
                    <?php $author_id = get_the_author_meta('ID'); ?>
                    <a href="<?php echo get_author_posts_url($author_id); ?>" class="author">
                        <img src="<?php echo get_avatar_url($author_id); ?>" alt="<?php echo mb_strimwidth(get_the_title(), 0, 40, "...") ; ?>" class="avatar">
                        <div class="author-bio">
                            <span class="author-name"><?php the_author(); ?></span>
                            <span class="author-rank">Должность</span>
                        </div>
                    </a>
                    <div class="post-text">
                        <?php 
                            foreach (get_the_category() as $category) {
                                printf(
                                    '<a href="%s" class="category-link %s">%s</a>',
                                    esc_url( get_category_link( $category ) ),
                                    esc_html( $category -> slug ),
                                    esc_html( $category -> name ),
                                );
                            }
                        ?>
                        <h2 class="post-title"><?php echo mb_strimwidth(get_the_title(), 0, 60, ' ... '); ?></h2>
                        <a href="<?php echo get_the_permalink(); ?>" class="more">Читать далее</a>
                    </div>
            
                    <?php 
               	        }
                    } else {
               	        // Постов не найдено
                    }
                      wp_reset_postdata(); // Сбрасываем $post
                ?>
            </div>
            <div class="right">
                <h3 class="recommend">Рекомендуем</h3>
                <ul class="posts-list">
                    <?php
                    global $post;

                    $myposts = get_posts([ 
                    	'numberposts' => 5,
                        'offset' => 1,
                        'category_name'  => 'javaScript, css, html, webdesign'
                    ]);

                    if( $myposts ){
                    	foreach( $myposts as $post ){
                    		setup_postdata( $post );
                    ?>
                    <li class="posts">
                            <?php 
                                foreach (get_the_category() as $category) {
                                    printf(
                                        '<a href="%s" class="category-link %s">%s</a>',
                                        esc_url( get_category_link( $category ) ),
                                        esc_html( $category -> slug ),
                                        esc_html( $category -> name ),
                                    );
                                }
                            ?>
                        <a class="posts-permalink" href="<?php echo get_the_permalink() ?>">
                            <h4 class="posts-title"><?php echo mb_strimwidth(get_the_title(), 0, 60, ' ... '); ?></h4>
                        </a>
                    </li>
                    <?php 
               	        }
                    } else {
               	        // Постов не найдено
                    }
                      wp_reset_postdata(); // Сбрасываем $post
                    ?>
                </ul>
            </div>
        </div>
    </div>
</main>
<div class="container">
    <ul class="article-list">
        <?php
        global $post;

        $myposts = get_posts([ 
            'numberposts' => 4,
            'category_name' => 'articles',

        ]);

        if( $myposts ){
            foreach( $myposts as $post ){
                setup_postdata( $post );
        ?>
        <li class="article-item">
            
            <a class="article-permalink" href="<?php echo get_the_permalink() ?>">
                <h4 class="article-title"><?php echo mb_strimwidth(get_the_title(), 0, 50, ' ... '); ?></h4>
            </a>
            <img class="article-thumbnail" 
            src="<?php 
                    if( has_post_thumbnail() ) {
                        echo get_the_post_thumbnail_url(null, 'article-thumb');
                            }
                            else {
                                echo get_template_directory_uri().'/assets/images/default-images.png" />';
                            }
                ?>" alt="<?php echo mb_strimwidth(get_the_title(), 0, 40, "...") ; ?>">          
        </li>
        <?php 
            }
        } else {
            // Постов не найдено
        }
            wp_reset_postdata(); // Сбрасываем $post
        ?>
    </ul>

    
 <!-- grid посты -->
    <div class="main-grid">
        <ul class="article-grid">
            <?php		
            global $post;

            $query = new WP_Query( [
                'posts_per_page' => 7,
                'tag'=> 'popular',
            ] );

            if ( $query->have_posts() ) {

                $cnt = 0;

                while ( $query->have_posts() ) {
                    $query->the_post();

                    $cnt++;
                    switch ($cnt) {

                        // первый пост
                        case '1':
                            ?> 
                            <li class="article-grid-item article-grid-item-1">
                                <a href="<?php the_permalink(); ?>" class="article-grid-permalink">
                                    <span class="category-name">
                                    <!-- выводим первую категорию -->
                                    <?php $category = get_the_category(); echo $category[0]->name;?>
                                    </span>
                                    <h4 class="article-grid-title"><?php the_title(); ?></h4>
                                    <p class="article-grid-texte"><?php echo mb_strimwidth(get_the_excerpt(), 0, 120, ' ... '); ?></p>
                                    <div class="article-grid-info">
                                        <div class="article-grid-author">
                                            <?php $author_id = get_the_author_meta('ID'); ?>
                                            <img class="article-grid-avatar" src="<?php echo get_avatar_url($author_id); ?>" alt="<?php echo mb_strimwidth(get_the_title(), 0, 40, "...") ; ?>">
                                            <span class="article-grid-name"><strong><?php the_author(); ?></strong>: 
                                            <?php echo mb_strimwidth(get_the_author_meta( 'description' ), 0, 30, ' ... '); ?></span>
                                        </div>
                                        <div class="article-grid-comments">
                                        <svg width="19" height="15" fill="#BCBFC2" class="icon comments-icon">
                                            <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#comment"></use>
                                        </svg>                                        
                                        <span class="comments-count-info"> <?php comments_number( '0', '1', '%'); ?></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php 
                            break; 
                            // второй пост
                        case '2': ?>
                            <li class="article-grid-item article-grid-item-2">
                                 <img class="article-grid-thumb" src="<?php 
                                        if( has_post_thumbnail() ) {
                                                echo get_the_post_thumbnail_url();
                                            }
                                            else {
                                                echo get_template_directory_uri().'/assets/images/default-images.png" />';
                                            }
                                ?>" 
                                alt="<?php echo mb_strimwidth(get_the_title(), 0, 40, "...") ; ?>">
                                <a href="<?php the_permalink(); ?>" class="article-grid-permalink">
                                    <!-- выводим первую метку поста -->
                                    <span class="article-grid-tags">
                                        <?php $posttags = get_the_tags();
                                        if ( $posttags ) {
                                            echo $posttags[0]->name . ' ';
                                        }
                                        ?>
                                    </span>
                                    <!-- выводим категорию поста -->
                                    <span class="article-grid-category">
                                    <?php $category = get_the_category(); echo $category[0]->name;?></span>
                                    <h4 class="article-grid-title"><?php the_title(); ?></h4>
                                    <div class="article-grid-info">
                                        <div class="author">
                                            <?php $author_id = get_the_author_meta('ID'); ?>
                                            <img class="author-avatar" src="<?php echo get_avatar_url($author_id); ?>" alt="<?php echo mb_strimwidth(get_the_title(), 0, 40, "...") ; ?>">
                                            <div class="author-info">
                                                <span class="author-info-name"><strong><?php the_author(); ?></strong></span>
                                                <div class="author-info-comments">
                                                    <span class="comments-date"><?php the_time('j F');?></span>
                                                    <svg width="15" height="15" fill="#BCBFC2" class="icon comments-icon">
                                                        <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#comment"></use>
                                                    </svg>                                                    
                                                    <span class="comments-count-info"> <?php comments_number( '0', '1', '%'); ?></span>
                                                     <svg width="15" height="15" fill="#BCBFC2" class="icon likes-icon">
                                                        <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#heart"></use>
                                                    </svg>
                                                    <span class="likes-count"> <?php comments_number( '0', '1', '%'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <?php
                            break;
                            // третий пост
                        case '3': ?>
                            <li class="article-grid-item article-grid-item-3">
                                <a href="<?php the_permalink(); ?>" class="article-grid-permalink">
                                     <img class="article-thumb" 
                                    src="<?php 
                                            if( has_post_thumbnail() ) {
                                                    echo get_the_post_thumbnail_url();
                                                }
                                                else {
                                                    echo get_template_directory_uri().'/assets/images/default-images.png" />';
                                                }
                                        ?>" 
                                    alt="<?php echo mb_strimwidth(get_the_title(), 0, 40, "...") ; ?>">
                                    <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 40, ' ... '); ?></h4>
                                </a>
                            </li>
                            <?php
                            break;
                            // остальные посты
                        default: ?>
                            <li class="article-grid-item article-grid-item-default">
                                <a href="<?php the_permalink(); ?>" class="article-grid-permalink">
                                    <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 20, ' ... '); ?></h4>
                                    <p class="article-grid-texte"><?php echo mb_strimwidth(get_the_excerpt(), 0, 60, ' ... '); ?></p>
                                    <span class="article-grid-date"><?php the_time('j F');?></span>
                                </a>
                            </li>
                            <?php
                            break;
                    }
                    ?>
                    <!-- Вывода постов, функции цикла: the_title() и т.д. -->
                    <?php 
                }
            } else {
                // Постов не найдено
            }
            wp_reset_postdata(); // Сбрасываем $post
            ?>
        </ul>
        <?php get_sidebar('home-top'); ?>
    </div>
</div>
<!-- investigation -->
<?php
    global $post;

    $myposts = get_posts([ 
        'numberposts' => 1,
        'category_name'  => 'investigation',
    ]);

    if( $myposts ){
        foreach( $myposts as $post ){
            setup_postdata( $post );
    ?>
    <section class="investigation" style="background: linear-gradient(0deg, rgba(64, 48, 61, 0.45), rgba(64, 48, 61, 0.45)), url(<?php echo get_the_post_thumbnail_url(); ?>) no-repeat center center; background-size: cover; object-fit: cover; width: 100%;">
        <div class="container">
            <h2 class="investigation-title"><?php the_title(); ?></h2>
            <a href="<?php echo get_the_permalink(); ?>" class="more">Читать далее</a>
        </div>
    </section>

    <?php 
        }
    } else {
        // Постов не найдено
    }
        wp_reset_postdata(); // Сбрасываем $post
?>

<!-- вывод постов с большой обложкой -->
<div class="container">
    <div class="main-records">
        <ul class="records-list">
            <?php
            global $post;

            $myposts = get_posts([ 
                'numberposts' => 6,
                'category_name' => 'articles, pm, hot news'

            ]);

            if( $myposts ){
                foreach( $myposts as $post ){
                    setup_postdata( $post );
            ?>
                    <!-- Вывода постов, функции цикла: the_title() и т.д. -->
            <li class="records-item">
                <img class="records-img" 
                    src="
                        <?php 

                            if( has_post_thumbnail() ) {
                                echo the_post_thumbnail_url();
                            }
                            else {
                                echo get_template_directory_uri().'/assets/images/default-images.png" />';
                            }
                        ?>"
                    alt="<?php echo mb_strimwidth(get_the_title(), 0, 40, "...") ; ?>">
                    <div class="records-name">
                            <?php 
                                foreach (get_the_category() as $category) {
                                    printf(
                                        '<a href="%s" class="category-link %s">%s</a>',
                                        esc_url( get_category_link( $category ) ),
                                        esc_html( $category -> slug ),
                                        esc_html( $category -> name ),
                                    );
                                }
                            ?>
                        
                        
                        <h2 class="records-title"><?php the_title(); ?></h2>
                        <p class="records-description"><?php echo mb_strimwidth(get_the_excerpt(), 0, 160, ' ... '); ?></p>
                        <div class="records-info">
                            <span class="info-date"><?php the_time('j F');?></span>
                            <svg width="15" height="15" class="icon info-icon">
                                <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#comment"></use>
                            </svg>
                            <span class="info-count"> <?php comments_number( '0', '1', '%'); ?></span>
                           <svg width="15" height="15" class="icon info-likes-icon">
                                <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#heart"></use>
                            </svg>
                            <span class="info-likes-count"> <?php comments_number( '0', '1', '%'); ?></span>
                        </div>
                    </div>   
            </li>
            <?php 
                }
            } else {
                // Постов не найдено
            }

            wp_reset_postdata(); // Сбрасываем $post
            ?>
        </ul>
        <?php get_sidebar('home-bottom'); ?>
    </div>
</div>



  <div class="special">
    <div class="container">
        <div class="special-grid">

            <?php
            global $post;

            $myposts = get_posts([ 
                'numberposts' => 1,
                'category_name' => 'photo-report'
            ]);

            if( $myposts ){
                foreach( $myposts as $post ){
                setup_postdata( $post );
            ?>
                    <!-- Вывода постов, функции цикла: the_title() и т.д. -->
                <div class="photo-report">
                    <!-- Slider main container -->
                    <div class="swiper-container photo-report-slider">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            <?php $images = get_attached_media( 'image' );
                                foreach ($images as $image)  {
                                    echo '<div class="swiper-slide"><img src="';
                                    print_r( $image -> guid);
                                    echo '"></div>';
                                }
                            ?>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                    <div class=" photo-report-content">
                  <?php
                    foreach(get_the_category() as $category) {
                      printf(
                        '<a href="%s" class="category-link">%s</a>',
                        esc_url( get_category_link( $category ) ),
                        esc_html( $category -> name )
                      );
                    }
                  ?>
                            <?php $author_id = get_the_author_meta('ID'); ?>
                            <img class="author-avatar" src="<?php echo get_avatar_url($author_id); ?>" 
                            alt="р">
                            <div class="author-bio">
                                <span class="author-name"><strong><?php the_author(); ?></strong></span>
                                <span class="author-rank">Должность</span>
                            </div>
                            <h3 class="photo-report-title"><?php the_title(); ?></h3>
                            <a href="<?php echo get_the_permalink(); ?>" class="button photo-report-button">
                             <svg class="icon photo-report-icon" width="19" height="15">
                              <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/sprite.svg#images' ?>">
                              </use>
                            </svg>
                            Смотреть фото
                            <span class="photo-report-counter"><?php echo count($images) ?></span>
                            </a>

                    </div>
                    <!-- /.photo-report-content -->
                </div>
                <!-- /.photo-report -->
            <?php 
                }
            } else {
                // Постов не найдено
            }

            wp_reset_postdata(); // Сбрасываем $post
            ?>

  <div class="other">
    <div class="career">
          <?php		
          global $post;

          $query = new WP_Query( [
            'posts_per_page' => 1,
            'category_name' => 'career'
          ] );

          if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
              $query->the_post();
          ?>
          <a href="<?php echo get_the_permalink()?>" class="category-link"></a>
          <h3 class="career-title"><?php echo mb_strimwidth(get_the_title( ), 0 ,50, '...') ?></h3>
          <p class="career-excerpt">
            <?php echo mb_strimwidth(get_the_excerpt( ), 0 ,90, '...') ?>
          </p>
          <a href="<?php echo get_the_permalink(); ?>" class="more">Читать далее</a>
          </section>
		<?php 
        }
      } else {
        // Постов не найдено
      }
      ?>
    </div>
        <!-- /.career-post -->



        <div class="other-posts">
        <?php		
          global $post;

          $query = new WP_Query( [
            'posts_per_page' => 2,
            'category_name' => 'others'

          ] );

          if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
              $query->the_post();
          ?>
          <a href="<?php echo get_the_permalink()?>" class="other-post other-post-default">
            <h4 class="other-post-title"><?php echo mb_strimwidth(get_the_title( ), 0 ,25, '...') ?></h4>
            <p class="other-post-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0 ,70, '...') ?></p>
            <span class="other-post-date"><?php the_time('j F'); ?></span>
          </a>
          <?php 
        }
      } else {
        // Постов не найдено
      }
      ?>
        </div>
        <!-- /.other-posts -->
      </div>
      <!-- /.other -->
    </div>
    <!-- /.special-grid -->
  </div>
  <!-- /.container -->
</div>
<!-- /.special -->
<?php get_footer()?>