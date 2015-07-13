<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_user extends CI_Migration {

	public function __construct()
	{
	}

	public function up() {
		echo "inside ".__function__." of class:".get_class()."<br/>";
		$fields = array(
			'status' => array(
				'name' => 'status',
				'type' => 'tinyint',
				),
			);
		$this->dbforge->modify_column('tbl_users', $fields);
		$fields = array(
			'created_date' => array(
				'name' => 'created_at',
				'type' => 'datetime',
				),
			'updated_date' => array(
				'name' => 'updated_at',
				'type' => 'datetime',
				)
			);
		$this->dbforge->modify_column('tbl_users', $fields);
	}

	public function down() {
		
	}

}

/* End of file class_name.php */
/* Location: ./application/migrations/class_name.php */