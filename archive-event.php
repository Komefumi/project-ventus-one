<?php get_header();
page_banner(array(
  'title' => 'All Events',
  'subtitle' => 'See what\'s going on in our world',
)); ?>

<div class="container container--narrow page-section">
  <?php
  while (have_posts()) {
    the_post(); ?>
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
  echo paginate_links();
  ?>

  <hr class="section-break" />

  <p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events') ?>">Check out our past events archive</a></p>
</div>

<?php get_footer(); ?>