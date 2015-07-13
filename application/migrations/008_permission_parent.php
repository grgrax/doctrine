<?php
class Migration_permission_parent extends CI_Migration {

	public function up()
	{
		$sql = "ALTER TABLE `tbl_permissions` ADD `parent_permission_id` int unsigned NOT NULL AFTER `id`";
		$this->db->query($sql);		
		$sql = "alter table `tbl_permissions` 
		ADD CONSTRAINT `fk_parent_permission_id`
		FOREIGN KEY(parent_permission_id)
		REFERENCES tbl_permissions(id)";
		$this->db->query($sql);
		echo "8";
	}

	public function down()
	{
		$sql = "ALTER TABLE `tbl_permissions` 
		DROP FOREIGN KEY `fk_parent_permission_id` , 
		DROP COLUMN `parent_permission_id`;";
		$this->db->query($sql);
	}
}
?>