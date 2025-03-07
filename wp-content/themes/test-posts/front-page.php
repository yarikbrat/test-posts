<?php
/*
Template Name: Home-page

*/
?>

<?php get_header();?>



<section class="posts">
  <div class="container">


    <div class="posts--nav">
    <a href="#" data-category="all">All</a>
    <?php
    $categories = get_categories();
    foreach ($categories as $category) {
        echo '<a href="#" data-category="' . $category->term_id . '">' . esc_html($category->name) . '</a>';
    }
    ?>
</div>



    <div class="posts--wrapper">
      <?php
        $args = array(
          'post_type'      => 'post',
          'posts_per_page' => 9,
          'orderby'        => 'date',
          'order'          => 'DESC',
        );

        $query = new WP_Query($args);


        if ($query->have_posts()) :
          while ($query->have_posts()) : $query->the_post();
            $post_id = get_the_ID();
            $post_title = get_the_title();
            $post_title_trimmed = mb_strimwidth($post_title, 0, 70, '...');
            $post_link = get_permalink();
            $post_thumbnail = get_the_post_thumbnail_url($post_id, 'medium') ?: 'URL_ЗАГЛУШКИ';
            $categories = get_the_category();
            $category_link = !empty($categories) ? get_category_link($categories[0]->term_id) : '#';
            $category_name = !empty($categories) ? esc_html($categories[0]->name) : 'Без категории';
      ?>

             <div class="post">

             <div class="post--img">
                <a class="img-link" href="<?php echo esc_url($post_link); ?>">
                  <img src="<?php echo esc_url($post_thumbnail); ?>" alt="<?php echo esc_attr($post_title); ?>">
                  <span>Read more</span>
                </a>
              </div>
              <div class="post--cont">
              <p class="post--category">
                  <a href="<?php echo esc_url($category_link); ?>"><?php echo esc_html($category_name); ?></a>
              </p>

                <a href="<?php echo esc_url($post_link); ?>" >
                <h2 class="post--title"><?php echo esc_html($post_title_trimmed); ?></h2>
                </a>
              </div>

             </div>

      <?php
          endwhile;
          wp_reset_postdata();
        else :
          echo '<p>Постов пока нет.</p>';
        endif;
      ?>
    </div>


    <div class="more-link">
      <a href="#">Load More Posts</a>
    </div>

  </div>
</section>


<?php get_footer(); ?>