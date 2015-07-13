<?php
class Migration_create_permission extends CI_Migration {

	public function up()
	{
		$sql = "DROP TABLE IF EXISTS `tbl_permissions`";
		$this->db->query($sql);
		$sql = "CREATE TABLE `tbl_permissions` (
			`id` int unsigned NOT NULL AUTO_INCREMENT,
			`name` varchar(255) NOT NULL,
			`slug` varchar(100) NOT NULL,
			`desc` varchar(255) DEFAULT NULL,
			created_at TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),UNIQUE (`name`))";
		$this->db->query($sql);
		echo "5";
}

public function down()
{
	$this->dbforge->drop_table('tbl_permissions');
}
}