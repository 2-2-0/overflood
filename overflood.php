<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<!-- overflood.php, by 220 -->
<!-- an automatic information filler tool for developers -->
<!-- use it to create controlled, designed information for SQL dbs -->

<html>
<head>
  <title>deadman's overflood</title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta name="AUTHOR" content="220">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <style type="text/css">

A {
	color: #ffff00;
}

  </style>
</head>
<body>

<h1>deadman's overflood</h1>

<A HREF="?">Restart</A>

<?php
function dbConnect ($query) {
$hostname = "localhost";
$username = "username";
$database = "database";
$password = "password";

	$result = mysql_connect ($hostname,$username,$password);
	@mysql_select_db ($database) or  die ();
	$results=mysql_query ($query);
	mysql_close ();

	return ($results);
}


function tables_screen () {

	print ("<H2>Available tables</H2>\n");

	$query = "SHOW TABLES from ".$database;
	$results = dbConnect ($query);
	
	print ("<TABLE>\n");
	for ($i=0; $i<mysql_num_rows ($results); $i++) {
		$table_name = mysql_result ($results, $i);

		print ("<TR>\n");
		print ("<TD>\n");
		print ("<A HREF=\"?table_name=".$table_name."&action=setup\">");
		print ($table_name);
		print ("</A><br />\n");
		print ("<TD>\n");
		print ("<TR>\n");
	}
	print ("</TABLE>\n");
}

function generator_Word ($type) {
	$short = Array ("El", "La", "Su", "A", "Tu", "Es", "Y", "O", "Si", "En", "Va");
	$pre = Array ("Cabe", "Como", "Cual", "Donde", "Cuando", "Desde", "Ante", "Con", "Contra", "Desde", "Entre", "Hacia", "Hasta", "Para", "Por", "Según", "Sobre", "Tras");
	$words = Array ("Nuestro", "Antepongo", "Concuerdo", "Desacuerdo", "Antepuesto", "Aprovechamiento", "Suelo", "Desarrollo", "Producto", "Simpatía", "Desperdicio", "Administración", "Empleado", "Persona", "Consecuente", "Empuje", "Levante", "Reja", "Astucia", "Teclado", "Revisión", "Adiestramiento", "Libreta", "Individuo", "Individual", "Alcance", "Cable", "Pantalla", "Comunicación", "Trabajo", "Monitor", "Guitarra", "Batería", "Consola", "Cableado", "Vamos", "Grupo", "Mismo", "Frase", "Veces", "Ganas", "Además", "Sobrepuesto", "Alcanzable", "Impetu", "Alcancía", "Oral", "Vidrio", "Ventas", "Proyección", "Presupuesto", "Sustentable", "Menor", "Mayor", "Papel", "Robot", "Tecnología", "Ordenador", "Computadora");
	$verbs = Array ("Subir", "Bajar", "Empatar", "Correr", "Asimilar", "Desarrollar", "Ganar", "Argumentar", "Asentar", "Perder", "Avanzar", "Convocar", "Auxiliar", "Subsistir", "Crecer", "Ordenar", "Sobreestimar", "Valuar");
	
	$words = array_merge ($words, $verbs);

	$words_lib = Array (null, $short, $pre, $words, $verbs);

	$result = null;
	if ($type==null) {
		$seed = rand (0, count ($words_lib)-1);
		$set =  $words_lib [$seed];
		$seed = rand (0, count ($set)-1);
		$result = $set [$seed];
	} else {
		$set = $words_lib [$type];
		$seed = rand (0, count ($set)-1);
		$result = $set [$seed];
	}
	return $result;
}

