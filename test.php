<?php

require_once 'bom-au.php';

//Create the bom object.
$bom = new bom;

//Request a data feed for JSON.
$data_json = $bom->get_json( 'IDV60801/IDV60801.94883.json' );

//Request a data feed for XML (via ftp)
$data_xml = $bom->get_xml( 'IDV10461.xml' );

//Display the data we've fetched.
if ( $data_json ) {
  echo $data_json;
} else {
  echo "Error fetching JSON.\n";
}

if ( $data_xml ) {
  echo $data_xml;
} else {
  echo "Error fetching XML.\n";
}
