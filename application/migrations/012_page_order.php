<?php
class Migration_page_order extends CI_Migration {

	public function up()
	{
		$sql = "alter table `tbl_pages` 
		drop `menu_level`";
		$this->db->query($sql);
		$sql = "alter table `tbl_pages` 
		add `order` int unsigned";
		$this->db->query($sql);
		echo "12";
	}

	public function down()
	{
		$sql = "alter table `tbl_pages` 
		drop `order` int unsigned";
		$this->db->query($sql);
		$sql = "alter table `tbl_pages` 
		add `menu_level` int unsigned";
		$this->db->query($sql);
	}
}