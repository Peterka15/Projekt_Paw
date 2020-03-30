<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

require_once _ROOT_PATH.'/lib/smarty/Smarty.class.php';


function getParams(&$x,&$operation){
	$x = isset($_REQUEST['x']) ? $_REQUEST['x'] : null;
	$operation = isset($_REQUEST['op']) ? $_REQUEST['op'] : null;	
}


// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
function validate(&$x,&$operation,&$messages){
	if ( ! (isset($x) && isset($operation))) {
		return false;
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $x == "") {
	$messages [] = 'Nie podano kwoty w PLN';
}

//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {
	
	// sprawdzenie, czy $x jest liczbą całkowitą
	if (! is_numeric( $x )) {
		$messages [] = 'Pierwsza wartość nie jest liczbą całkowitą';
	}
		
	if (count ( $messages ) != 0) return false;
	else return true;
}

}

// 3. wykonaj zadanie jeśli wszystko w porządku

function process(&$x,&$operation,&$messages,&$result){
	global $role;
	
	//konwersja parametrów na int
	$x = intval($x);
	
	
	//wykonanie operacji
	switch ($operation) {
		case "EUR" :
			if ($role == 'admin'){
			$result = $x / 4.30;
		} else {
			$messages [] = 'Tylko administrator może liczyć EUR';
		}
			break;
		case "USD" :
			$result = $x / 3.82 ;
			break;
		case "GPB" :
			$result = $x / 4.97 ;
			break;
		case "CHF" :
			$result = $x / 4.06;
			break;
	}
}


$x = null;
$operation = null;
$result = null;
$messages = array();


getParams($x,$operation);
if ( validate($x,$operation,$messages) ) { // gdy brak błędów
	process($x,$operation,$messages,$result);
}


// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$x,$y,$operation,$result)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';

$smarty = new Smarty();

$smarty->assign('app_url',_APP_URL);
$smarty->assign('root_path',_ROOT_PATH);
$smarty->assign('page_title','Przykład 04');
$smarty->assign('page_description','Profesjonalne szablonowanie oparte na bibliotece Smarty');
$smarty->assign('page_header','Szablony Smarty');



//pozostałe zmienne niekoniecznie muszą istnieć, dlatego sprawdzamy aby nie otrzymać ostrzeżenia
$smarty->assign('x',$x);
$smarty->assign('result',$result);
$smarty->assign('messages',$messages);


// 5. Wywołanie szablonu
$smarty->display(_ROOT_PATH.'/app/calc.html');