<?php
class Migration_add_testimonial_slug extends CI_Migration {

	public function up()
	{
		$sql = "alter table `tbl_testimonials` 
		add `slug` varchar(100) NOT NULL";
		$this->db->query($sql);
		echo "10";
	}

	public function down()
	{
		$sql = "ALTER TABLE `tbl_testimonials` DROP COLUMN `slug`;";
		$this->db->query($sql);
	}
}