#!/usr/bin/env php
<?php
/**
 * @file
 *
 * CLI script to get distribution keys for organizer
 *
 * Expected CLI arguments:
 * - endpoint URL
 * - consumer key
 * - consumer secret
 * - organizer cdbid
 */

date_default_timezone_set('Europe/Brussels');



// require the third-party oauth library which is not properly structured to be autoloaded

require_once dirname(__FILE__) . '/../../OAuth/OAuth.php';



function culturefeed_autoload($class) {

  $file = str_replace('_', '/', $class) . '.php';

  require_once $file;

}



spl_autoload_register('culturefeed_autoload');




try {
  $endpoint = $_SERVER['argv'][1];
  $consumer_key = $_SERVER['argv'][2];
  $consumer_secret = $_SERVER['argv'][3];
  $organizer_cdbid = $_SERVER['argv'][4];

  $oc = new CultureFeed_DefaultOAuthClient($consumer_key, $consumer_secret);
  $oc->setEndpoint($endpoint);
  $c = new CultureFeed($oc);

  
  
  $data = $c->uitpas()->getDistributionKeysForOrganizer( $organizer_cdbid );
  
  print_r($data);
  
}
catch (Exception $e) {
  $eol = PHP_EOL;
  $type = get_class($e);
  print "An exception of type {$type} was thrown." . PHP_EOL;
  print "Code: {$e->getCode()}" . PHP_EOL;
  if ($e instanceof CultureFeed_Exception) {
    print "CultureFeed error code: {$e->error_code}" . PHP_EOL;
  }
  print "Message: {$e->getMessage()}" . PHP_EOL;
  print "Stack trace: {$eol}{$e->getTraceAsString()}" . PHP_EOL;

  exit(1);
}