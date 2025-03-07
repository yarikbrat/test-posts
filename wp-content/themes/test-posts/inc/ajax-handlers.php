<?php
function filter_posts() {
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'my_nonce_action' ) ) {
        wp_send_json_error(['message' => 'Ошибка безопасности']);
    }

    $category_id = isset($_POST['category']) && $_POST['category'] !== 'all' ? (int) $_POST['category'] : '';
    $paged = isset($_POST['page']) ? (int) $_POST['page'] : 1;
    $posts_per_page = 9;

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $posts_per_page,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'paged'          => $paged,
    );

    if ($category_id) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $category_id,
            ),
        );
    }

    $query = new WP_Query($args);
    $total_posts = $query->found_posts;
    $max_pages = ceil($total_posts / $posts_per_page);

    ob_start();

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
                    <a href="<?php echo esc_url($post_link); ?>">
                        <h2 class="post--title"><?php echo esc_html($post_title_trimmed); ?></h2>
                    </a>
                </div>
            </div>

            <?php
        endwhile;
        wp_reset_postdata();
    endif;

    $posts_html = ob_get_clean();


    wp_send_json_success([
        'html' => $posts_html,
        'has_more' => $paged < $max_pages
    ]);
}
add_action('wp_ajax_filter_posts', 'filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');
