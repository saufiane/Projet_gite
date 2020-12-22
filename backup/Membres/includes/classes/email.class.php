<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

/*****************************************************************
*    Advanced Membership System                                  *
*    Copyright (c) 2012 MasDyn Studio, All Rights Reserved.      *
*****************************************************************/

$stylesheet = "
	<style type='text/css'>
		body {background: #f2f2f2}
		.email_container {width: 700px; margin: 20px auto 0; background: rgba(0, 0, 0, 0);}
		.email_content {width: 100%; border: #ddd 1px solid; padding: 5px 15px 5px; background: #fff}
		.logo {padding-top:6px}
	</style>
";

$header = "
	<body>
	<div class='email_container'>
		<div class='email_content'>
			<img src='".IMAGES."logo.jpg' class='logo' />
			<p />
";

$footer = "";

class Email{

	protected static $table_name="email_templates";
	protected static $db_fields = array('id', 'name', 'description', 'content', 'status', 'permanent','allowed_shortcodes');
		
	public $id;
	public $name;
	public $description;
	public $content;
	public $status;
	public $permanent;
	public $allowed_shortcodes;
	
	public function send_email($to, $from, $subject, $message) {
 		$headers = 'From: '.$from."\r\n".
		"Content-Type: text/html; charset=ISO-8859-1\r\n" .
		'X-Mailer: PHP/' . phpversion();
		mail($to, $subject, $message, $headers);
	}
	
	public static function email_template_data($id){
		global $stylesheet;
		global $header;
		global $footer;

		$data = self::find_by_id($id);
		$data->template_content = $stylesheet.$header.email_shortcodes($data->content).$footer;

		return $data;
	}

	public static function update_template($id,$name,$description,$content,$status){
		global $database;
		global $session;
		if($database->query("UPDATE email_templates SET name = '{$name}', description = '{$description}', content = '{$content}', status = '{$status}' WHERE id = '{$id}' ")){
			$session->message("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Template ($name) has been updated.</div>");
		} else {
			$session->message("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>Sorry, something has gone wrong. Please try again.</div>");
		}
		redirect_to(WWW.ADMINDIR."template_settings.php?id=".$id);
	}

	// Common Database Methods

	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
  	}
  	
	public static function count_by_sql($sql) {
	  global $database;
	  // $sql = "SELECT COUNT(*) FROM user_levels";
     $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}

  	public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id = '{$id}' LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
    }

  	public static function find_by_sql($sql="") {
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
    }

	public static function count_all() {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name;
    $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}

	private static function instantiate($record) {
		// Could check that $record exists and is an array
    	$object = new self;
		
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 
		// return an array of attribute names and their values
	  $attributes = array();
	  foreach(self::$db_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
	
	protected function sanitized_attributes() {
	  global $database;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $database->escape_value($value);
	  }
	  return $clean_attributes;
	}

} // Class end.