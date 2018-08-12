<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_business_hours extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'business_hours';

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
		'day_of_week' => array(
			'type' => 'TINYINT',
			'constraint' => 1,
			'null' => FALSE,
		),
		'open_time' => array(
			'type' => 'TIME',
			'null' => FALSE,
		),
		'close_time' => array(
			'type' => 'TIME',
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