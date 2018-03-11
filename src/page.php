<?php get_header(); ?>
    <section class="hero is-hipure">
        <div class="hero-body">
            <div class="container is-fluid">
                <h1 class="title"><?php the_title(); ?></h1>
            </div>
        </div>
    </section>
        
    <section class="section">
        <div class="container is-fluid">
            <div class="content">
                <?php echo apply_filters('the_content', $post->post_content); ?>
            </div>
        </div>
    </section>
<?php get_footer(); ?>