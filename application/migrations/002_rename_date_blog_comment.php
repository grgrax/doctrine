<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Rename_date_blog_comment extends CI_Migration {

	public function up() {
		$this->dbforge->drop_column('tbl_blogs_comments', 'date');
	}

	public function down() {
		
	}

}

/* End of file 002_rename_date_blog_comment */
/* Location: ./application/migrations/002_rename_date_blog_comment.php */