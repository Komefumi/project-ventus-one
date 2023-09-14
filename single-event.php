<?php

get_header();

$post_id = get_the_ID();

while (have_posts()) {
  the_post();
  page_banner(array(
    'title' => get_the_title(),
    'subtitle' => get_field('page_banner_subtitle'),
  )); ?>

  <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p>
        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event') ?>"><i class="fa fa-calendar" aria-hidden="true"></i> Event Home</a> <span class="metabox__main">
          <?php the_title(); ?>
        </span>
      </p>
    </div>
    <div class="generic-content">
      <?php the_content(); ?>
    </div>

    <?php

    $related_programs = get_field('related_programs');
    if ($related_programs) {
    ?>
      <hr class="section-break" />
      <h2 class="headline headline--medium">Related Program(s)</h2>
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