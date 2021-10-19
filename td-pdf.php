<?php
/**
 * Generate PDF file to send email quote
 */

//taslim_generatePdf( $receiverName, $payload )

function taslim_generatePdf( $receiverName, $payload, $alldata ) {
    include_once __DIR__ . '/lib/tcpdf/tcpdf.php';

    // $payload =  base64_decode($payload);
    // $payload = json_decode($payload);
    // create new PDF document
    $pdf = new TCPDF( PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false );

    // set document information
    $pdf->SetCreator( 'Td funeral calculator' );
    $pdf->SetAuthor( 'Td funeral calculator' );
    $pdf->setPrintHeader( false );
    if ( $receiverName ) {
        $pdf->SetTitle( 'Email Quote File' );
        $pdf->SetSubject( 'Email quote file for ' . $receiverName );
    }

    $pdf->AddPage( 'P', 'A4' );

    $tagvs = array('h1' => array(0 => array('h' => 1, 'n' => 3), 1 => array('h' => 1, 'n' => 2)),
    'h2' => array(0 => array('h' => 1, 'n' => 2), 1 => array('h' => 1, 'n' => 1)));
    $pdf->setHtmlVSpace($tagvs);

    $total = null;

    $data = '';
    $data .= <<<EOD

    <div style="width:100%;vertical-align: middle; text-align:center;">
      <img style="width: 200px;" src="https://teamdigital.be/wp-content/uploads/2018/08/Teamdigital-logo.png">
    </div>
EOD;

    $cityOne = CITYPRICEONE;
    $cityTwo = CITYPRICETWO;
    $kist = KIST;

    $grandTotal    = 0;
    $tdtotalamount = 0;
    $tdtaxamount   = 0;
    $totalrow      = 0;

    $formfor = $alldata['formfor'];

    $tdcpriceone = (float)$alldata[CITYPRICEONE];
    $tdcpricetwo = (float)$alldata[CITYPRICETWO];
    $crematie = (float)$alldata[CITYCREMATIE];
    $kistprice = (float)$alldata[KIST];

    $tdcpriceonetax    = TRANSPORT_TAX;
    $tdcpricetwotax    = BEGRAVING_TAX;
    $kistTax    = KISTTAX;
    $crematieTax    = CREMATIE_TAX;



    $calloactionOnetax = ( $tdcpriceone * $tdcpriceonetax ) / 100;
    $calloactionTwotax = ( $tdcpricetwo * $tdcpricetwotax ) / 100;
    $kistptax          = ( $kistprice * $kistTax ) / 100;
    $crematietax       = ( $crematie * $crematieTax ) / 100;



    $tdlocationfinalpriceone = $tdcpriceone - $calloactionOnetax;
    $tdlocationfinalpricetwo = $tdcpricetwo - $calloactionTwotax;
    $tdkistfinal = $kistprice - $kistptax;
    $tdcrematiefinalprice = $crematie - $crematietax;

    $tdtotalamount += $tdlocationfinalpriceone;
    $tdtotalamount += $tdlocationfinalpricetwo;
    $tdtotalamount += $tdkistfinal;
    $tdtotalamount += $tdcrematiefinalprice;



    $tdshowponecal = $tdlocationfinalpriceone + $calloactionOnetax;
    $tdshowptwocal = $tdlocationfinalpricetwo + $calloactionTwotax;
    $tdshowkist = $tdkistfinal + $kistptax;
    $tdshowcrematie = $tdcrematiefinalprice + $crematietax;

    if($formfor == 'cremation'){
        $crematie_begraving = <<<EOD
            <tr>
                <td width="220" align="left">Crematie</td>
                <td width="100" align="center">€{$tdcrematiefinalprice}</td>
                <td width="50" align="center">€{$crematietax}</td>
                <td width="50" align="center">{$crematieTax}%</td>
                <td width="120" align="center" color="#ffffff" style="background-color:#3989c6">€{$tdshowcrematie}</td>
            </tr>
        EOD;
    } else {
        $crematie_begraving = <<<EOD
            <tr>
                <td width="220" align="left">Begraving</td>
                <td width="100" align="center">€{$tdlocationfinalpricetwo}</td>
                <td width="50" align="center">€{$calloactionTwotax}</td>
                <td width="50" align="center">{$tdcpricetwotax}%</td>
                <td width="120" align="center" color="#ffffff" style="background-color:#3989c6">€{$tdshowptwocal}</td>
            </tr>
        EOD;        
    }

    $kist_item = '';
    if($formfor !== 'cremation'){
        $kist_item = <<<EOD
            <tr>
                <td width="220" align="left">Kist</td>
                <td width="100" align="center">€{$tdkistfinal}</td>
                <td width="50" align="center">€{$kistptax}</td>
                <td width="50" align="center">{$kistTax}%</td>
                <td width="120" align="center" color="#ffffff" style="background-color:#3989c6">€{$tdshowkist}</td>
            </tr>
        EOD;
    }

    $data .= <<<EOD
<div style="margin-bottom:200px"></div>

<h2 style="border-bottom: 1px solid #333; width:10px" width="10">Gegevens overledene</h2>
Leeftijd : {$alldata['tddate']}<br>
Gemeente van overlijden : {$alldata['cityselectone']}<br>
Woonplaats : {$alldata['cityselettwo']}
<h2 style="border-bottom: 1px solid #333; width:200px">Uitvaart keuze</h2>
Begraving met
EOD;
$pdf->writeHTML( $data, true, false, true, false, '' );

//set 'width' => 0.1, 'dash' => '1,1,1,1' as per your requirement
$style = array('width' => 0.5, 'dash' => '2,2,2,2', 'phase' => 0, 'color' => array(255, 0, 0));

$pdf->Ln();


$data = '';
$data .= <<<EOD
<table cellpadding="5" cellspacing="0" style="background-color:#eee;" width="400">
    <thead>
        <tr>
            <th width="220" align="left"><strong>NAAM</strong></th>
            <th width="100" align="center"><strong>SUBTOTAAL</strong></th>
            <th width="50" align="center"><strong>BTW</strong></th>
            <th width="50" align="center"><strong>%</strong></th>
            <th width="120" align="center"><strong>TOTAAL</strong></th>
        </tr>
    </thead>
    <tbody>
    {$crematie_begraving}
    <tr>
        <td width="220" align="left">Transport</td>
        <td width="100" align="center">€{$tdlocationfinalpriceone}</td>
        <td width="50" align="center">€{$calloactionOnetax}</td>
        <td width="50" align="center">{$tdcpriceonetax}%</td>
        <td width="120" align="center" color="#ffffff" style="background-color:#3989c6">€{$tdshowponecal}</td>
    </tr>
    {$kist_item}

EOD;
    foreach ( $payload as $formdata ) {
        $tdtotalamount += (float) $formdata['price'];
        $tdtax     = ( isset( $formdata['tax'] ) && $formdata['tax'] != '' ) ? $formdata['tax'] : 0;
        $shotdtax  = ( $tdtax != 0 ) ? $tdtax . '%' : '-';
        $taxamount = ( (float) $formdata['price'] * $tdtax ) / 100;
        $tdtaxamount += (float) $taxamount;
        $tdtotalamount += (float) $taxamount;
        $tdsubrow = (float) $formdata['price'] - $taxamount;
        $totalrow = (float) $taxamount + (float) $tdsubrow;
        $grandTotal += (float) $totalrow;

        if ( isset( $formdata['type'] ) && $formdata['type'] == 'image' ):
            $data .= <<<EOD
            <tr>
                <td width="220" align="left">{$formdata['label']} : {$formdata['value']}</td>
                <td width="100" align="center">-</td>
                <td width="50" align="center">-</td>
                <td width="50" align="center">-</td>
                <td width="120" align="center" color="#ffffff" style="background-color:#3989c6">-</td>
            </tr>
            EOD;
        endif;

        if ( isset( $formdata['type'] ) && $formdata['type'] == 'poem' ):
            $data .= <<<EOD
            <tr>
                <td width="220" align="left">{$formdata['label']} : {$formdata['key']}</td>
                <td width="100" align="center">-</td>
                <td width="50" align="center">-</td>
                <td width="50" align="center">-</td>
                <td width="120" align="center" color="#ffffff" style="background-color:#3989c6">-</td>
            </tr>
            EOD;
        endif;

        if ( isset( $formdata['price'] ) && ! empty( $formdata['price'] ) ):

            if(isset($formdata['type']) && $formdata['type'] === 'image_price'){
                $pricetitle = $formdata['label'].' : '.$formdata['value'];
            } else {
                $pricetitle = $formdata['key'];
            }
            
            $data .= <<<EOD
            <tr>
                <td width="220" align="left">{$pricetitle}</td>
                <td width="100" align="center">€{$tdsubrow}</td>
                <td width="50" align="center">€{$taxamount}</td>
                <td width="50" align="center">{$shotdtax}</td>
                <td width="120" align="center" color="#ffffff" style="background-color:#3989c6">€{$totalrow}</td>
            </tr>
            EOD;
        endif;
    } //endforeach
    $grandTotal += (float) $tdshowponecal + (float) $tdshowptwocal;
    $data .= <<<EOD
    </tbody>
    <tfoot>
        <tr>
            <td colspan="1"></td>
            <td colspan="3">ALGEMEEN TOTAAL</td>
            <td align="center">€{$grandTotal}</td>
        </tr>
    </tfoot>
</table>
EOD;

    $pdf->writeHTML( $data, true, false, true, false, '' );

    $uploadDir = wp_upload_dir();
    $filePath  = $uploadDir['path'] . '/' . date( 'Y-m-d H:i:s' ) . '.pdf';

    $pdfStr = $pdf->Output( $filePath, 'S' );

    $res = base64_encode( $pdfStr );
    $fileid = 'pdf_'.time();
    set_transient( $fileid, $res, 120 );
    $pdfurl = home_url('?downloadpdf='.$fileid);
    // $pdfObject       = new stdClass();
    // $pdfObject->file = $res;
    // $pdfObject->path = $filePath;

    return $pdfurl;
}


