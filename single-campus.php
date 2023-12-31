<?php

get_header();

$post_id = get_the_ID();

while (have_posts()) {
  the_post();
  page_banner(array(
    'title' => get_the_title(),
    'subtitle' => 'Don\'t forget to replace me later',
  )); ?>
  <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p>
        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus') ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs</a> <span class="metabox__main">
          Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', ') ?>
        </span>
      </p>
    </div>
    <div class="generic-content">
      <?php the_content(); ?>
    </div>
    <div class="acf-map">
      <?php
      $map_location = get_field('map_location');
      ?>
      <div class="marker" data-lat="<?php echo 'lat' ?>" data-lng="<?php echo 'lng' ?>">
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php echo "Map Location<br/>"; ?>
      </div>
    </div>
    <?php
    $today = date('Ymd');

    $programs = new WP_Query(array(
      'posts_per_page' => -1,
      'post_type' => 'program',
      'orderby' => 'title',
      'order' => 'asc',
      'meta_query' => array(
        array(
          'key' => 'related_campuses',
          'compare' => 'LIKE',
          'value' => '"' . get_the_ID() . '"',
        ),
      ),
    ));
    ?>
    <?php if ($programs->have_posts()) { ?>
      <hr class="section-break">
      <h2 class="headline headline--medium">Programs Available at This Campus</h2>
      <ul class="min-list link-list">
        <?php
        while ($programs->have_posts()) {
          $programs->the_post(); ?>
          <li>
            <a href="<?php the_permalink(); ?>">
              <?php the_title(); ?>
            </a>
          </li>
      <?php }
        wp_reset_postdata();
      } ?>
      </ul>
    <?php
  }

  get_footer();

    ?>