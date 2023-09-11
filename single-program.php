<?php

get_header();

$post_id = get_the_ID();

while (have_posts()) {
  the_post(); ?>
  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg') ?>)"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title(); ?></h1>
      <div class="page-banner__intro">
        <p>Don't forget to replace me later</p>
      </div>
    </div>
  </div>
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
              <img class="professor-card__image" src="<?php the_post_thumbnail_url(); ?>" alt="">
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
          $related_events->the_post(); ?>
          <div class="event-summary">
            <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
              <?php
              $event_date = new DateTime(get_field('event_date'));
              ?>
              <span class="event-summary__month">
                <?php
                echo $event_date->format('M');
                ?>
              </span>
              <span class="event-summary__day"><?php echo $event_date->format('d') ?></span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
              <p><?php echo has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 18) ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
            </div>
          </div>
        <?php }
        wp_reset_postdata();
        ?>
  </div>
<?php }
    }

    get_footer();

?>