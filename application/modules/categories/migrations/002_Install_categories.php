<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_categories extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'categories';

	/**
	 * The table's fields
	 *
	 * @var Array
	 */
	private $fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 11,
			'auto_increment' => TRUE,
		),
		'parent_id' => array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => FALSE,
		),
		'name' => array(
			'type' => 'VARCHAR',
			'constraint' => 100,
			'null' => FALSE,
		),
		'slug' => array(
			'type' => 'VARCHAR',
			'constraint' => 100,
			'null' => FALSE,
		),
		'meta_title' => array(
			'type' => 'VARCHAR',
			'constraint' => 100,
			'null' => FALSE,
		),
		'meta_keywords' => array(
			'type' => 'VARCHAR',
			'constraint' => 250,
			'null' => FALSE,
		),
		'description' => array(
			'type' => 'VARCHAR',
			'constraint' => 1000,
			'null' => FALSE,
		),
		'enabled' => array(
			'type' => 'TINYINT',
			'constraint' => 1,
			'null' => FALSE,
		),
	);

	/**
	 * Install this migration
	 *
	 * @return void
	 */
	public function up()
	{
		$this->dbforge->add_field($this->fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table($this->table_name);
	}

	//--------------------------------------------------------------------

	/**
	 * Uninstall this migration
	 *
	 * @return void
	 */
	public function down()
	{
		$this->dbforge->drop_table($this->table_name);
	}

	//--------------------------------------------------------------------

}