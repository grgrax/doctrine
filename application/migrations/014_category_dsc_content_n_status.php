<?php
class Migration_category_dsc_content_n_status extends CI_Migration {

	public function up()
	{
		$sql = "alter table `tbl_categories` 
		add `status` tinyint DEFAULT 0";
		$this->db->query($sql);
		echo "14";
	}

	public function down()
	{
		$sql = "alter table `tbl_categories` 
		drop `status`";
		$this->db->query($sql);
	}
}