function td_generateinvoice( $payloaddata, $alldata ) {

    $cityOne = CITYPRICEONE;
    $cityTwo = CITYPRICETWO;
    $kist = KIST;

    $grandTotal    = 0;
    $tdtotalamount = 0;
    $tdtaxamount   = 0;
    $totalrow      = 0;

    $formfor = $alldata['formfor'];

    $tdcpriceone = isset($alldata[CITYPRICEONE]) ? (float)$alldata[CITYPRICEONE] : 0;
    $tdcpricetwo = isset($alldata[CITYPRICETWO]) ? (float)$alldata[CITYPRICETWO] : 0;
    $crematie = isset($alldata[CITYCREMATIE]) ? (float)$alldata[CITYCREMATIE] : 0;
    $kistprice = isset($alldata[KIST]) ? (float)$alldata[KIST] : 0;

    $tdcpriceonetax    = TRANSPORT_TAX;
    $tdcpricetwotax    = BEGRAVING_TAX;
    $kistTax    = KISTTAX;
    $crematieTax    = CREMATIE_TAX;


    $calloactionOnetax = ( $tdcpriceone * $tdcpriceonetax ) / 100;
    $calloactionTwotax = ( $tdcpricetwo * $tdcpricetwotax ) / 100;
    $kistptax          = ( $kistprice * $kistTax ) / 100;
    $crematietax       = ( $crematie * $crematieTax ) / 100;

    $tdlocationfinalpriceone = $tdcpriceone - $calloactionOnetax;
    $tdlocationfinalpricetwo = $tdcpricetwo - $calloactionTwotax;
    $tdkistfinal = $kistprice - $kistptax;
    $tdcrematiefinalprice = $crematie - $crematietax;

    $tdtotalamount += $tdlocationfinalpriceone;
    $tdtotalamount += $tdlocationfinalpricetwo;
    $tdtotalamount += $tdkistfinal;
    $tdtotalamount += $tdcrematiefinalprice;

    $tdshowponecal = $tdlocationfinalpriceone + $calloactionOnetax;
    $tdshowptwocal = $tdlocationfinalpricetwo + $calloactionTwotax;
    $tdshowkist = $tdkistfinal + $kistptax;
    $tdshowcrematie = $tdcrematiefinalprice + $crematietax;

    ob_start();
    ?>
    <div class="tdinvoice_preview">
        <div class="headerBlock" style="width:100%;border:none;text-align:center;margin-bottom: 50px;margin-top: 30px;">
            <img src="https://teamdigital.be/wp-content/uploads/2018/08/Teamdigital-logo.png">
        </div>

        <h4 class="tdinvoice_heading tdw-50">Gegevens overledene</h4>
        <ul class="tdinvoice-topinfo">
            <li><span>Leeftijd</span> <?php echo $alldata['tddate']; ?></li>
            <li><span>Gemeente van overlijden</span> <?php echo $alldata['cityselectone']; ?></li>
            <li><span>Woonplaats</span> <?php echo $alldata['cityselettwo']; ?></li>
        </ul>
        <h4 class="tdinvoice_heading tdmt-15 tdw-50">Uw keuze</h4>
        <?php 
            if($formfor === 'cremation'){
                echo '<p>Cremation</p>';
            } else {
                echo '<p>Begraving</p>';
            }
        ?>
        <h4 class="tdinvoice_heading tdmt-15">Overzicht kosten</h4>

        <table>
            <thead>
                <tr>
                    <th width="220" align="left"><strong>NAAM</strong></th>
                    <th width="100" align="center"><strong>SUBTOTAAL</strong></th>
                    <th width="50" align="center"><strong>BTW</strong></th>
                    <th width="50" align="center"><strong>%</strong></th>
                    <th width="120" align="center"><strong>TOTAAL</strong></th>
                </tr>
            </thead>
            <tbody>

            <tr><td><b style="margin-top: 10px;display: block;color: #af5801;">Basisdiensten</b></td></tr>

<?php
    if($formfor == 'cremation'){ ?>

            <tr>
                <td width="220" align="left">Crematie</td>
                <td width="100" align="center">€<?php echo $tdcrematiefinalprice; ?></td>
                <td width="50" align="center">€ <?php echo $crematietax; ?></td>
                <td width="50" align="center"><?php echo $crematieTax; ?>%</td>
                <td width="120" align="center">€ <?php echo $tdshowcrematie; ?></td>
            </tr>
    <?php
    } else {
    ?>
            <tr>
                <td width="220" align="left">Begraving</td>
                <td width="100" align="center">€ <?php echo $tdlocationfinalpricetwo; ?></td>
                <td width="50" align="center">€ <?php echo $calloactionTwotax; ?></td>
                <td width="50" align="center"> <?php echo $tdcpricetwotax; ?>%</td>
                <td width="120" align="center">€ <?php echo $tdshowptwocal; ?></td>
            </tr>
    <?php    
    }
    if($formfor !== 'cremation'){ 
        ?>
            <tr>
                <td width="220" align="left">Kist</td>
                <td width="100" align="center">€ <?php echo $tdkistfinal; ?></td>
                <td width="50" align="center">€ <?php echo $kistptax; ?></td>
                <td width="50" align="center"> <?php echo $kistTax; ?>%</td>
                <td width="120" align="center">€ <?php echo $tdshowkist; ?></td>
            </tr>
        <?php
    }
?>
        <tr>
            <td width="220" align="left">Transport</td>
            <td width="100" align="center">€ <?php echo $tdlocationfinalpriceone; ?></td>
            <td width="50" align="center">€ <?php echo $calloactionOnetax; ?></td>
            <td width="50" align="center"><?php echo $tdcpriceonetax; ?>%</td>
            <td width="120" align="center">€ <?php echo $tdshowponecal; ?></td>
        </tr>

<?php

$tdcount = 0;
foreach ( $payloaddata as  $key => $payload ) {

    $section_title = (isset($payload[0]['label']) && isset($payload[0]['price']) && !empty($payload[0]['price']) )  ? $payload[0]['label'] : '';
    if($section_title && $section_title != 'Basisdiensten'){
        echo '<tr><td><b style="margin-top: 10px;display: block;color: #af5801;">'.$section_title.'</b></td></tr>';
    }
    
    foreach ( $payload as $formdata ) {

        $tdtotalamount += (float) $formdata['price'];
        $tdtax     = ( isset( $formdata['tax'] ) && $formdata['tax'] != '' ) ? $formdata['tax'] : 0;
        $shotdtax  = ( $tdtax != 0 ) ? $tdtax . '%' : '-';
        $taxamount = ( (float) $formdata['price'] * $tdtax ) / 100;
        $tdtaxamount += (float) $taxamount;
        $tdtotalamount += (float) $taxamount;
        $tdsubrow = (float) $formdata['price'] - $taxamount;
        $totalrow = (float) $taxamount + (float) $tdsubrow;
        $grandTotal += (float) $totalrow;
/*
        if ( isset( $formdata['type'] ) && $formdata['type'] == 'image' ):
            ?>
                <tr>
                    <td width="220" align="left"> <?php echo $formdata['label']; ?> : <?php echo $formdata['value']; ?></td>
                    <td width="100" align="center">-</td>
                    <td width="50" align="center">-</td>
                    <td width="50" align="center">-</td>
                    <td width="120" align="center">-</td>
                </tr>
            <?php
        endif;


        if ( isset( $formdata['type'] ) && $formdata['type'] == 'poem' ):
            ?>
            <tr>
                <td width="220" align="left"><?php echo $formdata['label']; ?> : <?php echo $formdata['key']; ?></td>
                <td width="100" align="center">-</td>
                <td width="50" align="center">-</td>
                <td width="50" align="center">-</td>
                <td width="120" align="center">-</td>
            </tr>
            <?php
        endif;
*/
        if ( isset( $formdata['price'] ) && ! empty( $formdata['price'] ) ):

            if(isset($formdata['type']) && $formdata['type'] === 'image_price'){
                $pricetitle = $formdata['label'].' : '.$formdata['value'];
            } else {
                $pricetitle = $formdata['key'];
            }
            
            ?>
            <tr>
                <td width="220" align="left"><?php echo $pricetitle; ?></td>
                <td width="100" align="center">€ <?php echo $tdsubrow; ?></td>
                <td width="50" align="center">€ <?php echo $taxamount; ?></td>
                <td width="50" align="center"> <?php echo $shotdtax; ?></td>
                <td width="120" align="center">€ <?php echo $totalrow; ?></td>
            </tr>
            <?php
        endif;

    } // end 2nd foreach

}// end first foreach
$grandTotal += (float) $tdshowponecal + (float) $tdshowptwocal + (float) $tdshowkist;
?>

            
            </tbody>
        </table>
        <h4 class="tdinvoice_heading tdmt-15">Totale kostprijs </h4>
        <table>
            <tbody>
                <tr>
                    <td width="220" align="left"></td>
                    <td width="100" align="center"></td>
                    <td width="50" align="center"></td>
                    <td width="50" align="center"> </td>
                    <td width="120" align="center">€ <?php echo $grandTotal; ?></td>
                </tr> 
            </tbody>
        </table>
    </div>
    <?php
    return ob_get_clean();
}