function generator_RealText ($maxlen) {


	$inner_signs = Array (",", ",", ",", ",", ".", ".", ";", "...");

	$output= "";
	$used_words = 0;
	$used_phrases = 0;
	// Whole text
	while (strlen ($output)<$maxlen) {
		$used_phrases = 0;
		$paragraph_phrases = rand (3, 7);
		$output = $output."&nbsp;&nbsp;&nbsp;&nbsp;";
		while ($used_phrases<$paragraph_phrases) {
			// Phrase
			$used_words = 0;
			$phrase_words = rand (5, 15);
		
			// First word
			$seed = rand (0,100);
			if ($seed < 75) $output = $output.generator_Word (1)." ";
			else $output = $output.generator_Word (2)." ";
		
			while ($used_words<$phrase_words) {
				$seed = rand (1,100);
				if ($seed < 30) $word = generator_Word (1)." ";
				else if ($seed < 60) $word= generator_Word (2)." ";
				else $word = generator_Word (3)." ";
				
				$word = strtolower ($word);
				$output = $output.$word;
				$used_words++;
			}
			$output = substr ($output,0,-1);
			$output = $output.$inner_signs [rand (0, count ($inner_signs)-1)]." ";
			$used_phrases++;
		}
		
		$output = substr ($output, 0, -2);
		$output = $output.".<br /><br />\n";
	}

	return $output;
}

function generator_RealTextTitle () {


	$inner_signs = Array (",", ",", ",", ",", ".", ".", ";", "...");

	$output= "";

	// Whole text

	for ($i=0; $i<rand (4,8); $i++) {
		
		$seed = rand (0,100);
		if ($seed < 30) $word = generator_Word (1)." ";
		else if ($seed < 60) $word= generator_Word (2)." ";
		else $word = generator_Word (3)." ";

		$word = strtolower ($word);
		$output = $output.$word;
	}

	return $output;
}

