<?php
$meta = get_post_custom(get_the_ID());
//$company_id = ! isset($meta['_company_id'][0]) ? '' : $meta['_company_id'][0];
//$location = ! isset($meta['_company_location'][0]) ? '' : $meta['_company_location'][0];
?>
<article class="row exerpt-job-opening">

    <div class="small-12 medium-3 column">
        <?php
        if (has_post_thumbnail()) {
            ?>
            <a class="thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php echo get_the_post_thumbnail(get_the_ID(), "featured-image", []); ?>
            </a>
            <?php
        }
        ?>
    </div>

    <div class="small-12 medium-9 column">
        <header>
            <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
        </header>

        <aside class="byline">
            <?php

            // Get job opening studies
            $terms_study = get_the_terms(get_the_ID(), 'job-study');

            if ($terms_study && ! is_wp_error($terms_study)) {

                $job_studies = [];

                foreach ($terms_study as $term) {
                    $job_studies[] = '<a href="'.esc_url(get_term_link($term->term_id)).'">'.esc_html($term->name).'</a>';
                }

                if (! empty($job_studies)) {
                    ?><span><?=join(", ", $job_studies)?></span><?php
                }
            }

            if (! empty($location)) { ?><span><?php echo esc_html($location); ?></span><?php } ?>
        </aside>

        <?php the_excerpt(); ?>

        <footer class="byline">
            <?php

            // Get job opening types
            $terms_type = get_the_terms(get_the_ID(), 'job-type');

            if ($terms_type && ! is_wp_error($terms_type)) {

                $job_types = [];

                foreach ($terms_type as $term) {
                    $job_types[] = $term->name;
                }

                if (! empty($job_types)) {
                    ?><span><?=join(", ", $job_types)?></span><?php
                }
            }

            ?>
        </footer>
    </div>

</article>