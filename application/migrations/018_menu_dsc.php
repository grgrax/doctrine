<?php
class Migration_menu_dsc extends CI_Migration {

	public function up()
	{
		$sql = "alter table `tbl_menus` 
		add `desc` varchar(255) DEFAULT NULL";
		$this->db->query($sql);
		echo "18";
		}

		public function down()
		{
			$sql = "alter table `tbl_menus` 
			drop `desc`";
			$this->db->query($sql);
		}
}