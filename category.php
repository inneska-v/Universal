<?php get_header()?>
<main class="category">
  <div class="container">
    <h1 class="category-title">
      <?php single_cat_title() ?>
    </h1>
      <ul class="post-list">
      <?php while ( have_posts() ){ the_post(); ?>
        <li class="post-item">
          <a href="<?php the_permalink() ?>" class="post-permalink">
            <div class="post-card">
              <img src="<?php
                if( has_post_thumbnail() ) {
                  echo get_the_post_thumbnail_url();
                }
                else {
                  echo get_template_directory_uri().'/assets/images/default-images.png"';
                } ?>" alt="<?php the_title()?>" class="post-card-thumb">
              <div class="post-card-text">
                <h2 class="post-card-title">
                  <?php the_title()?>
                </h2>
                <p><?php echo mb_strimwidth(get_the_excerpt(), 0, 60, ' ... '); ?></p>
                   <div class="author">
                    <?php $author_id = get_the_author_meta('ID'); ?>
                     <img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="author-avatar">
                        <div class="author-info">
                            <span class="author-name"><strong><?php the_author(); ?></strong></span>
                            <span class="date"><?php the_time('j F');?></span>
                            <div class="comments">
                            <svg width="15" height="15" fill="#BCBFC2" class="icon info-comment-icon">
						                  <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#comment"></use>
					                  </svg>
                            <span class="info-comment-count"> <?php comments_number( '0', '1', '%'); ?></span>
                            </div>
                            <div class="likes">
                            <svg width="14" height="14" fill="#BCBFC2" class="icon info-likes-icon">
						                  <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#heart"></use>
				                    	</svg>
					                    <span class="info-likes-count"> <?php comments_number( '0', '1', '%'); ?></span>
                            </div>
                        </div>
                    <!-- /.author-info -->
                    </div>
                    <!-- /.author -->
            </div>
          </a>
        </li>
        <!-- /.card -->
      <?php } ?>
      <?php if ( ! have_posts() ){ ?>
        Записей нет.
      <?php } ?>
    </ul>
    <!-- /.post-list -->
    <?php
    $prev = '<svg class="icon" width="15" height="7">
        <use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#left-arrow"></use>
      </svg> Назад';
    $next = 'Вперед <svg class="icon" width="15" height="7">
        <use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#arrow"></use>
      </svg>';
    $args = array(
      'prev_text' => $prev,
      'next_text' => $next
    );
    the_posts_pagination( $args);
    ?>
  </div>
</main>
<!-- /.container -->
<?php get_footer()?>