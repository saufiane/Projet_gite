<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

/*****************************************************************
*    Members System   (Shared on www.easy-for.com)				 *
*	 Multi level Marketing Redistribution by Romain GALVEZ       *
*    Copyright (c) 2016 Easy-For Studio, All Rights Reserved.    *
*****************************************************************/

class Affiliation {

	private $_db;
	private $purchased_by;

    //Connect to DB with PDO object
    public function __construct() {
         $this->_db = new PDO( 'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS, array( PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8 COLLATE utf8_general_ci', PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION ) ); // On crée une instance de la classe PDO qui par défaut nous connecte à la base de données.
    }

	//Get all the percentage of retribution
	//Return an array
	public function get_affi_percentages(){
		$pdo = $this->_db->prepare( 'SELECT * FROM `affi_pourcentage` ORDER BY `level` ASC' );
		$pdo->execute();
		return $pdo->fetchAll( PDO::FETCH_ASSOC );
	}

	//Get sponsor for this user
	//Require User_ID
	//Return sponsor ID
	public function get_sponsor( $user_id ){
		$pdo = $this->_db->prepare( 'SELECT `sponsor_id` FROM `users` WHERE `user_id` = :user_id' );
		$pdo->bindParam( ':user_id', $user_id );     
		$pdo->execute();
		$result = $pdo->fetch( PDO::FETCH_ASSOC );
		return $result['sponsor_id'];
	}
	//Get sponsor photo for this user
	//Require User_ID
	//Return sponsor -> maphoto
	public function get_sponsor_photo( $user_id ){
		$pdo = $this->_db->prepare( 'SELECT `maphoto` FROM `users` WHERE `user_id` = :user_id' );
		$pdo->bindParam( ':user_id', $user_id );     
		$pdo->execute();
		$result = $pdo->fetch( PDO::FETCH_ASSOC );
		return $result['maphoto'];
	}

	//Get username fot this user
	//Require User_ID
	//Return username
	public function get_username( $user_id ){
		$pdo = $this->_db->prepare( 'SELECT `username` FROM `users` WHERE `user_id` = :user_id' );
		$pdo->bindParam( ':user_id', $user_id );
		$pdo->execute();
		$result = $pdo->fetch( PDO::FETCH_ASSOC );
		return $result['username'];
	}

	//Get all sponsors for this user.
	//Require user_id of the referral, $tab_percentages
	//Return an array with sponsor_ID and percentage of retribution for each level
	public function get_all_sponsors( $referral_id, $tab_percentages ){
		$nb_levels = count( $tab_percentages ); //Count of levels of commissions
		$this->purchased_by = $referral_id;
		$tab_sponsors = array(); 

		//Loop to get the sponsors of all levels
		for ($i = 0; $i < $nb_levels; $i++){
			$sponsor_id = $this->get_sponsor( $referral_id );
			$tab_sponsors[] = array( 
									'sponsor_id'   => $sponsor_id, //ID of the person paid on this level
									'level' 	   => $i + 1, //Level
									'percentage'   => $tab_percentages[$i]['pourcent'] //Percentage paid on this level
									);
			$referral_id = $sponsor_id; //We invert referral and sponsor to level up
		}
		return $tab_sponsors;
	}

	//Create new balance for this user.
	//Require user ID
	//Return true or false
	public function create_balance( $user_id, $balance = '0.00' ){
		$pdo = $this->_db->prepare( 'INSERT INTO `affi_balance`(`user_id, `balance`, `date_modif`) VALUES (:user_id, :balance, NOW() )');
		$pdo->bindParam( ':user_id', $user_id );
		$pdo->bindParam( ':balance', $balance );
		return $pdo->execute();
	}

	//Get balance for this user.
	//Require user ID
	//Return an array with balance and last update date.
	public function get_balance( $user_id ){
		$pdo = $this->_db->prepare( 'SELECT * FROM `affi_balance` WHERE `user_id` = :user_id' );
		$pdo->bindParam( ':user_id', $user_id );     
		$pdo->execute();
		$result = $pdo->fetch( PDO::FETCH_ASSOC );
		return $result['balance'];
	}

	public function get_balance_history( $user_id ){
		$pdo = $this->_db->prepare( 'SELECT * FROM `affi_history` WHERE `user_id` = :user_id' );
		$pdo->bindParam( ':user_id', $user_id );     
		$pdo->execute();
		$result = $pdo->fetch( PDO::FETCH_ASSOC );
		return $result['new_balance'];
	}

	//UPDATE balance of all sponsors.
	//Require amount of purchased pack, and sponsors array.
	//Return true or false.
	public function update_sponsors_balance( $purchased_amount, $tab_sponsors ){
		$difference = $purchased_amount;
		foreach ($tab_sponsors as $key => $value) {
			//If sponsor is found, AND we haven't share more than
			if( $value['sponsor_id'] != null){				
				$user_id = $value['sponsor_id'];
				$commission = $purchased_amount * $value['percentage'] / 100;
				//We never share the last 100€ on the purchased amount. If commission is too big, we calculate the difference			
				
				$difference -= $commission;
				$old_balance = $this->get_balance( $user_id );
				$new_balance = $old_balance + $commission;

				if( $old_balance == null ){ //Create balance if doesn't exist
					$this->create_balance( $user_id );
					$old_balance = '0.00';
				}

				//update balance
				$pdo = $this->_db->prepare( 'UPDATE `affi_balance` SET `balance` = :new_balance, `date_modif` = NOW() WHERE `user_id`=:user_id' );
				$pdo->bindParam( ':user_id', $user_id );
				$pdo->bindParam( ':new_balance', $new_balance );
				$pdo->execute();

				//Add affi balance history
				$purchased_by = $this->get_username( $this->purchased_by );
				$descr = 'Pack '.$purchased_amount.'€ purchased by '.$purchased_by;
				$this->add_affi_history( $user_id, $commission, $old_balance, $new_balance, 'Referral commission', $descr );
			}			
		}
	}


	//ADD new transaction to affi_history table
	//Require user ID, old solde, new solde, type of transaction, description
	//Return true of false.
	public function add_affi_history( $user_id, $commission, $old, $new, $type, $descr ){
		$pdo = $this->_db->prepare('INSERT INTO `affi_history` (`user_id`, `commission`, `old_balance`, `new_balance`, `type`, `descr`, `date` )
									VALUES ( :user_id, :commission, :old_balance, :new_balance, :type, :descr, NOW() )' );
		$pdo->bindParam( ':user_id', $user_id );
		$pdo->bindParam( ':commission', $commission );
		$pdo->bindParam( ':old_balance', $old );
		$pdo->bindParam( ':new_balance', $new );
		$pdo->bindParam( ':type', $type );
		$pdo->bindParam( ':descr', $descr );
		return $pdo->execute();
	}

	public function affi_treatment( $user_id, $purchase_price ){
		$tab_percentages = $this->get_affi_percentages();
		$tab_sponsors = $this->get_all_sponsors( $user_id, $tab_percentages );
		$this->update_sponsors_balance( $purchase_price, $tab_sponsors );
	}
}