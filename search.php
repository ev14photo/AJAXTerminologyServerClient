<?php
/*#Llamamos a la libreria de funciones principal
require ("../libs/libs.lib.php");
#Cargamos el archivo de configuracion y lo parseamos a la variable config
$file = "../configs/.config.xml";
$config = getxmldata ($file);

$casena = $_GET['text'];
$link = connectdb();

$query = "SELECT NAME AS label, orcid as id FROM tblusers WHERE NAME LIKE \"%".$_POST['term']."%\" AND LENGTH(orcid) > 0";

$sth = mysqli_query($link,$query);
$rows = array();
while($r = mysqli_fetch_assoc($sth)) {
    $rows[] = $r;
}

*/





				if (strlen($_POST['server'])>0) {
					$termserverurl = $_POST['server'];
				}
				else {
					$error[]="no server";
				}

				if (strlen($_POST['operation'])>0) {
					$termservermethod = $_POST['operation'];
				}
				else {
					$error[]="no method";
				}
				if (strlen($_POST['branch'])>0) {
					$branch  = $_POST['branch'];
				}
				else {$branch  = "MAIN";}

				$urlconsulta = $termserverurl.'/'.$branch.'/'.$termservermethod.'?';


				if (strlen($_POST['activefilter'])>0) {
					$parms['activefilter']  = $_POST['activefilter'];
					//only active concepts
				}
				if (strlen($_POST['semantictag'])>0) {
					$parms['semanticTag']  = $_POST['semantictag'];
					//semantic tag (category....)
				}
				if (strlen($_POST['groupbyconcept'])>0) {
					$parms['groupByConcept'] = $_POST['groupbyconcept'];
					//group by concept (only one result if multiple descriptions points to same code)
				}
				if (strlen($_POST['offset'])>0) {
					$parms['offset'] = $_POST['offset'];
					//offset en los resultados
				}
				if (strlen($_POST['definitionstatusfilter'])>0) {
					$parms['definitionstatusfilter'] = $_POST['definitionstatusfilter'];
				}

				if (strlen($_POST['termactive'])>0) {
					$parms['termactive'] = $_POST['termactive'];
					//solo termibnos activos
				}
				if (strlen($_POST['language'])>0) {
					$parms['language'] = $_POST['language'];
					//lan
				}
				if (strlen($_POST['preferredin'])>0) {
					$parms['preferredin'] = $_POST['preferredin'];
				}
				if (strlen($_POST['acceptablein'])>0) {
					$parms['acceptablein'] = $_POST['acceptablein'];
				}
				if (strlen($_POST['preferredoracceptablein'])>0) {
					$parms['preferredoracceptablein'] = $_POST['preferredoracceptablein'];
				}
				if (strlen($_POST['statedecl'])>0) {
					$parms['statedecl'] = $_POST['statedecl'];
				}
				if (strlen($_POST['conceptids'])>0) {
					$parms['conceptids'] = $_POST['conceptids'];
				}
				if (strlen($_POST['searchmode'])>0) {
					$parms['searchmode'] = $_POST['searchmode'];
				}
				if (strlen($_POST['searchafter'])>0) {
					$parms['searchafter'] = $_POST['searchafter'];
				}
				if (strlen($_POST['accept-language'])>0) {
					$parms['accept-language'] = $_POST['accept-language'];
				}
				if (strlen($_POST['includedescendantcount'])>0) {
					$parms['includedescendantcount'] = $_POST['includedescendantcount'];
				}
				if (strlen($_POST['form'])>0) {
					$parms['form'] = $_POST['form'];
				}
				if ($_POST['limit']>0) {
					$parms['limit'] = $_POST['limit'];
					$result_limit = $_POST['limit'];

					//limite de resultados
				}
				if (strlen($_POST['ecl'])>0) {
					$parms['ecl'] = $_POST['ecl'];

				}
				
	


				//TODO: Aqui hay que construir un arbol de decisiones de algun modo para solo poder lanzar consultas coherentes.
				
				//Text to search for cames from RedCAP as $search_term ,  rawurlencode to pass via URL
				if (strlen($_POST['term'])>2) {
					$search_term_encoded = rawurlencode($_POST['term']);
					$parms['term'] = $search_term_encoded;
					$rawValues = file_get_contents($urlconsulta.http_build_query($parms), false, stream_context_create($arrContextOptions));
					
					if ($_POST['save_logs'] == "true") {
						error_log($urlconsulta.http_build_query($parms));
					}


					$list = json_decode($rawValues, true);
				   
						foreach ($list['items'] as $item) {
							//first, check if a code is returned
							$code1 = get($_POST['codes_sub_path'],$item);
							$code2 = get($_POST['descriptions_sub_path'],$item);

							//If i have a code (description, active or not and synonim must be set)
							if (isset($code1) || isset($code2)) {
								if (strlen($_POST['codes_sub_path']) > 0 && strlen($_POST['descriptions_sub_path']) > 0 ) {
									$values[] = ['id' => get($_POST['codes_sub_path'],$item), 'label' => get($_POST['descriptions_sub_path'],$item), 'active' => $item['active'], 'synonyms' => $item['pt']['term']];
								}
								else {
									$values[] = ['id' => get('concept.conceptId',$item), 'label' => get('concept.fsn.term',$item), 'active' => $item['active'], 'synonyms' => $item['pt']['term']];
								}
							}
						}
					echo json_encode($values);



				}
				else {
					$error[]="sin cadena de búsqueda";
					exit;
				}
				
				
				//Finally, URL, branch , method and action tangs compose a  call to terminology server, an it will return a JSON string


				//error_log($urlconsulta.http_build_query($parms));














    function get($path, $array)
    {
        //$array = $this->values;

        if (!empty($path)) {
            $keys = explode('.', $path);
            foreach ($keys as $key) {
                if (isset($array[$key])) {
                    $array = $array[$key];
                } else {
                    return $default;
                }
            }
        }

        return $array;
    }

?>