<?php
// Get post meta
$meta = get_post_custom(get_the_ID());
$company_id = ! isset($meta['_company_id'][0]) ? '' : $meta['_company_id'][0];

$company_meta = get_post_custom($company_id);
$address = ! isset($company_meta['_company_address'][0]) ? '' : $company_meta['_company_address'][0];
$phone = ! isset($company_meta['_company_phone'][0]) ? '' : $company_meta['_company_phone'][0];
$email = ! isset($company_meta['_company_email'][0]) ? '' : $company_meta['_company_email'][0];
$website = ! isset($company_meta['_company_website'][0]) ? '' : $company_meta['_company_website'][0];

?>
<article>

    <div class="row">
        <div class="column column-block medium-5 large-4">

            <div class="wisv-panel">
                <div class="wisv-panel-content">

                    <?php
                    // Display for which studies job openings are available
                    echo get_the_term_list(get_the_ID(), 'job_study', '<ul class="fa-ul company-details"><li><i class="fa-li fa ch-graduation-cap"></i> ', '</li><li>', '</li></ul>');

                    // Display for which type of job openings are available
                    echo get_the_term_list(get_the_ID(), 'job_type', '<ul class="fa-ul company-details"><li><i class="fa-li fa ch-briefcase"></i> ', '</li><li>', '</li></ul>');
                    ?>

                </div>
            </div>

            <div class="wisv-panel">

                <header class="wisv-panel-heading">
                    <h1 class="small">About <?=get_the_title($company_id);?></h1>
                </header>

                <div class="wisv-panel-content">
                    <?php
                    if (has_post_thumbnail($company_id)) {
                        ?>
                        <div class="company-logo">
                            <a href="<?=get_permalink($company_id);?>">
                                <?=get_the_post_thumbnail($company_id, "medium");?>
                            </a>
                        </div>
                    <?php } ?>

                    <?php if (! empty($address)) { ?>
                        <ul class="fa-ul company-details">
                            <li><i class="fa-li fa ch-map-marker"></i><?php echo nl2br(esc_html($address)); ?></li>
                        </ul>
                    <?php } ?>

                    <?php if (! empty($phone)) { ?>
                        <ul class="fa-ul company-details">
                            <li><i class="fa-li fa ch-phone"></i><a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a></li>
                        </ul>
                    <?php } ?>

                    <?php if (! empty($email)) { ?>
                        <ul class="fa-ul company-details">
                            <li><i class="fa-li fa ch-envelope"></i><a href="mailto:<?php echo esc_html(encode_email($email)); ?>"><?php echo esc_html(encode_email($email)); ?></a>
                            </li>
                        </ul>
                    <?php } ?>

                    <?php if (! empty($website)) { ?>
                        <ul class="fa-ul company-details">
                            <li><i class="fa-li fa ch-globe"></i><a href="<?php echo esc_url($website); ?>" target="_blank"><?php echo esc_html($website); ?></a></li>
                        </ul>
                    <?php } ?>
                </div>

            </div>

        </div>

        <div class="column medium-7 large-8">

            <article class="row column column-block post-content">
                <?php
                the_title('<h1>', '</h1>');
                the_content();
                ?>
            </article>

            <?php
            // Get more job openings for company
            $company_openings = new WP_Query([
                'post_type' => 'job_opening',
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC',
                'meta_key' => '_company_id',
                'meta_value' => $company_id,
                'post__not_in' => [get_the_ID()],
            ]);

            if ($company_openings->have_posts()) { ?>

                <div class="row column column-block">
                    <div class="wisv-panel related-job-openings">

                        <header class="wisv-panel-heading">
                            <h1 class="small">
                                Related Job Openings
                                <small><a href="<?php echo get_post_type_archive_link('job_opening') ?>">View all <i class="fa ch-arrow-right"></i></a></small>
                            </h1>
                        </header>

                        <div class="wisv-panel-content">
                            <?php
                            while ($company_openings->have_posts()) {
                                $company_openings->the_post();
                                get_template_part('parts/post-type/excerpt', 'job_opening');
                            }
                            wp_reset_postdata();
                            ?>
                        </div>

                    </div>
                </div>

            <?php } ?>

        </div>
    </div>

</article>
