<?php
get_header();
pageBanner(array(
    'title' => 'Past Events',
    'subtitle' => 'Recap of our past events.',
    'photo' => 'https://images.unsplash.com/photo-1536008758366-72fbc5b16911?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1374&q=80'
));
?>

<div class="container container--narrow page-section">
    <?php

    $today = date('Ymd');
    $pastEvents = new WP_Query(array(
        'paged' => get_query_var('paged', 1),
        'post_type' => 'event',
        'meta_key' => 'event_date',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'event_date',
                'compare' => '<=',
                'value' => $today,
                'type' => 'numeric',
            )
        )
    ));

    while ($pastEvents->have_posts()) {
        $pastEvents->the_post(); ?>

        <div class="event-summary">
            <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                <span class="event-summary__month">
                    <?php
                    $eventDate = new DateTime(get_field('event_date'));
                    echo $eventDate->format('M');
                    ?>
                </span>
                <span class="event-summary__day">
                    <?php
                    $eventDate = new DateTime(get_field('event_date'));
                    echo $eventDate->format('d');
                    ?>
                </span>
            </a>
            <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <p><?php if (has_excerpt()) {
                        echo get_the_excerpt();
                    } else {
                        echo wp_trim_words(get_the_content(), 14);
                    } ?>
                    <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a>
                </p>
            </div>
        </div>

    <?php }
    echo paginate_links(array(
        'total' => $pastEvents->max_num_pages,
    ));
    ?>
</div>

<?php
get_footer();
?>