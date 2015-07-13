<?php
class Migration_tbl_options extends CI_Migration {

	public function up()
	{
		$sql = "DROP TABLE IF EXISTS `tbl_options`";
		$this->db->query($sql);
		$sql = "CREATE TABLE `tbl_options` (
			`id` int unsigned NOT NULL AUTO_INCREMENT,
			`name` varchar(100) NOT NULL,
			`value` varchar(1000) NOT NULL,
			`autoload` tinyint DEFAULT 0,
			PRIMARY KEY (`id`))";
		$this->db->query($sql);
		echo "21";
	}

	public function down()
	{
		$sql = "drop table `tbl_options`"; 
		$this->db->query($sql);
	}
}