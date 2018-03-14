<?php get_header(); ?>

    <section class="hero is-home-hero is-hipure is-medium">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h2 class="subtitle">
                    High Quality. High Purity.
                </h2>
                <h1 class="title">
                    HiPure Filtration
                </h1>
                <div class="buttons is-centered">
                    <a href="/about-us" class="button is-white is-outlined">
                        The HiPure Difference
                    </a>
                    <a href="/products" class="button is-white">
                        View Products
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container is-fluid">
            <h2 class="section-title has-text-centered is-uppercase">Product Categories</h2>
            <div class="columns">
                <?php $productCategories = get_terms('product_cat', ['hide_empty' => 0, 'number' => 3]); ?>
                <?php foreach ($productCategories as $productCategory) : ?>
                    <div class="column product-category">
                        <?php 
                            $thumbnail_id = get_woocommerce_term_meta($productCategory->term_id, 'thumbnail_id', true);
                            $image = wp_get_attachment_url($thumbnail_id);
                        ?>
                        <a href="<?php echo get_category_link($productCategory->term_id); ?>">
                            <figure class="image is-square">
                                <img src="<?php echo $image; ?>">
                            </figure>
                            <?php echo $productCategory->name; ?>
                            <span>(<?php echo $productCategory->count; ?>)</span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="newsletter" class="hero is-hipure">
        <div class="hero-body">
            <div class="container is-fluid">
                <div class="columns is-vcentered">
                    <div class="column is-half is-left">
                        <p class="title">HiPure <strong>Mailing List</strong></p>
                        <p class="subtitle">Sign Up to receive special deals &amp; updates!</p>
                    </div>

                    <div class="column">
                        <form action="https://hipurefiltration.us17.list-manage.com/subscribe/post" method="POST" accept-charset="utf-8">
                            <input type="hidden" name="u" value="9e10a1862cf89c57f90d777d5">
                            <input type="hidden" name="id" value="c5af44870a">
                            <div class="field is-grouped">
                                <div class="control has-icons-left is-expanded">
                                    <input type="email" value="" name="MERGE0" class="input is-flat required email" placeholder="email address" required>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                </div>
                                <div class="control">
                                    <input type="submit" value="Subscribe" name="submit" class="button is-white is-outlined">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php get_footer(); ?>