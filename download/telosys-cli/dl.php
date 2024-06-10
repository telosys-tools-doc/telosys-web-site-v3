<?php
function increment() {
	$d = date("Y-m");
	$f = "count-" . $d . ".txt"; 
	if(!file_exists($f)){
		// Init file
		$fp=fopen("$f","w");
		fputs($fp,"0");
		fclose($fp);
	}
	// Update file : count + 1 
	$fp=fopen("$f","r+");
	$nb=fgets($fp,10);
	$nb++;
	fseek($fp,0);
	fputs($fp,$nb);
	fclose($fp);
}

function log_download() {
	$SEP = " | ";
	$dh= date("Y-m-d H:i:s");
	$row = $dh . $SEP;
	if ( isset($_SERVER['REMOTE_ADDR']) ) {
		$row = $row . $_SERVER['REMOTE_ADDR'];
	}
	$row = $row . $SEP;
	if ( isset($_SERVER['HTTP_USER_AGENT']) ) {
		$row = $row . $_SERVER['HTTP_USER_AGENT'];
	}
	$row = $row . $SEP;
	if ( isset($_SERVER['QUERY_STRING']) ) {
		$row = $row . $_SERVER['QUERY_STRING'];
	}

	$ym = date("Y-m");
	$logfile = "log-" . $ym . ".txt";
	$f = fopen($logfile, "a") or die("Unable to open log file!");
	fwrite($f, $row . PHP_EOL );
	fclose($f);
}

$fileFound = false ;
if (isset($_GET['ver'])) {
    //The parameter you need is present
	$version = $_GET['ver'];
	$filename = "telosys-cli-" . $version . ".zip";
	if ( file_exists($filename) ) {
		$fileFound = true ;
		increment();
		log_download();
		header("Location:$filename");
	}
}
if ( ! $fileFound ) {
	header("HTTP/1.1 404 Not Found");
	echo "<h1>File not found</h1>";
}
?>