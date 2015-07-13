<?php
class Migration_create_page_types extends CI_Migration {

	public function up()
	{
		$sql = "DROP TABLE IF EXISTS `tbl_page_types`";
		$this->db->query($sql);
		$sql = "CREATE TABLE `tbl_page_types` (
			`id` int unsigned NOT NULL AUTO_INCREMENT,
			`name` varchar(255) NOT NULL,
			`desc` varchar(255) DEFAULT NULL,
			PRIMARY KEY (`id`))";
		$this->db->query($sql);
		$sql = "insert into  `tbl_page_types` 
				(`name`) 
					values
				('simple page'),
				('blog page'),
				('gallery page'),
				('video page'),
				('gallery_video page'),
				('contact page'),
				('timeline page')
				";
		$this->db->query($sql);
		echo "16";
	}


	public function down()
	{
		$this->dbforge->drop_table('tbl_page_types');
	}
}