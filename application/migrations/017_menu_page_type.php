<?php
class Migration_menu_page_type extends CI_Migration {

	public function up()
	{
		$sql = "ALTER TABLE `tbl_menus` ADD `page_type_id` int unsigned NOT NULL";
		$this->db->query($sql);		
		$sql = "alter table `tbl_menus` 
		ADD FOREIGN KEY(page_type_id)
		REFERENCES tbl_page_types(id)";
		$this->db->query($sql);
		echo "17";
		}

		public function down()
		{
			$sql = "alter table `tbl_menus` 
			drop `page_type_id`";
			$this->db->query($sql);
		}
}