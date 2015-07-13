<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Dat extends CI_Migration {

	protected $fields='';
	public function __construct()
	{
		$this->fields = (array(
			'created_date' => array(
				'type' => 'DATETIME',
				),
			'updated_date' => array(
				'type' => 'DATETIME',
				),
			));	
	}

	public function up() {
		echo "inside ".__function__." of class:".get_class()."<br/>";
		$this->dbforge->add_column('tbl_users', $this->fields);
		$this->dbforge->add_column('tbl_testimonials', $this->fields);
		$this->dbforge->add_column('tbl_news', $this->fields);
		$this->dbforge->add_column('tbl_events', $this->fields);
		$this->dbforge->add_column('tbl_blogs_comments', $this->fields);
		$this->dbforge->add_column('tbl_blogs', $this->fields);
		$this->dbforge->drop_column('tbl_blogs_comments', $this->fields);
	}

	public function down() {
		$this->dbforge->drop_column('tbl_testimonials', $this->fields);
		$this->dbforge->drop_column('tbl_news', $this->fields);
		$this->dbforge->drop_column('tbl_events', $this->fields);
		$this->dbforge->drop_column('tbl_blogs_comments', $this->fields);
		$this->dbforge->drop_column('tbl_blogs', $this->fields);
	}

}

/* End of file 001_add_created_and_modied_dates.php */
/* Location: ./application/001_add_created_and_modied_dates.php */