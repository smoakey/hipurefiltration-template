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
            <div class="columns">
                <div class="column is-two-thirds">
                    <?php if ($_GET['sent'] == 'true') : ?>
                        <div class="notification is-success">
                            <button class="delete"></button>
                            <strong>Success!</strong><br />
                            Your form submission was sent successfully. We will be in contact Soon!
                        </div>
                    <?php elseif ($_GET['sent'] == 'false') : ?>
                        <div class="notification is-danger">
                            <button class="delete"></button>
                            <strong>Error!</strong><br />
                            An error occurred while trying to send your form submission. Please try again later or email us directly at <a href="mailto:info@hipurefiltration.com">info@hipurefiltration.com</a>.
                        </div>
                    <?php endif; ?>

                    <p>If you have any questions about our products or company please fill out the following form and we will get back to you ASAP!</p>
                    <hr />
                    <form method="post" action="/wp-admin/admin-post.php">
                        <div class="field">
                            <label class="label">Name 
                                <span class="has-text-danger is-uppercase is-size-7">*</span>
                            </label>
                            <div class="control">
                                <input name="name" class="input" type="text" placeholder="Name" required />
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">
                                Email 
                                <span class="has-text-danger is-uppercase is-size-7">*</span>
                                </label>
                            <div class="control">
                                <input name="email" class="input" type="email" placeholder="Email" required />
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Phone</label>
                            <div class="control">
                                <input name="phone" class="input" type="tel" placeholder="Phone" />
                            </div>
                        </div>
                        
                        <div class="field">
                            <label class="label">Product Name/SKU</label>
                            <div class="control">
                                <input name="product" class="input" type="tel" placeholder="Product Name/SKU" value="<?php echo strtoupper($_GET['product_sku']); ?>" />
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">
                                Comment/Question 
                                <span class="has-text-danger is-uppercase is-size-7">*</span>
                            </label>
                            <div class="control">
                                <textarea name="comment" class="textarea" placeholder="Comments or questions" required><?php echo isset($_GET['product_sku']) ? 'I am interested in ordering product #' . $_GET['product_sku'] : ''; ?></textarea>
                            </div>
                        </div>
                        <div class="field is-grouped is-grouped-centered">
                            <div class="control">
                                <button type="submit" name="submit" class="button is-link">Submit</button>
                            </div>
                            <div class="control">
                                <button type="reset" class="button is-text">Reset</button>
                            </div>
                        </div>

                        <input name="blah" type="text" class="is-invisible">
                        <input type="hidden" name="action" value="submit_contact_form">
                    </form>
                </div>
                <div class="column is-one-third">
                    <div class="content">
                        <h5>General Information</h5>
                        <a href="mailto:info@hipurefiltration.com">info@hipurefiltration.com</a>
                        <br /><br /><br />
                        <h5>Sales Information</h5>
                        <a href="mailto:sales@hipurefiltration.com">sales@hipurefiltration.com</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php get_footer(); ?>