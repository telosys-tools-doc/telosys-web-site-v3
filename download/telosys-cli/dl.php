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

$fileFound = false ;
if (isset($_GET['ver'])) {
    //The parameter you need is present
	$version = $_GET['ver'];
	$filename = "telosys-cli-" . $version . ".zip";
	if ( file_exists($filename) ) {
		$fileFound = true ;
		increment();
		header("Location:$filename");
	}
}
if ( ! $fileFound ) {
	header("HTTP/1.1 404 Not Found");
	echo "<h1>File not found</h1>";
}
?>