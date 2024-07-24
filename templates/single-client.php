<?php
// Client Data
$name = get_post_meta(get_the_ID(), '_gcb_name', true);
$lastName = get_post_meta(get_the_ID(), '_gcb_lastName', true);
$provincia = get_post_meta(get_the_ID(), '_gcb_provincia', true);

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php
        while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <p><strong>Name:</strong> <?php echo esc_html($name); ?></p>
                    <p><strong>Last Name:</strong> <?php echo esc_html($lastName); ?></p>
                    <p><strong>Provincia:</strong> <?php echo esc_html($provincia); ?></p>
                    <?php
                    the_content();
                    ?>
                </div><!-- .entry-content -->

                <footer class="entry-footer">
                    <?php edit_post_link(__('Edit', 'textdomain'), '<span class="edit-link">', '</span>'); ?>
                </footer><!-- .entry-footer -->
            </article><!-- #post-## -->
        <?php endwhile; // End of the loop. ?>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
