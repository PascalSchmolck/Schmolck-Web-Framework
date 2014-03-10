<?php
/*
 * testet alle in Cleo/I5Access definierten ODBC-Emulationen
 * des in Cleo verwendeten nativen i5-Toolkits
 */
class Cleo_I5AccessTest
{
	public function __construct()
	{
		require_once"Cleo/I5Access.php";
	}
	
	
	public function testall()
	{
		echo "i5_all->test() startet";
		$i5=i5_connect('127.0.0.1',"","");
		if(!$i5){
			throw new Exception('i5_all->test() i5_connect: Kein i5 Datenbankzugriff');
		}else{
			echo "<br />ODBC Datenverbindung aufgebaut";
		}
		
		$sql="select xyz, fafacd, fafanm, faplz, faort from repdbf.rpaarep";
		echo "<br \>fehlerhaft: $sql";
		$query=i5_query($sql);
		if(!$query){
			$i5e=i5_error();
			echo "<br />$i5e[1]<br />$i5e[3]";	
		}else{
			echo "<br />Datenbankabfrage erfolgreich";
		}
		$sql="select fafacd, fafanm, faplz, faort from repdbf.rpaarep";
		echo "<br \>richtig: $sql";
		$query=i5_query($sql);
		if(!$query){
			$i5e=i5_error();
			echo "<br />$i5e[1]<br />$i5e[3]";	
		}else{
			echo "<br />Datenbankabfrage erfolgreich";
		}
		?>
		<br />
		<table>
		<tr><th>Fa</th><th>Firma</th><th>PLZ</th><th>Ort</th></tr>
		<?php 
		$i=0;
		while(($val=i5_fetch_row($query, I5_READ_NEXT))){
		  echo "<tr><td>$val[0]</td><td>$val[1]</td><td>$val[2]</td><td>$val[3]</td></tr>";
		  $i++;
		}
		?>
		</table>
		<?php 
		echo "<br />i5_fetch_row erfolgreich: $i Sätze gelesen";
		i5_free_query($query);
		echo "<br />Query wieder freigegeben"; 
		i5_command('call schmolck/setlibcl') || die('setlibcl Fehler');
		echo "<br /> i5_command erfolgreich verarbeitet";
	
		$desc=array(
			array ("name"=>"fa", "io"=>I5_IN, "type" => I5_TYPE_CHAR, "length"=> "2"),
			array ("name"=>"fi", "io"=>I5_IN, "type" => I5_TYPE_CHAR, "length"=> "2"),
			array ("name"=>"nr", "io"=>I5_IN, "type" => I5_TYPE_CHAR, "length"=> "6"),
			array ("name"=>"fg", "io"=>I5_IN, "type" => I5_TYPE_CHAR, "length"=> "2"),
			array ("name"=>"as", "io"=>I5_IN, "type" => I5_TYPE_CHAR, "length"=> "6"),
			array ("name"=>"ra", "io"=>I5_IN, "type" => I5_TYPE_CHAR, "length"=> "6")
		);
		$i5=''; //whatever
		$prog=i5_program_prepare("REPPGM/RKM0125",$desc,$i5); 
		$prog || die("i5_program_prepare failed.");
		echo "<br />i5_programm_prepare erfolgreich - gemerkt: $prog";
		$fa='20'; $fi='11'; $nr='473785'; $fg='00';
		$params=array("fa"=>$fa,"fi"=>$fi,"nr"=>$nr,"fg"=>$fg,"as"=>"ASREPC", "ra"=>"RAUE102");
		
		i5_program_call($prog, $params) ||die("Fehler i5_program_call.");
		echo "<br />i5_programm_call noch in Arbeit";
		i5_program_close ($prog) || die("Fehler i5_program_close"); 
		echo "<br />i5_programm_close hat Verbindung zu DSN CARE geschlossen";
		i5_close($i5);
		echo "<br />i5_close hat Verbindung zu DSN REPDBF geschlossen";
		
	}
}