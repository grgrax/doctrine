<?php

class Migration_group_permission extends CI_Migration 
{
	public function up()
	{
		$sql = "DROP TABLE IF EXISTS `tbl_group_permissions`";
		$this->db->query($sql);
		$sql = "CREATE TABLE `tbl_group_permissions` (
			`id` int unsigned NOT NULL AUTO_INCREMENT,
			`group_id` int unsigned,
			`permission_id` int unsigned,
			 created_at TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
			 PRIMARY KEY (`id`))";
		$this->db->query($sql);
		$sql = "alter table `tbl_group_permissions` 
				ADD FOREIGN KEY(group_id)
				REFERENCES tbl_groups(id)";
		$this->db->query($sql);
		$sql = "alter table `tbl_group_permissions` 
				ADD FOREIGN KEY(permission_id)
				REFERENCES tbl_permissions(id)";
		$this->db->query($sql);
		$sql = "alter table `tbl_group_permissions` 
				ADD updated_at DATETIME ";
		$this->db->query($sql);
		echo "9";
	}

	public function down()
	{
		$this->dbforge->drop_table('tbl_group_permissions');
	}

}