function flood_screen () {

	$first_names_male = Array ("Alejandro", "Andrés", "Alberto", "Armando", "Arturo", "Bernardo", "Basilio", "Carlos", "Carlo", "David", "Daniel", "Edgar", "Eduardo", "Edmundo", "Francisco", "Fernando", "Fortunato", "Gonzalo", "Gabriel", "Gerardo", "Iñaki", "Iñigo", "Javier", "José", "Luis", "Manuel", "Miguel", "Norberto", "Nerón", "Oscar", "Roberto", "Salvador", "Tonatiuh", "Uriel", "Walther", "Xicotencatl");
	
	$first_names_female = Array ("Alicia", "Alejandra", "Constanza", "Carmen", "Denisse", "Deyanira", "Erica", "Elena", "Janette", "Jessica", "Luisa", "Leticia", "Mónica", "Martha", "Nubia", "Natalia", "Ofelia",  "Patricia", "Paola", "Susana");
	
	$last_names = Array ("Alvarez", "Castañón", "Castañeda", "Fernández", "Hernández", "Rodríguez");
	
	$table_name = $_GET ["table_name"];
	$total_rows = $_POST ["total_rows"];

	$how_many = $_POST ["how_many"];

	print ("<H2>Flooding ".$table_name."</H2>\n");
	print ("<A HREF=\"?action=setup&table_name=".$table_name."\">Go back to table flood description</A><br />\n");
	print ("<A HREF=\"?\">Select another table to flood</A><br />\n");

	$query = "SHOW FIELDS from ".$table_name;
	$results = dbConnect ($query);
	$num_rows = mysql_num_rows ($results);

	$fields = Array ();
	$values = Array ();
	$quotes = Array ();

	for ($i=0; $i<$num_rows; $i++) {
		$fields [$i] = mysql_result ($results, $i);
	}

	$fields_str = "";
	$values_str = "";
	$query = "INSERT INTO ".$table_name." (";
	
	for ($i=0; $i<count ($fields); $i++) {
		$query = $query.$fields [$i].", ";
		
	}
	$query=substr ($query, 0, -2);
	$query = $query.") VALUES (";
	$query_template = $query;
	print ("Total rows: ".$total_rows."<br /><br />");
	
	for ($x=0; $x<$how_many; $x++) {
		$query = $query_template;
		
		for ($i=0; $i<$total_rows; $i++) {
			$field = $_POST ["field_name".$i];
			$flood_type = $_POST ["flood_type".$i];
			$value = $_POST ["value".$i];
			$quotes = $_POST ["quotes".$i];
	
			switch ($flood_type) {
				case 0: // null / as is...
					$values [$i] = "null";
					break;
				case 1: // static value
					$values [$i] = $value;
					break;
				case 2: // random numbers (ranged)
					$numbers = explode (",", $value);
					$values [$i] = rand ($numbers [0], $numbers [1]);
					break;
				case 3: // random text words
					$numbers = explode (",", $value);
					$string = "";
					$feed = false;
					for ($j=$numbers [0]; $j<$numbers [1]; $j++) {
						if (rand (0,10)<9) {
							if ($feed) {
								$string = $string.chr (rand (65, 91)); 
								$feed = false;
							} else {
								$string = $string.chr (rand (97, 121)); 
							}
						} else {
							$string = $string." ";
							$feed = true;
						}
					}
					$values [$i] = $string;
					break;
				case 4: // First names (male)
						$values [$i] = $first_names_male [rand (0, count ($first_names_male)-1)];
					break;
				case 5: // First names  (female)
						$values [$i] = $first_names_female [rand (0, count ($first_names_female)-1)];
					break;
				case 6: // First names  (mixed)
						$first_names = array_merge ($first_names_male, $first_names_female);
						$values [$i] = $first_names [rand (0, count ($first_names)-1)];
					break;
				case 7: // Last names
						$values [$i] = $last_names [rand (0, count ($last_names)-1)];
					break;
				case 8: // Fullnames (male)
						$first_names = array_merge ($first_names_male, $first_names_female);
						$values [$i] = $first_names [rand (0, count ($first_names)-1)]." ".$last_names [rand (0, count ($last_names)-1)];
					break;
				case 10: // First names  (mixed)
						$first_names = array_merge ($first_names_male, $first_names_female);
						$values [$i] = $first_names [rand (0, count ($first_names)-1)];
					break;
				case 11: // date
						$year = rand (1945, 2000);
						$month = rand (1, 12);
						$day = rand (1,28);
						$date = $year."-".$month."-".$day;
						$values [$i] = date ("Y-m-d", $date);
					break;
				case 15: // RealText
						$values [$i] = generator_RealText ($value);
						break;
				case 16: // RealText title
						$values [$i] = generator_RealTextTitle (null);
						break;
			}
			if ($quotes) $query = $query."'";
			$query = $query.$values [$i];
			if ($quotes) $query = $query."'";
			$query = $query.", ";
	
		}
		$query = substr ($query, 0, -2);
		$query = $query.")";
	
		dbConnect ($query);
		print ($x." ".substr ($query,0, 50)."...<br /><br />\n");

	}
	
	print ("Flooded.<br />");
}

function kill_screen () {
	$table_name = $_GET ["table_name"];

	print ("<H2>".$table_name."</H2>\n");

	$query = "DELETE FROM ".$table_name;
	dbConnect ($query);
	echo ($query);
	print ("Table killed...<br /><br />\n");

	print ("<A HREF=\"?action=setup&table_name=".$table_name."\">Go back to table flood description</A><br />\n");
}

