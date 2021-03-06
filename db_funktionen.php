<?php



//Testmodus aktivieren / deaktivieren

define ("TESTMODUS", false);



	//Funktion zum Verbindungsaufbau
	function db_connect()
	{
		$dbserver	=	"localhost";
		$dbuser		=	"root";
		//$dbpasswort	= 	"root";
		$dbname		=	"umfrage";


		$dbh = new mysqli($dbserver, $dbuser) or die (db_fehler("connect"));

		mysqli_select_db($dbh,$dbname ) or die (db_fehler("select"));
		return $dbh;
	}

	//Abfragefunktion mit Verbidungsaufbau

	function db_query($sql)
	{
	if(TESTMODUS){echo $sql;}
	$dbh=db_connect();
	$result=mysqli_query($dbh,$sql ) or die (db_fehler("query",$dbh));
	db_close($dbh);
	return $result;
	}

	function db_insert($sql)
	{
		if(TESTMODUS){echo $sql;}
		$dbh=db_connect();
		
		mysqli_query($dbh,$sql ) or die (db_fehler("insert",$dbh));
		
		db_close($dbh);
	}
	//Verbindungsabbau

	function db_close($asdf)
	{
		mysqli_close($asdf);
	}

	//Fehlerbehandlung

	function db_fehler($fehler, $dbh)
	{
		if(TESTMODUS)
		{
			echo"Fehler beim MySQL-Befehl ".$fehler."<li> Fehlernummer errno = ".mysqli_errno($dbh)."<li> Fehlertext error = ".mysqli_error($dbh);
		}
	}


	function getCountOfRecordsInTable($tableName)
	{		
		$sql = "SELECT COUNT(*) FROM ".$tableName;
		$dbh=db_connect();
		$result=mysqli_query($dbh,$sql ) or die (db_fehler("querygetCountOfRecordsInTable"));
		$row=mysqli_fetch_row($result);
		db_close($dbh);
		return $row[0];
	}

	function getValueOfColumn($tableName, $pk, $column,$pkvalue)
	{
		$sql = "SELECT ".$column." FROM ".$tableName." WHERE ".$pk."=".$pkvalue;
		$dbh=db_connect();
		$result=mysqli_query($dbh,$sql ) or die (db_fehler("query"));
		db_close($dbh);
		$row=mysqli_fetch_row($result);
		return $row[0];
	}

	function getLerngruppeID($Bezeichnung)
	{
		$sql = "SELECT ID from Lerngruppe where Bezeichnung ='".$Bezeichnung."';";
		$dbh=db_connect();
		$result=mysqli_query($dbh,$sql ) or die (db_fehler("query"));
		db_close($dbh);
		$row=mysqli_fetch_row($result);
		return $row[0];
	}

	function getNameForId($ID,$Table)
	{
		$sql = "select Nachname from ".$Table." Where ID = ".$ID;
		$dbh=db_connect();
		$result=mysqli_query($dbh,$sql ) or die (db_fehler("query"));
		db_close($dbh);
		$row=mysqli_fetch_row($result);
		return $row[0];
	}
?>