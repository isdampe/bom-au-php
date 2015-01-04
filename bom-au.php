<?php
/*
 * @package bom-au
 * @version 0.1.0
 * @author http://github.com/isdampe
 * @license MIT
 *
 * A basic PHP library for pulling and parsing data from the
 * Australian Bureau of Meteorology.
 * Utilising data as outlined http://www.bom.gov.au/catalogue/data-feeds.shtml.
 *
 * You'll need to manually find the request paths for now.
*/

define( "BOM_BASE_URL",             "http://www.bom.gov.au/" );
define( "BOM_FWO_URL",              BOM_BASE_URL . "fwo/" );
define( "BOM_FTP_URL",              "ftp://ftp2.bom.gov.au/anon/gen/fwo/" );
define ("BOM_USER_AGENT",           "Mozilla/5.0 (en-AU; rv:1.8.1.13) PHP/ CURL/ BOM-AU-PHP/" );

class bom {

  function __construct() {

    //Initialize curl.
    $this->curl_init();

  }

  public function curl_init() {
    $this->ch = curl_init();
    curl_setopt( $this->ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $this->ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $this->ch, CURLOPT_USERAGENT, BOM_USER_AGENT );
  }

  public function curl_reinit() {
    curl_reset( $this->ch );
    curl_setopt( $this->ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $this->ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $this->ch, CURLOPT_USERAGENT, BOM_USER_AGENT );
  }

  /* Fetches a JSON data stream, as per requested path. */
  public function get_json( $path ) {
    //Example paths:
    //IDV60801/IDV60801.94883.json
    //IDV60701/IDV60701.94883.json

    //Build the url.
    $request_url = BOM_FWO_URL . $path;

    //Set curl url.
    curl_setopt( $this->ch, CURLOPT_URL, $request_url );

    //Execute the request.
    $result = curl_exec( $this->ch );

    $this->curl_reinit();

    if ( $result ) {
      return $result;
    } else {
      return false;
    }

  }

  /* Fetches an XML data stream off FTP, as per requested path. */
  public function get_xml( $path ) {
    //Example path:
    //IDV10461.xml

    //Build the url.
    $request_url = BOM_FTP_URL . $path;

    //Set curl url.
    curl_setopt( $this->ch, CURLOPT_URL, $request_url );

    //Execute the request.
    $result = curl_exec( $this->ch );

    $this->curl_reinit();

    if ( $result ) {
      return $result;
    } else {
      echo curl_error( $this->ch );
      return false;
    }

  }

  public function close() {
    curl_close( $this->ch );
    unset( $this) ;
  }

}
