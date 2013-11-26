<?php

// Include the AWS PHP SDK
require 'aws/autoload.php';

// Configure your AWS Keys Here
$config = array('key' => '', 
					'secret' => '' , 
					'region' => 'us-east-1');

// Setup an EC2 Client
$ec2 = \Aws\Ec2\Ec2Client::factory($config);

// Configure which ports to scan for
$ports = array(22, 3389);

//Prompt user for the number of EIP addresses to Dive
$maxEIP = readline("Enter # of Elastic IP Addresses: ");

// Check for a valid number
if (!is_numeric($maxEIP) || $maxEIP <= 0) {
	echo "$maxIP is not a valid number.";
	die;
}


$eips = array();
$i = 0;

while ($i < $maxEIP) {
	
	$j = $i + 1;
	// Use the API to Request then Release Elastic IP Addresses
	echo "Requesting & Releasing EIP: ($j/$maxEIP) ";
	$eip = $ec2->allocateAddress()['PublicIp'];
	echo $eip . "\n";
	$result = $ec2->releaseAddress(array('PublicIp' => $eip));
	
	// Add the EIP to the array to later scan
	array_push($eips, array('ip'=>$eip, 'active'=>0));
	$i++;
}

// Now start scanning for the EIPs to be assigned to new
// instances
echo "Waiting for EIPs to be reassigned...\n";

// Disable error reporting from here on.. Supresses a warning when
// port is not open
error_reporting(0);

while (true) {
	foreach ($eips as &$eip) {
		if (!$eip['active']) {
			foreach ($ports as $port) {
				if ($socket = @fsockopen($eip['ip'], $port, $errno, $errstr, 1)) {
					echo $eip['ip'] . ":$port discovered open\n";
				}
			}
			fclose($socket);
			$eip['active'] = 1;
		}
	}
}

?>