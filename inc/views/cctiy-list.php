<div class="wrap td-city">
	<h1 class="wp-heading-inline">City List</h1>
	<hr class="wp-header-end">

    <?php if ( isset( $_GET['city-deleted'] ) && $_GET['city-deleted'] == 'true' ) { ?>
        <div class="notice notice-success">
            <p><?php _e( 'City has been deleted successfully!', 'teamdigital' ); ?></p>
        </div>
    <?php } ?>

    <?php if ( isset( $_GET['city-insert'] ) && $_GET['city-insert'] == 'true' ) { ?>
        <div class="notice notice-success">
            <p><?php _e( 'City has been add successfully!', 'teamdigital' ); ?></p>
        </div>
    <?php } ?>


		<table class="tdcitylist table-striped">
            <thead>
                <tr style="text-align: left;">
                    <th>Gemeente</th>
                    <th>Postcode</th>
                    <!-- <th>Woonplaats (begraving kerhof) </th> -->
                    <th>Plaats overlijden (transport) </th>
                    <th>0 tot 6 maanden </th>
                    <th>6 maanden tot 12 jaar </th>
                    <th>Ouder dan 12 jaar </th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                 <form action="" method="post">
                    <?php
                        if (isset($_REQUEST['cityid']) && !empty($_REQUEST['cityid'])) {
                            $tcity = taslim_city_get( $_REQUEST['cityid'], 'td_ccity' );
                        }else {
                            $tcity = [];
                        }
                    ?>
                    <tr>
                        <td><input name="name" type="text" value="<?php echo ( isset($tcity->name) && !empty($tcity->name) ) ? $tcity->name : ''; ?>" placeholder="Name" class="form-control"></td>
                        <td><input name="postcode" type="text" value="<?php echo ( isset($tcity->postcode) && !empty($tcity->postcode) ) ? $tcity->postcode : ''; ?>" placeholder="Post Code" class="form-control"></td>
                        <!-- <td><input name="burial_place" type="text" value="<?php echo ( isset($tcity->burial_place) && !empty($tcity->burial_place) ) ? $tcity->burial_place : ''; ?>" placeholder="0" class="form-control"></td> -->
                        
                        <td><input name="transport_price" type="text" value="<?php echo ( isset($tcity->transport_price) && !empty($tcity->transport_price) ) ? $tcity->transport_price : ''; ?>" placeholder="0" class="form-control"></td>

                        <td><input name="zerotosixmaanden" type="text" value="<?php echo ( isset($tcity->zerotosixmaanden) && !empty($tcity->zerotosixmaanden) ) ? $tcity->zerotosixmaanden : ''; ?>" placeholder="0" class="form-control"></td>

                        <td><input name="sixtotwelvejaar" type="text" value="<?php echo ( isset($tcity->sixtotwelvejaar) && !empty($tcity->sixtotwelvejaar) ) ? $tcity->sixtotwelvejaar : ''; ?>" placeholder="0" class="form-control"></td>

                        <td><input name="ouderdantwelve" type="text" value="<?php echo ( isset($tcity->ouderdantwelve) && !empty($tcity->ouderdantwelve) ) ? $tcity->ouderdantwelve : ''; ?>" placeholder="0" class="form-control"></td>

                        <td style="text-align: right;">
                            <input type="hidden" name="field_id" value="<?php echo ( isset($tcity->id) && !empty($tcity->id) ) ? $tcity->id : '0'; ?>">
                            <input type="hidden" name="table" value="td_ccity">
                            <?php wp_nonce_field( 'taslim_happy_nonce' ); ?>
                            <?php 
                            $button_text = ( isset($tcity->id) && !empty($tcity->id) ) ? 'Update city' : 'Add new city';

                            submit_button( __( $button_text, 'teamdigital' ), 'primary', 'submit_tdcity', false, null ); ?>

  <!--                          	<input type="submit" name="save_city" value="Save" class="button button-primary">
                         <a href="#" class="button button-primary button-small form-add-row">+</a>
                            <a href="#" class="button button-primary button-small remove-row">-</a> -->
                        </td>

                    </tr>
                    </form>
               </tbody>
        </table>
<style>
    .tdadminnav {
    font-size: 16px;
    margin-top: 10px;
    margin-bottom: 20px;
    text-align: right;
}

.tdadminnav a, .tdadminnav span {
    background: #fff;
    padding: 5px 10px;
    color: #333;
    text-decoration: none;
    line-height: 22px;
    height: 24px;
    display: inline-block;
}
.tdadminnav .current {
    background: #2271b1;
    color: #fff;
}
</style>
<?php
$per_page = 20 ;
$current_page      = (isset($_GET['paged'])) ? $_GET['paged'] : 1;
$offset                = ( $current_page -1 ) * $per_page;

$args = array(
    'number'     => $per_page,
    'table'     => 'td_ccity',
    'offset'     =>  $offset
);

$big = 999999999; // need an unlikely integer

$total        = taslim_city_count('td_ccity');
$num_of_pages = ceil( $total / $per_page );

echo '<div class="tdadminnav">';	
echo paginate_links( array(
    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
    'format' => '?paged=%#%',
    'current' => max( 1, $current_page ),
	//'end_size' => 5,
	//'mid_size' => 5,
    'total' => $num_of_pages
) );	
echo '</div>';	
?>
   
        <table class="tdcitylist table-striped">
            <thead>
                <tr style="text-align: left;">
                    <th>Gemeente</th>
                    <th>Postcode</th>
                    <!-- <th>Woonplaats (begraving kerhof)</th> -->
                    <th>Plaats overlijden (transport)</th>
                    <th>0 tot 6 maanden</th>
                    <th>6 maanden tot 12 jaar</th>
                    <th>Ouder dan 12 jaar</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>

                    <?php
                    $allcity = get_all_city($args);
                    if(is_array($allcity) && count($allcity) != 0) :
                        foreach ($allcity as $city) :
                    ?>
                    <tr>
                        <td><?php echo $city->name; ?></td>
                        <td><?php echo $city->postcode; ?></td>
                        <!-- <td><?php echo $city->burial_place; ?></td> -->
                        <td><?php echo $city->transport_price; ?></td>
                        <td><?php echo $city->zerotosixmaanden; ?></td>
                        <td><?php echo $city->sixtotwelvejaar; ?></td>
                        <td><?php echo $city->ouderdantwelve; ?></td>
                        <td style="text-align: right;">
                         <a href="<?php echo admin_url( 'admin.php?page=td_city' ).'&cityid='.$city->id; ?>" class="button button-primary">Edit</a>
                         <a href="<?php echo admin_url( 'admin.php?page=td_city' ).'&city_deleteid='.$city->id; ?>" class="button button-primary" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php
                    endforeach;
                    endif;  
                    ?>
               </tbody>
        </table>
</div>