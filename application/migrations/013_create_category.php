<?php
class Migration_create_category extends CI_Migration {

	public function up()
	{
		$sql = "DROP TABLE IF EXISTS `tbl_categories`";
		$this->db->query($sql);
		$sql = "CREATE TABLE `tbl_categories` (
			`id` int unsigned NOT NULL AUTO_INCREMENT,
			`parent_id` int unsigned,
			`title` varchar(255) NOT NULL,
			`slug` varchar(25) NOT NULL,
			`dsc` varchar(2000),
			`image` varchar(50),
			`image_title` varchar(50),
			`url` varchar(100) NOT NULL,
			`order` int unsigned,
			`published` tinyint unsigned,
			created_at TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
			author int(10),
			modified_by int(10),
			PRIMARY KEY (`id`),UNIQUE (`title`))";
		$this->db->query($sql);
		$sql = "alter table `tbl_categories` 
				ADD FOREIGN KEY(parent_id)
				REFERENCES tbl_categories(id)";
		$this->db->query($sql);
		$sql = "alter table `tbl_categories` 
				ADD FOREIGN KEY(author)
				REFERENCES tbl_users(id)";
		$this->db->query($sql);
		$sql = "alter table `tbl_categories` 
				ADD FOREIGN KEY(modified_by)
				REFERENCES tbl_users(id)";
		$this->db->query($sql);
		$sql = "alter table `tbl_categories` 
				ADD updated_at DATETIME ";
		$this->db->query($sql);
		echo "13";
}

public function down()
{
	$this->dbforge->drop_table('tbl_categories');
}
}