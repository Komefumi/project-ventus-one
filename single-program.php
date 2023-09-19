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
        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program') ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs</a> <span class="metabox__main">
          Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', ') ?>
        </span>
      </p>
    </div>
    <div class="generic-content">
      <?php the_content(); ?>
    </div>
    <?php
    $today = date('Ymd');

    $professors = new WP_Query(array(
      'posts_per_page' => -1,
      'post_type' => 'professor',
      'orderby' => 'title',
      'order' => 'asc',
      'meta_query' => array(
        array(
          'key' => 'related_programs',
          'compare' => 'LIKE',
          'value' => '"' . get_the_ID() . '"',
        ),
      ),
    ));
    ?>
    <?php if ($professors->have_posts()) { ?>
      <hr class="section-break">
      <h2 class="headline headline--medium"><?php the_title() ?> Professors</h2>
      <ul class="professor-cards">
        <?php
        while ($professors->have_posts()) {
          $professors->the_post(); ?>
          <li class="professor-card__list-item">
            <a class="professor-card" href="<?php the_permalink(); ?>">
              <img class="professor-card__image" src="<?php the_post_thumbnail_url('professor_landscape'); ?>" alt="">
              <span class="professor-card__name"><?php the_title(); ?></span>
            </a>
          </li>
      <?php }
        wp_reset_postdata();
      } ?>
      </ul>
      <?php


      $related_events = new WP_Query(array(
        'posts_per_page' => 2,
        'post_type' => 'event',
        'meta_key' => 'event_date',
        'orderby' => 'meta_value_num',
        'order' => 'asc',
        'meta_query' => array(
          array(
            'key' => 'event_date',
            'compare' => '>=',
            'value' => $today,
            'type' => 'numeric',
          ),
          array(
            'key' => 'related_programs',
            'compare' => 'LIKE',
            'value' => '"' . get_the_ID() . '"',
          ),
        ),
      ));
      ?>
      <?php if ($related_events->have_posts()) { ?>
        <hr class="section-break">
        <h2 class="headline headline--medium">Upcoming <?php echo get_the_title(); ?> Events</h2>
        <?php
        while ($related_events->have_posts()) {
          $related_events->the_post();
          get_template_part('template-parts/event-excerpt');
        }
        wp_reset_postdata();
        ?>
  </div>
<?php }
    }

    get_footer();

?>