//---------- admin
function td_admin_generateinvoice( $payloaddata, $alldata ) {

    $cityOne = CITYPRICEONE;
    $cityTwo = CITYPRICETWO;
    $kist = KIST;

    $grandTotal    = 0;
    $tdtotalamount = 0;
    $tdtaxamount   = 0;
    $totalrow      = 0;

    $formfor = $alldata['formfor'];

    $tdcpriceone = isset($alldata[CITYPRICEONE]) ? (float)$alldata[CITYPRICEONE] : 0;
    $tdcpricetwo = isset($alldata[CITYPRICETWO]) ? (float)$alldata[CITYPRICETWO] : 0;
    $crematie = isset($alldata[CITYCREMATIE]) ? (float)$alldata[CITYCREMATIE] : 0;
    $kistprice = isset($alldata[KIST]) ? (float)$alldata[KIST] : 0;

    $tdcpriceonetax    = TRANSPORT_TAX;
    $tdcpricetwotax    = BEGRAVING_TAX;
    $kistTax    = KISTTAX;
    $crematieTax    = CREMATIE_TAX;


    $calloactionOnetax = ( $tdcpriceone * $tdcpriceonetax ) / 100;
    $calloactionTwotax = ( $tdcpricetwo * $tdcpricetwotax ) / 100;
    $kistptax          = ( $kistprice * $kistTax ) / 100;
    $crematietax       = ( $crematie * $crematieTax ) / 100;

    $tdlocationfinalpriceone = $tdcpriceone - $calloactionOnetax;
    $tdlocationfinalpricetwo = $tdcpricetwo - $calloactionTwotax;
    $tdkistfinal = $kistprice - $kistptax;
    $tdcrematiefinalprice = $crematie - $crematietax;

    $tdtotalamount += $tdlocationfinalpriceone;
    $tdtotalamount += $tdlocationfinalpricetwo;
    $tdtotalamount += $tdkistfinal;
    $tdtotalamount += $tdcrematiefinalprice;

    $tdshowponecal = $tdlocationfinalpriceone + $calloactionOnetax;
    $tdshowptwocal = $tdlocationfinalpricetwo + $calloactionTwotax;
    $tdshowkist = $tdkistfinal + $kistptax;
    $tdshowcrematie = $tdcrematiefinalprice + $crematietax;

    ob_start();
    ?>
    <div class="tdinvoice_preview">
        <div class="headerBlock" style="width:100%;border:none;text-align:center;margin-bottom: 50px;margin-top: 30px;">
            <img src="https://teamdigital.be/wp-content/uploads/2018/08/Teamdigital-logo.png">
        </div>

        <h4 class="tdinvoice_heading tdw-50">Gegevens overledene</h4>
        <ul class="tdinvoice-topinfo">
            <li><span>Leeftijd</span> <?php echo $alldata['tddate']; ?></li>
            <li><span>Gemeente van overlijden</span> <?php echo $alldata['cityselectone']; ?></li>
            <li><span>Woonplaats</span> <?php echo $alldata['cityselettwo']; ?></li>
        </ul>
        <h4 class="tdinvoice_heading tdmt-15 tdw-50">Uw keuze</h4>
        <?php 
            if($formfor === 'cremation'){
                echo '<p>Cremation</p>';
            } else {
                echo '<p>Begraving</p>';
            }
        ?>
        <h4 class="tdinvoice_heading tdmt-15">Overzicht kosten</h4>

        <table>
            <thead>
                <tr>
                    <th width="220" align="left"><strong>NAAM</strong></th>
                    <th width="100" align="center"><strong>SUBTOTAAL</strong></th>
                    <th width="50" align="center"><strong>BTW</strong></th>
                    <th width="50" align="center"><strong>%</strong></th>
                    <th width="120" align="center"><strong>TOTAAL</strong></th>
                </tr>
            </thead>
            <tbody>

            <tr><td><b style="margin-top: 10px;display: block;color: #af5801;">Basisdiensten</b></td></tr>

<?php
    if($formfor == 'cremation'){ ?>

            <tr>
                <td width="220" align="left">Crematie</td>
                <td width="100" align="center">€<?php echo $tdcrematiefinalprice; ?></td>
                <td width="50" align="center">€ <?php echo $crematietax; ?></td>
                <td width="50" align="center"><?php echo $crematieTax; ?>%</td>
                <td width="120" align="center">€ <?php echo $tdshowcrematie; ?></td>
            </tr>
    <?php
    } else {
    ?>
            <tr>
                <td width="220" align="left">Begraving</td>
                <td width="100" align="center">€ <?php echo $tdlocationfinalpricetwo; ?></td>
                <td width="50" align="center">€ <?php echo $calloactionTwotax; ?></td>
                <td width="50" align="center"> <?php echo $tdcpricetwotax; ?>%</td>
                <td width="120" align="center">€ <?php echo $tdshowptwocal; ?></td>
            </tr>
    <?php    
    }
    if($formfor !== 'cremation'){ 
        ?>
            <tr>
                <td width="220" align="left">Kist</td>
                <td width="100" align="center">€ <?php echo $tdkistfinal; ?></td>
                <td width="50" align="center">€ <?php echo $kistptax; ?></td>
                <td width="50" align="center"> <?php echo $kistTax; ?>%</td>
                <td width="120" align="center">€ <?php echo $tdshowkist; ?></td>
            </tr>
        <?php
    }
?>
        <tr>
            <td width="220" align="left">Transport</td>
            <td width="100" align="center">€ <?php echo $tdlocationfinalpriceone; ?></td>
            <td width="50" align="center">€ <?php echo $calloactionOnetax; ?></td>
            <td width="50" align="center"><?php echo $tdcpriceonetax; ?>%</td>
            <td width="120" align="center">€ <?php echo $tdshowponecal; ?></td>
        </tr>

<?php

$tdcount = 0;
foreach ( $payloaddata as  $key => $payload ) {

    $section_title = (isset($payload[0]['label']) && isset($payload[0]['price']) && !empty($payload[0]['price']) )  ? $payload[0]['label'] : '';
    if($section_title && $section_title != 'Basisdiensten'){
        echo '<tr><td><b style="margin-top: 10px;display: block;color: #af5801;">'.$section_title.'</b></td></tr>';
    }
    
    foreach ( $payload as $formdata ) {

        $tdtotalamount += (float) $formdata['price'];
        $tdtax     = ( isset( $formdata['tax'] ) && $formdata['tax'] != '' ) ? $formdata['tax'] : 0;
        $shotdtax  = ( $tdtax != 0 ) ? $tdtax . '%' : '-';
        $taxamount = ( (float) $formdata['price'] * $tdtax ) / 100;
        $tdtaxamount += (float) $taxamount;
        $tdtotalamount += (float) $taxamount;
        $tdsubrow = (float) $formdata['price'] - $taxamount;
        $totalrow = (float) $taxamount + (float) $tdsubrow;
        $grandTotal += (float) $totalrow;

        if ( isset( $formdata['price'] ) && ! empty( $formdata['price'] ) ):

            if(isset($formdata['type']) && $formdata['type'] === 'image_price'){
                $pricetitle = $formdata['label'].' : '.$formdata['value'];
            } else {
                $pricetitle = $formdata['key'];
            }
            
            ?>
            <tr>
                <td width="220" align="left"><?php echo $pricetitle; ?></td>
                <td width="100" align="center">€ <?php echo $tdsubrow; ?></td>
                <td width="50" align="center">€ <?php echo $taxamount; ?></td>
                <td width="50" align="center"> <?php echo $shotdtax; ?></td>
                <td width="120" align="center">€ <?php echo $totalrow; ?></td>
            </tr>
            <?php
        endif;

    } // end 2nd foreach

}// end first foreach
$grandTotal += (float) $tdshowponecal + (float) $tdshowptwocal + (float) $tdshowkist;
?>

            
            </tbody>
        </table>
        <h4 class="tdinvoice_heading tdmt-15">Totale kostprijs </h4>
        <table>
            <tbody>
                <tr>
                    <td width="220" align="left"></td>
                    <td width="100" align="center"></td>
                    <td width="50" align="center"></td>
                    <td width="50" align="center"> </td>
                    <td width="120" align="center">€ <?php echo $grandTotal; ?></td>
                </tr> 
            </tbody>
        </table>
    </div>
    <?php
    return ob_get_clean();
}