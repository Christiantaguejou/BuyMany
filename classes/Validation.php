<?php

class Validation{

	private $data;
	private $errors = [];

	public function __construct($data){
		$this->data = $data;
	}

	private function getField($field){
		if(!isset($this->data[$field])){
			return null;
		}
		return $this->data[$field];
	}

	public function isAlphanumeriq($field, $errorMsg){
		if(!preg_match('/^[a-zA-Z0-9_]+$/', $this->getField($field))){
			$this->errors[$field] = $errorMsg;
		}
	}

	public function isAlpha($field, $errorMsg){
		if(!preg_match('/^[a-zA-Z]+$/', $this->getField($field))){
			$this->errors[$field] = $errorMsg;
		}
	}


	public function isPseudoUniq($field, $db, $table, $errorMsg){
		$record = $db->query("SELECT id FROM $table WHERE pseudo = ?",[$this->getField($field)])->fetch();
		if($record){
			$this->errors[$field]= $errorMsg;
		}
	}

	public function isEmail($field, $errorMsg){
		if(!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)){
			$this->errors[$field]= $errorMsg;
		}
	}

	public function isEmailUniq($field, $db, $table, $errorMsg){
		$record = $db->query("SELECT id FROM $table WHERE email = ?",[$this->getField($field)])->fetch();
		if($record){
			$this->errors[$field]= $errorMsg;
		}
	}

	public function isConfirmed($field, $errorMsg){
		$value = $this->getField($field);
		if(empty($value) || $this->getField($field) != $this->getField($field.'Confirm')){
			$this->errors['field']= $errorMsg;
		}
	}

	public function isLoginValid( $db, $field, $errorMsg){
		$valid = $db->query("SELECT * FROM users WHERE (pseudo = ? OR email = ?) AND confirm_at IS NOT NULL", [$this->getField($field),$this->getField($field) ])->fetch();
		if(!$valid){
			$this->errors[$field]= $errorMsg;
		}
	}

	public function isValid(){
		return empty($this->errors);
	}

	public function getErrors(){
		return $this->errors;
	}
}