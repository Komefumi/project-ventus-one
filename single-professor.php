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
    <!-- <div class="metabox metabox--position-up metabox--with-home-link">
      <p>
        <a class="metabox__blog-home-link" href="<?php echo site_url('/blog') ?>"><i class="fa fa-home" aria-hidden="true"></i> Blog Home</a> <span class="metabox__main">
          Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', ') ?>
        </span>
      </p>
    </div> -->
    <div class="generic-content">
      <?php the_content(); ?>
    </div>

    <?php

    $related_programs = get_field('related_programs');
    if ($related_programs) {
    ?>
      <hr class="section-break" />
      <h2 class="headline headline--medium">Subject(s) Taught</h2>
      <ul class="link-list min-list">
        <?php
        foreach ($related_programs as $program) { ?>
          <li>
            <a href="<?php echo get_the_permalink($program) ?>"><?php echo get_the_title($program); ?></a>
          </li>
      <?php }
      }
      ?>
      </ul>

  </div>
<?php }

get_footer();

?>