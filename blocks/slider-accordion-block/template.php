<?php
if (get_field('disable_block')) {
    return;
}
gutenberg_preview(get_field('gutenberg_preview'));

$block_data = get_block_data($block);
$block_id = $block_data['id'];
$block_class = $block_data['class'];

?>
<section class="block-slider-accordion <?php echo esc_attr($block_class); ?>" id="<?php echo esc_attr($block_id); ?>">
    <div class="container">
        <div class="row">
            <div class="block-wrapper">
                <?php 
                $section_title = get_field('title'); ?>

                <div class="slider-wrap">
                    <?php if (have_rows('accordion_and_slider')) : ?>
                        <?php while (have_rows('accordion_and_slider')) : the_row(); ?>
                            <?php
                            $vimeo_video_id = get_sub_field('vimeo_video_id');
                            $html5_video_link = get_sub_field('html5_video_link');

                            if ($vimeo_video_id) : ?>
                                <div class="item" data-index="<?php echo get_row_index() - 1; ?>">
                                    <iframe class="embed-player" src="https://player.vimeo.com/video/<?php echo esc_attr($vimeo_video_id); ?>?badge=0&autopause=0&player_id=0&autoplay=1&muted=1" frameborder="0" 
                                        allow="autoplay; fullscreen; picture-in-picture; clipboard-write" title="Vimeo Video <?php echo get_row_index(); ?>">
                                    </iframe>
                                </div>
                            <?php elseif ($html5_video_link) : ?>
                                <div class="item" data-index="<?php echo get_row_index() - 1; ?>">
                                    <video class="embed-player" 
                                        src="<?php echo esc_url($html5_video_link); ?>" 
                                        controls autoplay muted loop title="HTML5 Video <?php echo get_row_index(); ?>">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p>No slides available.</p>
                    <?php endif; ?>
                </div>


                <div class="accordion-wrap">
                    <div class="top-content-wrap">
                        <?php if( $section_title ): ?>
                            <div class="title-wrap">
                                <h2><?php echo esc_html($section_title); ?></h2>
                            </div>
                        <?php endif; ?>

                        <div class="progress-bar">
                            <span class="progress"></span>
                        </div>
                        <div class="accordion-sections">
                            <ul class="slider-nav">
                                <?php if( have_rows('accordion_and_slider') ): ?>
                                    <?php while( have_rows('accordion_and_slider') ): the_row(); ?>
                                        <?php 
                                            $accordion_title = get_sub_field('accordion_title');
                                            $accordion_description = get_sub_field('accordion_description');
                                        ?>
                                        <?php if( $accordion_title || $accordion_description ): ?>
                                            <li class="<?php echo get_row_index() === 1 ? 'active' : ''; ?>" data-index="<?php echo get_row_index() - 1; ?>">
                                                <?php if( $accordion_title ): ?>
                                                    <h3 class="acc-title"><?php echo esc_html($accordion_title); ?></h3>
                                                <?php endif; ?>
                                                <?php if( $accordion_description ): ?>
                                                    <div class="acc-content">
                                                        <p><?php echo esc_html($accordion_description); ?></p>
                                                    </div>
                                                <?php endif; ?>
                                            </li>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <p>No accordion items available.</p>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Footer Section -->
                    <?php 
                    $footer_content = get_field('footer'); 
                    if( $footer_content ): ?>
                        <div class="bottom-content-wrap">
                            <?php if( !empty($footer_content['footer_title']) ): ?>
                                <div class="title-wrap">
                                    <h6><?php echo esc_html($footer_content['footer_title']); ?></h6>
                                </div>
                            <?php endif; ?>
                            <?php if( !empty($footer_content['footer_text']) ): ?>
                                <div class="content-wrap">
                                    <p><?php echo esc_html($footer_content['footer_text']); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
