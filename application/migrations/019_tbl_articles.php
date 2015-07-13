<?php
class Migration_tbl_articles extends CI_Migration {

	public function up()
	{
		$sql = "DROP TABLE IF EXISTS `tbl_articles`";
		$this->db->query($sql);
		$sql = "CREATE TABLE `tbl_articles` (
			`id` int unsigned NOT NULL AUTO_INCREMENT,
			`name` varchar(100) NOT NULL,
			`slug` varchar(100) NOT NULL,
			`content` varchar(10000) DEFAULT NULL,
			`category_id` int unsigned,
			`image` varchar(100) DEFAULT NULL,
			`image_title` varchar(100) DEFAULT NULL,
			`video` varchar(100) DEFAULT NULL,
			`video_title` varchar(100) DEFAULT NULL,
			`video_url` varchar(200) DEFAULT NULL,
			`embed_code` varchar(10000) DEFAULT NULL,
			`status` tinyint DEFAULT 0,
			created_at TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
			author int(10),
			modified_by int(10),
			`meta_key` varchar(100) DEFAULT NULL,
			`meta_desc` varchar(10000) DEFAULT NULL,
			`meta_robots` varchar(100) DEFAULT NULL,
			PRIMARY KEY (`id`),UNIQUE (`name`))";
		$this->db->query($sql);
		$sql = "alter table `tbl_articles` 
				ADD updated_at DATETIME ";
		$this->db->query($sql);
		$sql = "alter table `tbl_articles` 
				ADD FOREIGN KEY(category_id)
				REFERENCES tbl_categories(id)";
		$this->db->query($sql);
		$sql = "alter table `tbl_articles` 
				ADD FOREIGN KEY(author)
				REFERENCES tbl_users(id)";
		$this->db->query($sql);
		$this->db->query($sql);
		$sql = "alter table `tbl_articles` 
				ADD FOREIGN KEY(modified_by)
				REFERENCES tbl_users(id)";
		$this->db->query($sql);
		echo "19";
	}

	public function down()
	{
		$sql = "drop table `tbl_articles`"; 
		$this->db->query($sql);
	}
}