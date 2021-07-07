<div class="wrap">
    <h1><?php _e( 'New Product License', 'lmfwppt' ); ?></h1>

    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <tr class="row form-invalid">
                    <th scope="row">
                        <label for="name"><?php _e( 'Name', 'lmfwppt' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text" value="">
                    </td>
                </tr>



            </tbody>
        </table>

        <?php wp_nonce_field( 'new-address' ); ?>
        <?php submit_button( __( 'Add Product License', 'lmfwppt' ), 'primary', 'submit_product_license' ); ?>
    </form>
</div>
