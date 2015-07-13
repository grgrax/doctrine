<?php
class Migration_user_email extends CI_Migration {

	public function up()
	{
		$sql = "ALTER TABLE `tbl_users` ADD `email` VARCHAR(100) NOT NULL AFTER `username`";
		$this->db->query($sql);
		$sql = "ALTER TABLE `tbl_users` ADD unique (email)";
		$this->db->query($sql);
		echo "7";
	}

	public function down()
	{
		$sql = "ALTER TABLE `tbl_users` DROP COLUMN `email`;";
		$this->db->query($sql);
	}
}
?>