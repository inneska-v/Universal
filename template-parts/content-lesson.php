<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header <?php echo get_post_type(); ?>-header" 
		style="background: linear-gradient(0deg, rgb(154 208 255 / 75%), #167ac6)">

		<div class="container">
			<div class="post-header-wrapper">
				<?php
					if ( is_singular() ) :
						the_title( '<h1 class="post-title">', '</h1>' );
					else :
						the_title( '<h2 class="post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					endif;
				?>

			</div>
			<!-- end wrapper -->
		</div>
		<!-- end container -->
	</header>
			<!-- end entry-header -->
	
	<div class="container">
    <div class="video">
            <?php
              $video_link = get_field('video_link');
              if ( strpos($video_link, 'youtube') ) :
                $tmp = explode('?v=', get_field('video_link'));
                ?>
                <iframe width="100%" height="450" src="https://www.youtube.com/embed/<?php echo end ($tmp); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
              <?php
              endif;
              if ( strpos($video_link, 'vimeo') ) :
                $tmp = explode('vimeo.com/', get_field('video_link'));
                ?>
                <iframe src="https://player.vimeo.com/video/<?php echo end ($tmp); ?>" width="100%" height="450" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
              <?php
              endif;
            ?>
          </div>
          <div class="video-info">
					<!-- вывод таксономии - жанр -->
				<?php
					$args = array(
						'posts_type' => 'lesson'
					);
					the_taxonomies( $args );
				?>
					<svg width="14" height="14" class="icon info-clock-icon">
						<use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#clock"></use>
					</svg>
					<span class="info-date"><?php the_time('j F G:i');?></span>
			</div>
		<div class="post-content">
			<?php
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'universal-theme' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Страницы:', 'universal-theme' ),
					'after'  => '</div>',
				)
			);
			?>
		</div>
		<!-- .entry-content -->
	

		<!--    Подвал поста    -->
		<div class="post-footer">
			<?php

				$tags_list = get_the_tag_list('', '  ');
				if ( $tags_list ) {
					/* translators: 1: list of tags. */
					printf( '<span class="post-footer-links">' . esc_html__( '%1$s', 'universal-theme' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}

			?>
			<span class="divider"></span>

			<?php meks_ess_share(); ?>
		
		</div>
	</div> <!-- .end container -->
	
		
	<?php get_sidebar('footer-post'); ?>
	
</article>