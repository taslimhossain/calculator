<div class="wrap td-city">
	<h1 class="wp-heading-inline">Standaardkist</h1>
	<hr class="wp-header-end">

        <?php if ( isset( $_GET['kist-insert'] ) && $_GET['kist-insert'] == 'true' ) { ?>
            <div class="notice notice-success">
                <p><?php _e( 'Prijzen voor de kist werden ge-update!', 'teamdigital' ); ?></p>
            </div>
        <?php } ?>

		<table class="tdkistlist table-striped" style="width: 600px;">
            <thead>
                <tr style="text-align: left;">
                    <th>Leeftijd</th>
                    <th>Bedrag</th>
                </tr>
            </thead>
            <tbody>
                 <form action="" method="post">
                    <?php 
                    $get_kist = get_option( 'kist_itams' );
                    $kistList = kist_list();
                    $count = 0;
                    foreach ($kistList as $key => $value) {
                        $getPrice = (isset($get_kist[$count]['price'])) ? $get_kist[$count]['price'] : 0;
                        $count++;
                        ?>
                        <tr>
                            <td><input name="kistname[]" type="text" value="<?php echo $value ?>" placeholder="Leeftijd" class="form-control"></td>
                            <td><input name="price[]" type="text" value="<?php echo $getPrice; ?>" placeholder="Bedrag" class="form-control"></td>
                        </tr>
                        <?php
                    }
                    ?> 
                    <tr>
                        <td> <?php wp_nonce_field( 'taslim_happy_nonce' ); ?>
                            <br>
                            <?php submit_button( __( 'Opslaan', 'teamdigital' ), 'primary', 'submit_tdkist', false, null ); ?></td>
                        <td></td>
                    </tr>
                    </form>
               </tbody>
        </table>
</div>