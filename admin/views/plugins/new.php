<div class="wrap">
    <h1><?php _e( 'New Product License', 'lmfwppt' ); ?></h1>

    <div class="lmwppt-wrap">
        <form action="" method="post">
            <div class="lmwppt-inner-card">
                <div class="lmfwppt-form-section" id="product-information">
                    <h2><?php esc_html_e( 'Product Information', 'lmfwppt' ); ?></h2>

                    <div class="lmfwppt-form-field">
                        <label for="name"><?php esc_html_e( 'Product Name', 'lmfwppt' ); ?></label>
                        <input type="text" name="lmfwppt[name]" id="name" class="regular-text" placeholder="Your Theme or Plugin Name">
                    </div>

                    <div class="lmfwppt-form-field">
                        <label for="slug"><?php esc_html_e( 'Product Slug', 'lmfwppt' ); ?></label>
                        <input type="text" name="lmfwppt[slug]" id="slug" class="regular-text" placeholder="your-theme-or-plugin-name">
                    </div>
                    <div class="lmfwppt-form-field">
                        <label for="product_type"><?php esc_html_e( 'Product Slug', 'lmfwppt' ); ?></label>
                        <select name="lmfwppt[product_type]" id="product_type">
                            <option value="plugin"><?php esc_html_e( 'Plugin', 'lmfwppt' ); ?></option>
                            <option value="theme"><?php esc_html_e( 'Theme', 'lmfwppt' ); ?></option>
                        </select>
                    </div>
                    <div class="lmfwppt-form-field">
                        <label for="product_version"><?php esc_html_e( 'Product Version', 'lmfwppt' ); ?></label>
                        <input type="text" name="lmfwppt[version]" id="product_version" class="regular-text" placeholder="1.0">
                    </div>
                    <div class="lmfwppt-form-field">
                        <label for="product_tested"><?php esc_html_e( 'Tested up to', 'lmfwppt' ); ?></label>
                        <input type="text" name="lmfwppt[tested]" id="product_tested" class="regular-text" placeholder="<?php esc_attr_e( '5.7', 'lmfwppt' ); ?>">
                    </div>
                    <div class="lmfwppt-form-field">
                        <label for="requires"><?php esc_html_e( 'Requires WordPress Version', 'lmfwppt' ); ?></label>
                        <input type="text" name="lmfwppt[requires]" id="requires" class="regular-text" placeholder="<?php esc_attr_e( '4.7', 'lmfwppt' ); ?>">
                    </div>
                    <div class="lmfwppt-form-field">
                        <label for="requires_php"><?php esc_html_e( 'Requires PHP Version', 'lmfwppt' ); ?></label>
                        <input type="text" name="lmfwppt[requires_php]" id="requires_php" class="regular-text" placeholder="<?php esc_attr_e( '7.4', 'lmfwppt' ); ?>">
                    </div>
                    <div class="lmfwppt-form-field">
                        <label for="download_link"><?php esc_html_e( 'File URL', 'lmfwppt' ); ?></label>
                        <div class="lmfwppt-file-field">
                            <input type="text" name="lmfwppt[download_link]" id="download_link" class="regular-text" placeholder="<?php esc_attr_e( 'URL of the Theme/Plugin file', 'lmfwppt' ); ?>">
                            <button class="button" type="button" id="download_link_button"><?php esc_html_e( 'Select File', 'lmfwppt' ); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lmwppt-inner-card">
                <div class="lmfwppt-form-section" id="license-information">
                    <h2><?php esc_html_e( 'Licensing', 'lmfwppt' ); ?></h2>

                </div>
            </div>

            <?php wp_nonce_field( 'new-address' ); ?>
            <?php submit_button( __( 'Add Product License', 'lmfwppt' ), 'primary', 'submit_product_license' ); ?>
        </form>

    </div>
</div>
