<?php

function tdgetorder_details($alldata = [], $pricefields = []){

    $total = null;

    $data = '';
    $data .= <<<EOD
    <style>
        table.tdpdetails {
          border-collapse: collapse;
        }
        table.tdpdetails, .tdpdetails th, .tdpdetails td {
          border: 1px solid black;
          background-color: #ffffff;
        }
    </style>
    EOD;

        $cityOne = CITYPRICEONE;
        $cityTwo = CITYPRICETWO;

        $grandTotal    = 0;
        $tdtotalamount = 0;
        $tdtaxamount   = 0;
        $totalrow      = 0;
        $formfor = $alldata['formfor'];

        $tdcpriceone = (float) $alldata[CITYPRICEONE];
        $tdcpricetwo = isset($alldata[CITYPRICETWO]) ? (float) $alldata[CITYPRICETWO] : 0;
        $tdcpricecrematie = isset($alldata[CITYCREMATIE]) ? (float) $alldata[CITYCREMATIE] : 0;

        $tdcpriceonetax    = 21;
        $tdcpricetwotax    = 6;
        $cecrematietax    = 6;
        $calloactionOnetax = ( $tdcpriceone * $tdcpriceonetax ) / 100;
        $calloactionTwotax = ( $tdcpricetwo * $tdcpricetwotax ) / 100;
        $crematietax = ( $tdcpricecrematie * $cecrematietax ) / 100;

        $tdlocationfinalpriceone = $tdcpriceone - $calloactionOnetax;
        $tdlocationfinalpricetwo = $tdcpricetwo - $calloactionTwotax;
        $tdcrematiefinalprice = $tdcpricecrematie - $crematietax;

        $tdtotalamount += $tdlocationfinalpriceone;
        $tdtotalamount += $tdlocationfinalpricetwo;
        $tdtotalamount += $tdcrematiefinalprice;

        $tdshowponecal = $tdlocationfinalpriceone + $calloactionOnetax;
        $tdshowptwocal = $tdlocationfinalpricetwo + $calloactionTwotax;
        $tdshowcrematie = $tdcrematiefinalprice + $crematietax;


        if($formfor == 'cremation'){
            $crematie_begraving = <<<EOD
                <tr>
                    <td width="220" align="left">Crematie</td>
                    <td width="100" align="center">€{$tdcrematiefinalprice}</td>
                    <td width="50" align="center">€{$crematietax}</td>
                    <td width="50" align="center">{$cecrematietax}%</td>
                    <td width="120" align="center" color="#ffffff" style="background-color:#3989c6; color: #fff;">€{$tdshowcrematie}</td>
                </tr>
            EOD;
        } else {
            $crematie_begraving = <<<EOD
            <tr>
                <td width="220" align="left">Begraving</td>
                <td width="100" align="center">€{$tdlocationfinalpricetwo}</td>
                <td width="50" align="center">€{$calloactionTwotax}</td>
                <td width="50" align="center">{$tdcpricetwotax}%</td>
                <td width="120" align="center" color="#ffffff" style="background-color:#3989c6; color: #fff;">€{$tdshowptwocal}</td>
            </tr>
            EOD;        
        }

        $data .= <<<EOD
        Datum overlijden : {$alldata['tddate']}<br>
        Gemeente van overlijden : {$alldata['cityselectone']}<br>
        Woonplaats : {$alldata['cityselettwo']}<br><br>

        <table class="tdpdetails" cellpadding="5" cellspacing="0" style="background-color:#eee;" width="100%">
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
            <td width="120" align="center" color="#ffffff" style="background-color:#3989c6; color: #fff;">€{$tdshowponecal}</td>
        </tr>
    EOD;
        foreach ( $pricefields as $formdata ) {

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
                    <td width="120" align="center" color="#ffffff" style="background-color:#3989c6; color: #fff;">-</td>
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
                    <td width="120" align="center" color="#ffffff" style="background-color:#3989c6; color: #fff;">-</td>
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
                    <td width="120" align="center" color="#ffffff" style="background-color:#3989c6; color: #fff;">€{$totalrow}</td>
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
    return $data;
}

function get_tdresources( $pkey, $pvalue ) {
    $getFields     = stripslashes_deep( get_option( 'tdfuneral_forms', true ) );

    $taslim_values = [];
    for ( $i = 0; $i <= count( $getFields ); $i++ ) {
        if ( isset( $getFields[$i]['options'] ) ):
            $opfield = $getFields[$i]['options'];
            for ( $x = 0; $x <= count( $opfield ); $x++ ) {
                if ( isset( $opfield[$x] ) ) {
                    $taslim_values[] = array(
                        'type'  => ( isset( $getFields[$i]['type'] ) ) ? $getFields[$i]['type'] : '',
                        'name'  => ( isset( $getFields[$i]['name'] ) ) ? $getFields[$i]['name'] : '',
                        'label' => ( isset( $getFields[$i]['label'] ) ) ? $getFields[$i]['label'] : '',
                        'key'   => ( isset( $opfield[$x]['key'] ) ) ? $opfield[$x]['key'] : '',
                        'value' => ( isset( $opfield[$x]['value'] ) ) ? $opfield[$x]['value'] : '',
                        'price' => ( isset( $opfield[$x]['price'] ) ) ? $opfield[$x]['price'] : 0,
                        'tax'   => ( isset( $opfield[$x]['price'] ) ) ? $opfield[$x]['tax'] : 0,
                        'optiondescription'   => ( isset( $opfield[$x]['optiondescription'] ) ) ? $opfield[$x]['optiondescription'] : 0,
                        'optiondescriptiontwo'   => ( isset( $opfield[$x]['optiondescriptiontwo'] ) ) ? $opfield[$x]['optiondescriptiontwo'] : 0,
                        'optionshow'   => ( isset( $opfield[$x]['optionshow'] ) ) ? $opfield[$x]['optionshow'] : 0,
                    );
                }
            }
        endif;
    }


    $returnvalue = [];
    if ( count( $taslim_values ) != 0 ) {
        foreach ( $taslim_values as $value ) {

            if (  (  ( isset( $value['name'] ) && $value['name'] === $pkey ) ) || (  ( isset( $value['key'] ) && $value['key'] === $pkey ) ) ) {
                $returnvalue = $value;
            }
            // if ( ( (isset($value['name']) && $value['name'] === $pkey) || (isset($value['key']) && $value['key'] === $pkey) ) && ( isset($value['value']) && $value['value'] === $pvalue ) ) {

            // }

        }
    }



    return $returnvalue;
}