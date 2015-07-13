<?php
class Migration_create_groups extends CI_Migration {

	public function up()
	{
		$sql = "DROP TABLE IF EXISTS `tbl_groups`";
		$this->db->query($sql);
		$sql = "CREATE TABLE `tbl_groups` (
			`id` int unsigned NOT NULL AUTO_INCREMENT,
			`parent_group_id` int unsigned,
			`name` varchar(255) NOT NULL,
			`slug` varchar(100) NOT NULL,
			`desc` varchar(255) DEFAULT NULL,
			`status` tinyint DEFAULT 0,
			created_at TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),UNIQUE (`name`))";
		$this->db->query($sql);
		$sql = "alter table `tbl_groups` 
				ADD FOREIGN KEY(parent_group_id)
				REFERENCES tbl_groups(id)";
		$this->db->query($sql);
		$sql = "alter table `tbl_groups` 
				ADD updated_at DATETIME ";
		$this->db->query($sql);
		echo "4";
}

public function down()
{
	$this->dbforge->drop_table('tbl_groups');
}
}