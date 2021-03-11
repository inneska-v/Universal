<?php

//   Добавляем расширенные возможности
if ( ! function_exists( 'universal_theme_setup' ) ) :

    function universal_theme_setup() {
        // title-tag
        add_theme_support( 'title-tag' );

        // Миниатюры
        add_theme_support( 'post-thumbnails', array( 'post' ) );

        // logo
        add_theme_support( 'custom-logo', [
            'width'      => 163,
            'flex-height' => true,
            'header-text' => 'Universal',
            'unlink-homepage-logo' => false, // WP 5.5
        ] );
        // menu
        register_nav_menus( [
            'header_menu' => 'Меню в шапке',
            'footer_menu' => 'Меню в подвале'
        ] );

    }
endif;
add_action( 'after_setup_theme', 'universal_theme_setup' );

//  Регистрация виджета.
 
function universal_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Сайдбар на главной', 'universal-theme' ),
			'id'            => 'main-sidebar',
			'description'   => esc_html__( 'Добавте виджет сюда...', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
    register_sidebar(
		array(
			'name'          => esc_html__( 'Недавно опубликовано', 'universal-theme' ),
			'id'            => 'post-sidebar',
			'description'   => esc_html__( 'Добавте виджет сюда...', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'universal_theme_widgets_init' );

//    Создаем свой виджет !

/**
 * Добавление нового виджета Downloader_Widget.
 */
class Downloader_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'downloader_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: downloader_widget
			'Полезные файлы',
			array( 'description' => 'Файлы для скачивания', 'classname' => 'widget-downloader', )
		);

		// скрипты/стили виджета, только если он активен

		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_downloader_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_downloader_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {

		$title = $instance['title'];
		$description = $instance['description'];
		$link = $instance['link'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
        if ( ! empty( $description ) ) {
			echo '<p class="widget-description">' . $description . '</p>';
		}
        if ( ! empty( $link ) ) {
			echo '<a target= "_blank" class="widget-link" href="' . $link . '" download>
			<img class="widget-icon" src="' . get_template_directory_uri() . '/assets/images/download.svg" alt="<?php echo mb_strimwidth(get_the_title(), 0, 60, "...") ; ?>
			Скачать</a>';
		}

		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Введите заголовок';
		$description = @ $instance['description'] ?: 'Описание';
		$link = @ $instance['link'] ?: 'https://google.com';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Описание:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>">
		</p>
        <p>
            <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Ссылка на файл:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
        </p>

		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_downloader_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_downloader_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.my_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Downloader_Widget

// регистрация downloader_widget в WordPress

function register_downloader_widget() {
	register_widget( 'Downloader_Widget' );
}
add_action( 'widgets_init', 'register_downloader_widget' );

/**
 * ------------------Добавление нового виджета Social_Widget (Социальные сети).---------------
 */
class Social_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'social_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: social_widget
			'Социальные сети',
			array( 'description' => 'Социальные сети', 'classname' => 'widget-social', )
		);

		// скрипты/стили виджета, только если он активен

		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_social_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_social_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {

		$title = $instance['title'];
		$link_f = $instance['link_f'];
		$link_i = $instance['link_i'];
		$link_t = $instance['link_t'];
		$link_y = $instance['link_y'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
        if ( ! empty( $link_f ) ) {
			echo '<a target= "_blank" class="widget-link-facebook" href="' . $link_f . '">
			<img src="' . get_template_directory_uri() . '/assets/images/facebook.svg" class="widget-social-facebook"></a>';
		}
		if ( ! empty( $link_i ) ) {
			echo '<a target= "_blank" class="widget-link-insta" href="' . $link_i . '">
			<img src="' . get_template_directory_uri() . '/assets/images/insta.png" class="widget-social-insta"></a>';
		}
		if ( ! empty( $link_t ) ) {
			echo '<a target= "_blank" class="widget-link-twitter" href="' . $link_t . '">
			<img src="' . get_template_directory_uri() . '/assets/images/twitter.svg" class="widget-social-twitter"></a>';
		}
		if ( ! empty( $link_y ) ) {
			echo '<a target= "_blank" class="widget-link-youtube" href="' . $link_y . '">
			<img src="' . get_template_directory_uri() . '/assets/images/youtube.svg" class="widget-social-youtube"></a>';
		}
		
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Введите заголовок';
		$link_f = @ $instance['link_f'] ?: 'https://facebook.com';
		$link_i = @ $instance['link_i'] ?: 'https://instagram.com';
		$link_t = @ $instance['link_t'] ?: 'https://twitter.com';
		$link_y = @ $instance['link_y'] ?: 'https://youtube.com';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'link_f' ); ?>"><?php _e( 'Ссылка на Facebook:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link_f' ); ?>" name="<?php echo $this->get_field_name( 'link_f' ); ?>" type="text" value="<?php echo esc_attr( $link_f ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link_i' ); ?>"><?php _e( 'Ссылка на Instagram:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link_i' ); ?>" name="<?php echo $this->get_field_name( 'link_i' ); ?>" type="text" value="<?php echo esc_attr( $link_i ); ?>">
		</p>
        <p>
            <label for="<?php echo $this->get_field_id( 'link_t' ); ?>"><?php _e( 'Ссылка на Twitter:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'link_t' ); ?>" name="<?php echo $this->get_field_name( 'link_t' ); ?>" type="text" value="<?php echo esc_attr( $link_t ); ?>">
        </p>
		<p>
            <label for="<?php echo $this->get_field_id( 'link_y' ); ?>"><?php _e( 'Ссылка на Youtube:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'link_y' ); ?>" name="<?php echo $this->get_field_name( 'link_y' ); ?>" type="text" value="<?php echo esc_attr( $link_y ); ?>">
        </p>

		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['link_f'] = ( ! empty( $new_instance['link_f'] ) ) ? strip_tags( $new_instance['link_f'] ) : '';
		$instance['link_i'] = ( ! empty( $new_instance['link_i'] ) ) ? strip_tags( $new_instance['link_i'] ) : '';
		$instance['link_t'] = ( ! empty( $new_instance['link_t'] ) ) ? strip_tags( $new_instance['link_t'] ) : '';
		$instance['link_y'] = ( ! empty( $new_instance['link_y'] ) ) ? strip_tags( $new_instance['link_y'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_social_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_social_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.my_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Social_Widget

// регистрация downloader_widget в WordPress

function register_social_widget() {
	register_widget( 'Social_Widget' );
}
add_action( 'widgets_init', 'register_social_widget' );

// ******-------конец Social_Widget



## изменяем настройки облака тегов
add_filter('widget_tag_cloud_args', 'edit_widget_tag_cloud');
function edit_widget_tag_cloud($args)
{
  $args['unit'] = 'px';
  $args['smallest'] = '14';
  $args['largest'] = '14';
  $args['number'] = '13';
  $args['orderby'] = 'count';
  return $args;
}

// Подключение стилей и скиптов

function enqueue_universal_theme() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'universal-theme', get_template_directory_uri() . '/assets/css/universal-theme.css', 'style');
    wp_enqueue_style( 'Roboto-Slab', 'https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');

}
add_action( 'wp_enqueue_scripts', 'enqueue_universal_theme' );

// отключаем создание миниатюр файлов для указанных размеров

add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, [
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	] );
}
//    Регестрируем миниатюру
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'article-thumb', 65, 65, true ); // Кадрирование изображения
}