function setup_screen () {
	$table_name = $_GET ["table_name"];

	print ("<H2>".$table_name."</H2>\n");
	print ("<A HREF=\"?\">Select another table to flood</A><br />\n");


	$query = "SHOW FIELDS from ".$table_name;
	$results = dbConnect ($query);
	$num_rows = mysql_num_rows ($results);
	

	print ("<FORM method=\"POST\" action=\"?table_name=".$table_name."&action=flood\">\n");
	print ("<INPUT type=\"hidden\" name=\"\" value=\"\" />\n");
	print ("<INPUT type=\"hidden\" name=\"total_rows\" value=\"".$num_rows."\" />\n");

	print ("<TABLE>\n");
	print ("<TR><TH>name</TH><TH>action</TH><TH>value</TH><TH>Quoted</TH></TR>\n");
	for ($i=0; $i<$num_rows; $i++) {
		$field_name = mysql_result ($results, $i);
		print ("<TR>\n");
		print ("<TD>\n");
		print ($i." ");
		print ($field_name);
		print ("<INPUT type=\"hidden\" name=\"field_name".$i."\" value=\"".$field_name."\" />\n");
		print ("</TD>\n");

		print ("<TD>\n");
		print ("<SELECT name=\"flood_type".$i."\">");
		print ("<OPTION value=\"0\">Leave as is</OPTION>\n");
		print ("<OPTION value=\"1\">Static value</OPTION>\n");
		print ("<OPTION value=\"2\">Random numbers (min,max)</OPTION>\n");
		print ("<OPTION value=\"3\">Random garbled text (min,max)</OPTION>\n");
		print ("<OPTION value=\"4\">First names (male)</OPTION>\n");
		print ("<OPTION value=\"5\">First names (female)</OPTION>\n");
		print ("<OPTION value=\"6\">First names (mixed)</OPTION>\n");
		print ("<OPTION value=\"7\">Last names</OPTION>\n");
		print ("<OPTION value=\"10\">Full name (mixed)</OPTION>\n");
		print ("<OPTION value=\"11\">Date</OPTION>\n");
		print ("<OPTION value=\"15\">Real Text (# chars)</OPTION>\n");
		print ("<OPTION value=\"16\">Real Text (title)</OPTION>\n");
		print ("</SELECT>\n");
		print ("</TD>\n");

		print ("<TD>\n");
		print ("<INPUT type=\"text\" name=\"value".$i."\">");
		print ("</TD>\n");

		print ("<TD>\n");
		print ("<INPUT type=\"checkbox\" name=\"quotes".$i."\">");
		print ("</TD>\n");

		print ("<TR>\n");
	}

	print ("<TR><TD colspan=\"3\">\n");
	print ("# of records: <INPUT type=\"text\" name=\"how_many\" />\n");
	print ("</TD></TR>\n");

	print ("<TR><TD colspan=\"3\">\n");
	print ("<INPUT type=\"submit\" value=\"FLOOD!\" />\n");
	print ("<INPUT type=\"reset\" value=\"Clear form\" />\n");
	print ("<INPUT type=\"button\" value=\"Erase DB\" onclick=\"\" />\n");
	print ("</TD></TR>\n");
	
	print ("</TABLE>\n");
	print ("</FORM>\n");

}
function contents_screen () {
	$table_name = $_GET ["table_name"];

	print ("<H2>".$table_name." contents</H2>\n");
	print ("<A HREF=\"?action=kill&table_name=".$table_name."\">Clean whole table</A><br /><br />\n");
	print ("<A HREF=\"?\">Select another table to flood</A><br />\n");

	

	$query = "SHOW FIELDS from ".$table_name;
	$results_fields = dbConnect ($query);

	$query = "SELECT * FROM ".$table_name;
	$results_values = dbConnect ($query);

	print ("<TABLE border=\"1\">\n");
	print ("<TR>\n");
	for ($i=0; $i<mysql_num_rows ($results_fields); $i++) {
		print ("<TH>".mysql_result ($results_fields, $i)."</TH>");
	}
	print ("</TR>\n");

	for ($i=0; $i<mysql_num_rows ($results_values); $i++) {
		print ("<TR>\n");
		for ($j=0; $j<mysql_num_rows ($results_fields); $j++) {
			print ("<TD>".mysql_result ($results_values, $i, $j)."</TD>\n");
		}
		print ("<TR>\n");
	}

	print ("</TABLE>\n");
	print ("</FORM>\n");

	print ("<A HREF=\"?\">Select another table to flood</A><br />\n");

}

$action = $_GET ["action"];
switch ($action) {
	case "setup":
		setup_screen ();
		contents_screen ();
		break;
	case "flood":
		flood_screen ();
		contents_screen ();
		break;
	case "kill":
		kill_screen ();
		contents_screen ();
	case null:
		tables_screen ();
		break;
}

?>
<br /><br />

</body>
</html>
