<?php
    require 'model/itemsModel.php';
    require 'model/items.php';
    require_once 'config.php';

    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
    
	class sportsController 
	{

 		function __construct() 
		{
			$this->objconfig = new config();
			$this->objsm =  new itemsModel($this->objconfig);
		}
        // mvc handler request
		public function mvcHandler() 
		{
			$act = isset($_GET['act']) ? $_GET['act'] : NULL;
			switch ($act) 
			{
                case 'add' :                    
					$this->insert();
					break;						
				case 'update':
					$this->update();
					break;				
				case 'delete' :					
					$this -> delete();
					break;								
				default:
                    $this->lists();
			}
		}		
        // page redirection
		public function pageRedirect($url)
		{
			header('Location:'.$url);
		}	
        // check validation
		public function checkValidation($itemtb)
        {
            $noerror=true;
            // Validate category        
            if(empty($itemtb->amount)){
                $itemtb->amount_msg = "Field is empty.";$noerror=false;
            } elseif(!is_numeric($itemtb->amount)){
                $itemtb->amount_msg = "Field must be number.";$noerror=false;
            }else{$itemtb->amount_msg ="";}
            // Validate name            
            if(empty($itemtb->buyer)){
                $itemtb->buyer_msg = "Field is empty.";$noerror=false;
            } elseif(strlen($itemtb->buyer) > 20){
                $itemtb->buyer_msg = "Field Length Must Be 20 Characters.";$noerror=false;
            }else{
                $itemtb->buyer_msg ="";
            }
            if(empty($itemtb->receipt_id)){
                $itemtb->receipt_id_msg = "Field is empty.";$noerror=false;
            } else{
                $itemtb->receipt_id_msg ="";
            }
            foreach (json_decode($itemtb->items) as $items){
                if(($items) == ''){
                    $itemtb->items_msg = "Field is empty.";$noerror=false;
                }
            }
            if(empty($itemtb->buyer_email)){
                $itemtb->buyer_email_msg = "Field is empty.";$noerror=false;
            } else if(!filter_var($itemtb->buyer_email, FILTER_VALIDATE_EMAIL)) {
                $itemtb->buyer_email_msg = "Invalid email format.";$noerror=false;
            } else{
                $itemtb->buyer_email_msg ="";
            }
            if(empty($itemtb->note)){
                $itemtb->note_msg = "Field is empty.";$noerror=false;
            } else if(str_word_count($itemtb->note) > 30) {
                $itemtb->note_msg = "Field Length Must Be 30 Words.";$noerror=false;
            } else{
                $itemtb->note_msg ="";
            }
            if(empty($itemtb->city)){
                $itemtb->city_msg = "Field is empty.";$noerror=false;
            } else{
                $itemtb->city_msg ="";
            }
            if(empty($itemtb->phone)){
                $itemtb->phone_msg = "Field is empty.";$noerror=false;
            } else{
                $itemtb->phone_msg ="";
            }
            if(empty($itemtb->entry_by)){
                $itemtb->entry_by_msg = "Field is empty.";$noerror=false;
            }else if(!is_numeric($itemtb->entry_by)){
                $itemtb->entry_by_msg = "Field must be number.";$noerror=false;
            } else{
                $itemtb->entry_by_msg ="";
            }
            return $noerror;
        }

        function get_client_ip() {
            $localIP = getHostByName(getHostName());
            return $localIP;
        }
        // add new record
		public function insert()
		{
            try{
                $buyer_ip = $this->get_client_ip();
                $itemtb=new items();
                if ($_POST) {
                    $cookieName = 'submission_time';
                    $cokkieValue = time();

                    setcookie($cookieName, $cokkieValue, time() + (+60 * 60 * 24 ), "/");
                    if (isset($_COOKIE['submission_time'])) {

                        $submissionTime = $_COOKIE['submission_time'];
                        $currentTime = time();
                        $timePassed = ($currentTime - $submissionTime)  ;
                        echo "<pre>";print_r([$currentTime,$submissionTime,$timePassed]);exit();

                        if ($timePassed < 86400) {
                            echo "You can from submit after 24 hours! Please wait...";
                            die();
                        }

                    } else {
                        // read form value
                        $itemtb->amount = trim($_POST['amount']);
                        $itemtb->buyer = trim($_POST['buyer']);
                        $itemtb->receipt_id = trim($_POST['receipt_id']);
                        $itemtb->items = json_encode($_POST['item_name']);
                        $itemtb->buyer_email = trim($_POST['buyeremail']);
                        $itemtb->note = trim($_POST['note']);
                        $itemtb->city = trim($_POST['city']);
                        $itemtb->phone = trim($_POST['phone']);
                        $itemtb->entry_by = trim($_POST['entry_by']);
                        $itemtb->entry_at = trim($_POST['entry_at']);
                        //call validation
                        $chk = $this->checkValidation($itemtb);
                        if ($chk) {
                            //call insert record
                            $itemtb->buyer_ip = $buyer_ip;
                            $itemtb->hash_key = hash("sha512", $itemtb->receipt_id);
                            $pid = $this->objsm->insertRecord($itemtb);
                            if ($pid > 0) {
                                //$this->lists();
                                $res = 'success';
                                echo($res);
                                exit;
                            } else {
                                echo "Somthing is wrong..., try again.";
                                $res = 'error';
                                echo($res);
                                exit;
                            }
                        } else {   //echo "<pre>";print_r(($itemtb));exit();
                            $_SESSION['sporttbl0'] = serialize($itemtb);//add session obj
                            $this->pageRedirect("view/insert.php");
                        }
                    }
                }
            }catch (Exception $e) 
            {
                $this->close_db();	
                throw $e;
            }
        }
        // update record
        public function update()
		{

        }
        // delete record
        public function delete()
		{

        }
        public function lists(){
 		    $cond = array();
            $_SESSION = array();
 		    if(isset($_GET['date_from']) && $_GET['date_from']){
                $_SESSION['date_from'] = $_GET['date_from'];
                $cond['date_from'] = $_GET['date_from'];
            }
            if(isset($_GET['date_to']) && $_GET['date_to']){
                $_SESSION['date_to'] = $_GET['date_to'];
                $cond['date_to'] = $_GET['date_to'];
            }
            if(isset($_GET['id']) && $_GET['id']){
                $_SESSION['id'] = $_GET['id'];
                $cond['id'] = $_GET['id'];
            }
            $result=$this->objsm->selectRecord($cond);
            include "view/list.php";
        }
    }
		
	
?>