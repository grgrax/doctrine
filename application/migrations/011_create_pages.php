<?php
class Migration_create_pages extends CI_Migration {

	public function up()
	{
		$sql = "DROP TABLE IF EXISTS `tbl_pages`";
		$this->db->query($sql);
		$sql = "CREATE TABLE `tbl_pages` (
			`id` int unsigned NOT NULL AUTO_INCREMENT,
			`parent_page_id` int unsigned,
			`menu_level` int unsigned,
			`type` int unsigned,
			`name` varchar(255) NOT NULL,
			`slug` varchar(100) NOT NULL,
			`content` varchar(255) DEFAULT NULL,
			`status` tinyint DEFAULT 0,
			created_at TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),UNIQUE (`name`))";
		$this->db->query($sql);
		$sql = "alter table `tbl_pages` 
				ADD FOREIGN KEY(parent_page_id)
				REFERENCES tbl_pages(id)";
		$this->db->query($sql);
		$sql = "alter table `tbl_pages` 
				ADD updated_at DATETIME ";
		$this->db->query($sql);
		echo "11";
}

public function down()
{
	$this->dbforge->drop_table('tbl_pages');
}
}