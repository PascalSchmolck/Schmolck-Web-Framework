<?php
/*
 * I5Access emuliert den nativen Zugriff über das i5_Toolkit mttels PHP ODBC
 * Es wurden nur die Funktionen implementiert, die in Cleo genutzt wurden.
 * 
 * Die gelisteten Funktionen sind absichtlich nicht in einer Klasse und
 * ihr Aufruf benötigt require_once("I5Access.php") im Konstruktor jeder Klasse,
 * so ist sichergestellt, dass die Aufrufe ohne Änderungen am Quelltext 
 * funktionieren. 
 */

define("I5_READ_NEXT",0);
define("I5_IN",0);
define("I5_TYPE_CHAR",0);

function i5_connect($server,$user,$pass)
{
	if($server=='127.0.0.1'){
		$dsn='REPDBF';
	}else{
		throw new exception("unbekannte IP in I5Access");
	}
	if($user==''){	
 		$user='SDBPHP';
		$pass='rita';
	}
	$connectionhandle=odbc_connect($dsn, $user, $pass);
	$_SESSION['i5_conn']=$connectionhandle;
	return $connectionhandle;
}

function i5_query($query, $connection=0)
{
	if($connection==0){
		$connection=$_SESSION['i5_conn'];
	}
	$query=preg_replace('/\//','.',$query,1);
	//$query=preg_replace('/REPDBF\//i','',$query);
	//$query=preg_replace('/CLEO\//i','',$query);
	$result=odbc_exec($connection,$query);
	return $result;
}

function i5_error($connection=0)
{
	if($connection==0){
		$connection=$_SESSION['i5_conn'];
	}
	$e[0]=odbc_error($connection);
	$e[3]=odbc_errormsg($connection);
	return $e;
}

function i5_fetch_row($result,$option)
{
	$val=array();
	odbc_fetch_into($result,$val);
	return $val;
}

function i5_free_query($query)
{
	odbc_free_result($query);
}

function i5_close($connection)
{
	if(isset($_SESSION['i5_conn'])){
		unset($_SESSION['i5_conn']);
	}
	odbc_close($connection);
}

function i5_command($cmd)
{
	//wurde nur zum setzen der Biliotheksliste genutzt
	//diese ist im ODBC DSN Care hinterlegt
	//darum verbinden wir jetzt zu Care
	$care=odbc_connect("CARE","SDBPHP","rita");
	if(!$care){
		throw new Exception('i5_command: Keine Verbindung zu DSN=Care');
	}
	$_SESSION['i5_care']=$care;
	return true;
}

function i5_program_prepare($name,$desc,$con)
{
	//nur Programmname merken
	return $name;
}

function i5_program_call($name, $p)
{
	if(isset($_SESSION['i5_care'])){
		$con=$_SESSION['i5_care'];
	}else{
		throw new Exception('i5_programm_call ohne i5_care');
	}
	$sql = "CALL $name('".$p['fa']."','".$p['fi']."','".$p['nr']."','".$p['fg'];
	$sql.= "','".$p['as']."','".$p['ra']."','".$p['rt']."','".$p['tx']."','".$p['us']."')";
	$result=odbc_exec($con,$sql);
	odbc_free_result($result);
	return true;
}

function i5_program_close($name)
{
	//ODBC Verbindung zu DSN Care schließen
	if(isset($_SESSION['i5_care'])){
		$con=$_SESSION['i5_care'];
		unset($_SESSION['i5_care']);
		odbc_close($con);
		return true;
	}else{
		return false;
	}
		
}


