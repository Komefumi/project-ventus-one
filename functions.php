<?php

function page_banner($args = [])
{
  if (!isset($args['title'])) {
    $args['title'] = get_the_title();
  }
  if (!isset($args['subtitle'])) {
    $args['subtitle'] = get_field('page_banner_subtitle');
  }
  if (!isset($args['photo'])) {
    if (!is_archive() and !is_home()) {
      $img_already = get_field('page_banner_background_image');
      if ($img_already) {
        $args['photo'] = $img_already['sizes']['page_banner'];
      } else {
        $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
      }
    } else {
      $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
    }
  }
?>
  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo'] ?>)"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
      <div class="page-banner__intro">
        <p><?php echo $args['subtitle']; ?></p>
      </div>
    </div>
  </div>
<?php }

function university_files()
{
  wp_enqueue_script('google-map', '//maps.google.apis.com/maps/api/js?key=gmaps-api-key', null, '1.0', true);
  wp_enqueue_script('main-university-js', get_theme_file_uri('build/index.js'), array('jquery'), '1.0', true);
  wp_enqueue_style('custom-google-fonts', 'fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style(
    'university_main_styles',
    get_theme_file_uri('/build/style-index.css'),
    // get_stylesheet_uri()
  );
  wp_enqueue_style(
    'university_extra_styles',
    get_theme_file_uri('/build/index.css'),
    // get_stylesheet_uri()
  );
}

add_action('wp_enqueue_scripts', 'university_files');

function university_features()
{
  register_nav_menu('header_menu_location', 'Header Menu Location');
  register_nav_menu('footer_location_1', 'Footer Location 1');
  register_nav_menu('footer_location_2', 'Footer Location 2');
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_image_size('professor_landscape', 400, 260, true);
  add_image_size('professor_portrait', 250, 450, true);
  add_image_size('page_banner', 1500, 350, true);
}

add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query)
{
  if (!is_admin() and $query->is_main_query()) {
    if (is_post_type_archive('event')) {
      $query->set('meta_key', 'event_date');
      $query->set('orderby', 'meta_value_num');
      $query->set('order', 'asc');
      $today = date('Ymd');
      $query->set('meta_query', array(
        array(
          'key' => 'event_date',
          'compare' => '>=',
          'value' => $today,
          'type' => 'numeric',
        ),
      ));
    }
    if (is_post_type_archive('program')) {
      $query->set('posts_per_page', -1);
      $query->set('orderby', 'title');
      $query->set('order', 'asc');
    }

    if (is_post_type_archive('campus')) {
      $query->set('posts_per_page', -1);
    }
  }
}

add_action('pre_get_posts', 'university_adjust_queries');

function universityMapKey($api)
{
  $api['key'] = 'yourKeyGoesHere';
  return $api;
}

add_filter('acf/fields/google_map/api', 'universityMapKey');
