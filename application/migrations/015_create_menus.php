<?php
class Migration_create_menus extends CI_Migration {

	public function up()
	{
		$sql = "DROP TABLE IF EXISTS `tbl_menus`";
		$this->db->query($sql);
		$sql = "CREATE TABLE `tbl_menus` (
			`id` int unsigned NOT NULL AUTO_INCREMENT,
			`parent_id` int unsigned,
			`order` int unsigned,
			`category_id` int unsigned,
			`name` varchar(255) NOT NULL,
			`slug` varchar(100) NOT NULL,
			`status` tinyint DEFAULT 0,
			author int(10),
			modified_by int(10),
			created_at TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),UNIQUE (`name`))";
		$this->db->query($sql);
		$sql = "alter table `tbl_menus` 
				ADD FOREIGN KEY(parent_id)
				REFERENCES tbl_menus(id)";
		$this->db->query($sql);
		$sql = "alter table `tbl_menus` 
				ADD updated_at DATETIME ";
		$this->db->query($sql);
		$sql = "alter table `tbl_menus` 
				ADD FOREIGN KEY(author)
				REFERENCES tbl_users(id)";
		$this->db->query($sql);
		$sql = "alter table `tbl_menus` 
				ADD FOREIGN KEY(modified_by)
				REFERENCES tbl_users(id)";
		$this->db->query($sql);
		echo "15";
}

//`article_id` int unsigned,
//`page_type_id` int unsigned,

public function down()
{
	$this->dbforge->drop_table('tbl_menus');
}
}