<?php 

	require_once('dbconfig.php');
	require_once('functions.php');
	

	$table   = 'add_product';
	$arr     = [];

	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete') {
		
		$id      = $_REQUEST['id'];
		$byArray = array('id'=> $id);  
		echo delete($table,$byArray);
	}

	elseif(isset($_POST['action']) && $_POST['action'] == 'insert'){

		$product_name  =  $_POST['data'][0]['value'];
		$product_price =  $_POST['data'][1]['value'];
		$discount 	   =  $_POST['data'][2]['value'];
		$expiry_date   =  strtotime($_POST['data'][3]['value']);

		$data  = array('name'=>$product_name,'price'=>$product_price,'discount'=>$discount,'expiry_date'=>$expiry_date);

		echo insert($table,$data,true);
	}
	elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'select' ) {

		
		$id      = $_REQUEST['id'];
		$byArray = array('id'=> $id);  
		$data    = get($table,$byArray);
		foreach ($data as $key => $value) {
			
			$arr['id'] 			= $value['id'];
			$arr['name'] 		= $value['name'];
			$arr['price'] 		= $value['price'];
			$arr['discount']    = $value['discount'];
			$arr['expiry_date'] = date('d-m-Y',$value['expiry_date']);

		}
		 print_r(json_encode($arr));
		die();
	}
	elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'update'  ) {

		$id          = $_REQUEST['id'];
		$mac         = $_REQUEST['esl_mac'];
		$valuesArray = array('esl_mac' => $mac);
		$byArray     = array('id'=> $id);  
		$data        = array('esl_mac'=>$mac);
        $STH 	     = $conn->prepare("SELECT count(*) FROM add_product where esl_mac = '".$mac."' "); 
        $result  	 = $STH->execute();
        $count   	 = $STH->fetchColumn();
        if($count == 0){
			update($table, $valuesArray,$byArray);
			$dataa   = get($table,$byArray);
			foreach ($dataa as $key => $value) {
				
				$arr['id'] 			= $value['id'];
				$arr['name'] 		= $value['name'];
				$arr['price'] 		= $value['price'];
				$arr['discount']    = $value['discount'];
				$arr['expiry_date'] = date('d-m-Y',$value['expiry_date']);

			}
			 print_r(json_encode($arr));
			die();
        }
        else{
			$row  = sql($conn, "UPDATE add_product set esl_mac = ? where esl_mac = ?", array('',$mac),"rows");
			$rows = sql($conn, "UPDATE add_product set esl_mac = ? where id = ?", array($mac,$id),"rows");

			$dataa   = get($table,$byArray);
			foreach ($dataa as $key => $value) {
				
				$arr['id'] 			= $value['id'];
				$arr['name'] 		= $value['name'];
				$arr['price'] 		= $value['price'];
				$arr['discount']     = $value['discount'];
				$arr['expiry_date']  = date('d-m-Y',$value['expiry_date']);

			}
			print_r(json_encode($arr));
			die();
        }	
	}
	// api updating api
	elseif (isset($_REQUEST['api']) && $_REQUEST['api'] == 'update') {

		$mac      = isset($_REQUEST['mac']) ? $_REQUEST['mac'] : '';
		$name     = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
		$price    = isset($_REQUEST['price']) ? $_REQUEST['price'] : '';
		$discount = isset($_REQUEST['discount']) ? $_REQUEST['discount'] : '';
		$expiry   = strtotime(isset($_REQUEST['expiry']) ? $_REQUEST['expiry'] : '');

		if ($mac != "" ) {

			$valuesArray = array('name'=>$name,'price'=>$price,'discount'=>$discount,'expiry_date'=>$expiry);  
			$byArray	 = array('esl_mac'=>$mac);	     

			$result = update($table, $valuesArray,$byArray);
			if ($result) {
				$arr['success']= true;
				$arr['msg']='Successfully updated on this mac address '.$mac;
				print_r(json_encode($arr));
				die();
			}
			else{
				$arr['success']= false;
				$arr['msg'] = 'Something went wrong. Please try again';
				print_r(json_encode($arr));
				die();	
			}
		}
		else{
			$arr['success']= false;
			$arr['msg'] = 'Data not updated successfully';
			print_r(json_encode($arr));
			die();
		}
	}
	// api retrieving data for qrcode
	elseif (isset($_REQUEST['api']) && $_REQUEST['api'] == 'retrieve_mac') {

		$mac = isset($_REQUEST['mac']) ? $_REQUEST['mac'] : '';
		if ($mac != '') {
			$byArray = array('esl_mac'=> $mac);  
			$data    = get($table,$byArray);
			if ($data != '') {
				foreach ($data as $key => $value) {
					
					$arr['id'] 			= $value['id'];
					$arr['name'] 		= $value['name'];
					$arr['price'] 		= $value['price'];
					$arr['discount']    = $value['discount'];
					$arr['expiry']      = date('d-m-Y',$value['expiry_date']);

				}
				print_r(json_encode($arr));
				die();
			}
			else{
				$arr['success'] = false;
				$arr['msg']     = 'MAC Address not found';
				print_r(json_encode($arr));
				die();
			}
		}
		else{
			$arr['success'] = false;
			$arr['msg']     = 'Data not found';
			print_r(json_encode($arr));
			die();
		}
	}
	// api retrieving data for barcode
	elseif (isset($_REQUEST['api']) && $_REQUEST['api'] == 'retrieve_id') {

		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
		if ($id != '') {
			$byArray = array('id'=> $id);  
			$data    = get($table,$byArray);
			if ($data != '') {
				foreach ($data as $key => $value) {
					
					$arr['id'] 			= $value['id'];
					$arr['name'] 		= $value['name'];
					$arr['price'] 		= $value['price'];
					$arr['discount']    = $value['discount'];
					$arr['expiry']      = date('d-m-Y',$value['expiry_date']);

				}
				print_r(json_encode($arr));
				die();
			}
			else{
				$arr['success'] = false;
				$arr['msg']     = 'Product not found';
				print_r(json_encode($arr));
				die();
			}
		}
		else{
			$arr['success'] = false;
			$arr['msg']     = 'Data not found';
			print_r(json_encode($arr));
			die();
		}
	}
	// api for inserting purpose. 
	elseif (isset($_REQUEST['api']) && $_REQUEST['api'] == 'insert') {
	
		$product_name  =  $_REQUEST['name'];
		$product_price =  $_REQUEST['price'];
		$discount 	   =  $_REQUEST['discount'];
		$expiry_date   =  strtotime($_REQUEST['expiry']);

		$data  = array('name'=>$product_name,'price'=>$product_price,'discount'=>$discount,'expiry_date'=>$expiry_date);
		$val = insert($table,$data,true);
		if ($val) {
			$arr['success'] = true;
			$arr['msg']     = 'Successfully inserted';
			print_r(json_encode($arr));
			die();
		}
		else{
			$arr['success'] = false;
			$arr['msg']     = 'Data is not inserted';
			print_r(json_encode($arr));
			die();
		}
	}
	// assign mac address to id.
	elseif (isset($_REQUEST['api']) && $_REQUEST['api'] == 'assign') {
		
		$id  = $_REQUEST['id'];
		$mac = $_REQUEST['mac'];

		if ($id != '' && $mac != '') {

			$STH 	     = $conn->prepare("SELECT count(*) FROM add_product where id = '".$id."' "); 
	        $result  	 = $STH->execute();
	        $count   	 = $STH->fetchColumn();
	        if ($count == 1) {

				$rows  = sql($conn, "UPDATE add_product set esl_mac = ? where esl_mac = ?", array('',$mac),"rows"); 

				$row  = sql($conn, "UPDATE add_product set esl_mac = ? where id = ?", array($mac,$id),"rows");  		

				$arr['success'] = true;
				$arr['msg']     = 'Successfully assign MAC address';
				print_r(json_encode($arr));
				die();	
	        }else{
	        	$arr['success'] = false;
				$arr['msg']     = 'Product does not exist';
				print_r(json_encode($arr));
				die();	
	        }

		}
		else{
			$arr['success'] = false;
			$arr['msg']     = 'Id or MAC address is missing';
			print_r(json_encode($arr));
			die();
		}  
	}
	// remove mac address from id.
	elseif (isset($_REQUEST['api']) && $_REQUEST['api'] == 'unassign'){

		$id  = $_REQUEST['id'];
		$mac = $_REQUEST['mac'];

		if ($id != '' && $mac != '') {

			$STH 	     = $conn->prepare("SELECT count(*) FROM add_product where id = '".$id."' "); 
	        $result  	 = $STH->execute();
	        $count   	 = $STH->fetchColumn();
	        if ($count == 1) {
				$rows  = sql($conn, "UPDATE add_product set esl_mac = ? where id = ?", array('',$id),"rows"); 

				$arr['success'] = true;
				$arr['msg']     = 'Successfully unassign MAC address';
				print_r(json_encode($arr));
				die();	
	        }else{
	        	$arr['success'] = false;
				$arr['msg']     = 'Product does not exist';
				print_r(json_encode($arr));
				die();	
	        }

		}
		else{
			$arr['success'] = false;
			$arr['msg']     = 'Id or MAC address is missing';
			print_r(json_encode($arr));
			die();
		}
	}
	else{
		$arr['success']= false;
		$arr['msg'] = 'Something is missing';
		print_r(json_encode($arr));
		die();
	}

	
 ?>

