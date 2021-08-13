<?php

error_reporting(0);
ini_set('display_errors', 0);

$host = "mongo-db";

//connect to mongo db
$connection = new MongoClient( "mongodb://".$host.":27017" );

//select the application db
$db = $connection->selectDB('guestbook');
$collection = $db->selectCollection('messages');

if (isset($_GET['cmd']) === true)
{
	header('Content-Type: application/json');
	
	if ($_GET['cmd'] == 'set')
	{
		$document = array(
			'text' => $_GET['value'],
			'date' => date( 'Y-m-d H:i:s' )
		);
		$collection->insert($document);
		print('{"message": "Updated"}');
	}
	else
	{
		$cursor = $collection->find();
		
		$response = array();
		$cursor->sort( array( "_id" => -1 ) );
		foreach ( $cursor as $id => $value )
		{
			$response[] = array( 'text' => $value['text'], 'date' => $value['date'] );
		}
		
		echo json_encode( $response );
	}
}
else
{
}
/*
$document = array(
	'text' => 'Some text',
	'timestamp' => date( 'Y-m-d H:i:s' )

);
$collection->insert($document);
print_r( $collection );
*/
/*
Predis\Autoloader::register();

if (isset($_GET['cmd']) === true) {
  $host = 'redis-master';
  header('Content-Type: application/json');
  if ($_GET['cmd'] == 'set') {
    $client = new Predis\Client([
      'scheme' => 'tcp',
      'host'   => $host,
      'port'   => 6379,
    ]);

    $client->set($_GET['key'], $_GET['value']);
    print('{"message": "Updated"}');
  } else {
    $host = 'redis-master';
    $client = new Predis\Client([
      'scheme' => 'tcp',
      'host'   => $host,
      'port'   => 6379,
    ]);

    $value = $client->get($_GET['key']);
    print('{"data": "' . $value . '"}');
  }
} else {
  phpinfo();
}
*/