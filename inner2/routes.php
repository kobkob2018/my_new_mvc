<?php
  function call($controller, $action) {
	
    
	$controller_class = ucfirst($controller)."Controller";
	
	$controller = new $controller_class();
    $controller->print_layout($action);

    //$controller->{ $action }();
  }
  
  function print_view($controller,$action){
		
		// we're adding an entry for the new controller and its actions
		if(file_exists('controllers/' . $controller . '_controller.php')){
			require_once('controllers/' . $controller . '_controller.php');
			if(method_exists(ucfirst($controller)."Controller",$action)){
				call($controller, $action);
			}
			else{
				print_view('pages', 'error');
			}
		}
		else{
			print_view('pages', 'error');
		}
	}


	if (isset($_GET['controller']) && isset($_GET['action'])) {
		$controller = $_GET['controller'];
		$action     = $_GET['action'];
	} else {
		$controller = 'pages';
		$action     = 'home';
	}
	
	print_view($controller,$action);

?>