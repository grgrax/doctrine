<?php
class Migration_menu_article extends CI_Migration {

	public function up()
	{
		$sql = "ALTER TABLE `tbl_menus` 
				ADD `article_id` int(10) DEFAULT NULL";
		$this->db->query($sql);		
		$sql = "alter table `tbl_menus` 
		ADD FOREIGN KEY(article_id)
		REFERENCES tbl_articles(id)";
		$this->db->query($sql);
		echo "20";
		}

		public function down()
		{
			$sql = "alter table `tbl_menus` 
			drop `article_id`";
			$this->db->query($sql);
		}
}