<?php
//model
class Movies {
	private $_data;
	private $_db;
	
	public function __construct() {
		$this->_db = DB::getInstance();
	}
	
	public function find($movie = null) {
		if($movie) {
			//is_numeric — Finds whether a variable is a number or a numeric string
			// Returns TRUE if var is a number or a numeric string, FALSE otherwise. bleee
			$field = (is_numeric($movie)) ? 'id' : 'title';
			$data = $this->_db->get('movie', array($field, '=', $movie));

			if($data->count()) {
				$this->_data = $data->first();
				//_results to tablica - ogólnie aleee
				//first wyswietlac elementy tablicy uwzgledniajac to, ze to tablica głowa mała...
				return true;
			}
		}
		return false;
	}
	
	public function data() {
		return $this->_data;
	}
	
	//http://www.w3schools.com/sql/sql_distinct.asp
	//SELECT DISTINCT column_name,column_name FROM table_name;
	
	public function getgenres() {
		$genre = $this->_db->getdistinct('movie', 'genre');
		return $genre;
	}
}
