<?php
$sImmobilienScout24Key = '<your key>';
$sImmobilienScout24Secret = '<your secret>';
$sWorkingSpace = 'sandbox';  //sanbox or IS24
$aDatabase = array(	'mysql' , 'localhost' , 'username' , 'userpassword' , 'database' );  //you need an local database for some advanced requests
$sCallbackURL = '<your callbackURL>';  //this script will be called after authentification
//define a search. Example serach: get all houses to buy in europe from my own account
$aSearchParameter = array( 'geocodes'=>1, 'realestatetype'=>'housebuy', 'channel'=>'hp','username'=>'me' );

// initialize php-sdk
require_once('Immocaster/Sdk.php');
$oImmocaster = Immocaster_Sdk::getInstance( 'is24',  $sImmobilienScout24Key, $sImmobilienScout24Secret );
$oImmocaster->setRequestUrl( $sWorkingSpace );

// database connect
$oImmocaster->setDataStorage($aDatabase);

// authorize
if(isset($_GET['main_registration'])||isset($_GET['state']))
{
	$aParameter = array( 'callback_url'=>$sCallbackURL, 'verifyApplication'=>true );
	if($oImmocaster->getAccess($aParameter)) echo 'registration was successful';
	if($_GET['state'] == 'authorized') authorizedAction();
}
else echo '<a href="'.$PHP_SELF.'?main_registration=1'.'">certify application</a>';

// run a authorized function
function authorizedAction()
{
	global $oImmocaster, $aSearchParameter;	
	$res = $oImmocaster->regionSearch($aSearchParameter); 
	echo '<pre>'.print_r( $res,true).'</pre>'; 
}

?>