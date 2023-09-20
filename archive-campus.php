<?php get_header();
page_banner(array(
  'title' => 'Our Campuses',
  'subtitle' => 'We have several conveniently located campuses.',
)); ?>

<div class="container container--narrow page-section">
  <div class="acf-map">
    <?php
    while (have_posts()) {
      the_post();
      $map_location = get_field('map_location');
    ?>
      <div class="marker" data-lat="<?php echo 'lat' ?>" data-lng="<?php echo 'lng' ?>">
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php echo "Map Location<br/>"; ?>
      </div>
    <?php }
    ?>
  </div>
</div>

<?php get_footer(); ?>