<div class="wrap">
    <h1><?php _e( 'Edit Address', 'wedevs-academy' ); ?></h1>

    <?php if ( isset( $_GET['address-updated'] ) ) { ?>
        <div class="notice notice-success">
            <p><?php _e( 'Address has been updated successfully!', 'wedevs-academy' ); ?></p>
        </div>
    <?php } ?>

    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="address"><?php _e( 'Address', 'wedevs-academy' ); ?></label>
                    </th>
                    <td>
                        <textarea class="regular-text" name="address" id="address"><?php echo esc_textarea( $address->address ); ?></textarea>
                    </td>
                </tr>
            </tbody>
        </table>

        <input type="hidden" name="id" value="<?php echo esc_attr( $address->id ); ?>">
        <?php wp_nonce_field( 'new-address' ); ?>
        <?php submit_button( __( 'Update Address', 'wedevs-academy' ), 'primary', 'submit_address' ); ?>
    </form>
</div>
