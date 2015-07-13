ALTER table_name
ADD CONSTRAINT constraint_name
FOREIGN KEY foreign_key_name(columns)
REFERENCES parent_table(columns)
ON DELETE action
ON UPDATE action

$sql = "alter table `tbl_users` 
ADD CONSTRAINT `fk_group_id`
FOREIGN KEY(group_id)
REFERENCES tbl_groups(id)";
<?php
class Migration_user_group extends CI_Migration {

	public function up()
	{
		$sql = "ALTER TABLE `tbl_users` ADD `group_id` int unsigned NOT NULL AFTER `id`";
		$this->db->query($sql);
		
		$sql = "alter table `tbl_users` 
		ADD CONSTRAINT `fk_group_id`
		FOREIGN KEY(group_id)
		REFERENCES tbl_groups(id)";
		$this->db->query($sql);

		echo "6";
	}

	public function down()
	{
		$sql = "ALTER TABLE `tbl_users` 
		DROP FOREIGN KEY `fk_group_id` , 
		DROP COLUMN `group_id`;";
		$this->db->query($sql);
	}
}
?>
CREATE TABLE `personal_info` (
`p_id` int(11) NOT NULL AUTO_INCREMENT,
`name` text NOT NULL,
`initials` text NOT NULL,
`surname` text NOT NULL,
`home_lang` int(11) NOT NULL,
PRIMARY KEY (`p_id`),
KEY `home_lang` (`home_lang`),
CONSTRAINT `personal_info_ibfk_1` FOREIGN KEY (`home_lang`) REFERENCES `language_list` (`ll_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1

CREATE TABLE `language_list` (
`ll_id` int(11) NOT NULL AUTO_INCREMENT,
`name` text NOT NULL,
PRIMARY KEY (`ll_id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1





alter table users add grade_id smallint unsigned not null default 0;

ALTER TABLE users ADD CONSTRAINT fk_grade_id FOREIGN KEY (grade_id) references grades(id);


$sql = "alter table `tbl_users` 
ADD 
KEY `home_lang` (`home_lang`),
CONSTRAINT `personal_info_ibfk_1`
FOREIGN KEY(group_id)
REFERENCES tbl_groups(id)";



SET foreign_key_checks = 0;
DELETE FROM users where id > 45;
SET foreign_key_checks = 1;




CREATE TABLE categories(
cat_id int not null auto_increment primary key,
cat_name varchar(255) not null,
cat_description text
) ENGINE=InnoDB;

CREATE TABLE products(
prd_id int not null auto_increment primary key,
prd_name varchar(355) not null,
prd_price decimal,
cat_id int not null,
FOREIGN KEY fk_cat(cat_id)
REFERENCES categories(cat_id)
ON UPDATE CASCADE
ON DELETE RESTRICT
)ENGINE=InnoDB;