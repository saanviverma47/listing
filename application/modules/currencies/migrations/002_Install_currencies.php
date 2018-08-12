<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_currencies extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'currencies';

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
		'code' => array(
			'type' => 'CHAR',
			'constraint' => 3,
			'null' => FALSE,
		),
		'symbol' => array(
			'type' => 'VARCHAR',
			'constraint' => 40,
			'null' => FALSE,
		),
		'name' => array(
			'type' => 'VARCHAR',
			'constraint' => 80,
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