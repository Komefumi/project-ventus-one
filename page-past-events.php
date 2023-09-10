<?php get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg') ?>)"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Past Events</h1>
    <div class="page-banner__intro">
      <p>A Recap of our Past Events</p>
    </div>
  </div>
</div>

<div class="container container--narrow page-section">
  <?php

  $today = date('Ymd');
  $past_events = new WP_Query(array(
    'paged' => get_query_var('paged', 1),
    'posts_per_page' => 1,
    'post_type' => 'event',
    'meta_key' => 'event_date',
    'orderby' => 'meta_value_num',
    'order' => 'asc',
    'meta_query' => array(
      array(
        'key' => 'event_date',
        'compare' => '<',
        'value' => $today,
        'type' => 'numeric',
      ),
    ),
  ));
  while ($past_events->have_posts()) {
    $past_events->the_post(); ?>
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
        <p><?php echo wp_trim_words(get_the_content(), 18); ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
      </div>
    </div>
    <!-- <div class="post-item">
      <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <div class="metabox">
        <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', ') ?></p>
      </div>
      <div class="generic-content">
        <?php the_excerpt(); ?>
        <p>
          <a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue Reading</a>
        </p>
      </div>
    </div> -->
  <?php }
  echo paginate_links(array(
    'total' => $past_events->max_num_pages,
  ));
  ?>
</div>

<?php get_footer(); ?>