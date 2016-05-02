
<?php
/*  
	Author Marco Gallo 2016
	Dump Tables
	Usage dump_table.php
	
	POST
	*method=[JSON|RCV]
	*table=[TABLE NAME]
	*jsondata=[JSON|NULL]
	
	* = required
	
	JSON = Export table with name TABLE NAME
	RCV = Import json datas into TABLE NAME
	NB. ID KEY , usually the first element settled as Auto increment are not considered ( the script start from 1 not from 0 )

*/

    $username = "root"; 
    $password = "fragole";   
    $host = "localhost";
    $database="portale";
	$server = mysqli_connect($host, $username, $password,$database);
	$token= isset($_POST['token'])?$_POST['token'] : '';
	$secret_token= "prova";
	$secret_token_associated_array=array();
	$method= isset($_POST['method'])? $_POST['method'] : '';
	$dump_table_name=isset($_POST['table'])? $_POST['table'] : '';
	$jsondata= isset($_POST['jsondata'])? $_POST['jsondata'] : '';
	$tokens_table_name="wp_tokens";
	
	//richiesta token
	$token_db_req = "SELECT token FROM ".$tokens_table_name." ORDER BY id DESC LIMIT 1;";
	$token_query = mysqli_query($server,$token_db_req);
	$secret_token=mysqli_fetch_assoc($token_query)['token'];
	
	$token_db_req = "SELECT id FROM ".$tokens_table_name." ORDER BY id DESC LIMIT 1;";
	$token_query = mysqli_query($server,$token_db_req);
	$secret_token_id=mysqli_fetch_assoc($token_query)['id'];
	
	
	if(strcmp($token,$secret_token)==0)
	{
		
		//rimozione token 
		$token_db_del = "DELETE FROM ".$tokens_table_name." WHERE id='".$secret_token_id."'";
		$token_del = mysqli_query($server,$token_db_del);
		if ( ! $token_del ) {
				echo mysqli_error($server);
				die;
		}  
	
		
		
		if(strcmp($method,"JSON")==0)
		{
			//http://portale.local/dump_table.php?token=prova&method=JSON&table=tco_contribuente
			$myquery = "SELECT * from ".$dump_table_name;
			$query = mysqli_query($server,$myquery);

			if ( ! $query ) {
				echo mysqli_error($server);
				die;
			}    
			$data = array();    

			for ($x = 0; $x < mysqli_num_rows($query); $x++) {
				$data[] = mysqli_fetch_assoc($query);
			}

			echo json_encode($data);     
			//echo " ENCODED : <br>";
			//echo $urlEncodedString = http_build_query($data);
			mysqli_close($server);
		}
		else if(strcmp($method,"RCV")==0)
		{
			//http://portale.local/dump_table.php?token=prova&method=JSON&table=tco_contribuente
			//portale.local/dump_table.php?token=prova&method=RCV&table=tco_contribuente&jsondata=
			$jsonarray=json_decode($jsondata);
			
				
			$sql = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_NAME = '".$dump_table_name."'";
			$table_names_result = mysqli_query($server,$sql);
			
			$column_data_dump = array(); 
			for ($x = 0; $x < mysqli_num_rows($table_names_result); $x++) {
				$column_data_dump[] = mysqli_fetch_assoc($table_names_result);
			}
			$column_data_names = array();
			$column_data_type = array(); 			
			$column_names_string="";
			for ($x = 0; $x < count($column_data_dump); $x++) {
				$column_data_names[] = $column_data_dump[$x]['COLUMN_NAME'];
				$column_data_type[] = $column_data_dump[$x]['COLUMN_TYPE'];
			}
			  

			for($i=0;$i< count($jsonarray);$i++)
			{
				$mydata='';
				$column_names_string='';
				for($s=1;$s<count($column_data_names);$s++)
				{
					$val=$jsonarray[$i]->$column_data_names[$s];
					if(strlen($val)==0)
					{
					}
					else if(strcmp($column_data_type[$s],"NULL")==0)
					{
					}
					else
					{
						$column_names_string=$column_data_dump[$s]['COLUMN_NAME'].",".$column_names_string;
						$val="'".$val."'".",";
					}
					//echo(" len:".strlen($val)." ".$val . " ". $column_data_dump[$s]['COLUMN_NAME']."<br>");
					//http://portale.local/dump_table.php?token=prova&method=RCV&table=tco_contribuente&jsondata=[{"idtco_contribuente":"1","idsic_ente":"2","cognome":"zero","nome":"marco","data_nascita":"2016-03-01","data_inizio_attivita":"2016-03-01","data_cessazione_attivita":null,"numero_protocollo_cessazione":null,"data_protocollo_cessazione":null,"idmaps_comune_nascita":null,"comune_nascita":"Ragusa","prov_nascita":"RG","idmaps_nazione":null,"sesso":"M","idmaps_stradario":null,"indirizzo":"via DD","civico":null,"scala":null,"interno":null,"piano":null,"idmaps_comune_residenza":null,"citta":null,"prov":null,"cap":null,"localita":null,"codicefiscale":null,"piva":null,"telefono":null,"cellulare":null,"email":null,"note":null,"idamb_tipo_utente":null,"data_morte":null,"numero_componenti":null,"numero_minori":null,"numero_anziani":null,"numero_eta_altro":null,"numero_fascicolo":null,"flag_famiglia_bloccata":null,"identificazione_ditta":null,"idtco_rappresentante":null,"codice_famiglia":null,"codice_anagrafe":null,"created_at":"2016-03-14 00:00:00","updated_at":"2016-03-14 00:00:00","created_idsic_operatore":null,"updated_idsic_operatore":null,"verifica":"0"}]
					if($s==count($column_data_names)-1) 
					{	
						$column_names_string=substr($column_names_string,0,strlen($column_names_string)-1);
					}
					
					$mydata=$val.$mydata;
					if($s==count($column_data_names)-1) 
					{	
						$mydata=substr($mydata,0,strlen($mydata)-1);
					}
					
				}
				$sql = "INSERT INTO ".$dump_table_name." (".$column_names_string.") VALUES (".$mydata.")";
				//echo $sql;
				$query = mysqli_query($server,$sql);
				
				if ( ! $query ) {
				echo mysqli_error($server);
				die;
				}    
			}
			mysqli_close($server);
			echo "Import successful";
			

		}
		else
		{
			echo "<br>No Method selected";
		}
	}
	else
	{
		echo "Forbidden";
	}

?>