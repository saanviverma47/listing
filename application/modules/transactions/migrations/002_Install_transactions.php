<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_transactions extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'transactions';

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
		'invoice' => array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => FALSE,
		),
		'user_id' => array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => FALSE,
		),
		'package_id' => array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => FALSE,
		),
		'received_on' => array(
			'type' => 'DATETIME',
			'null' => FALSE,
			'default' => '0000-00-00 00:00:00',
		),
		'amount' => array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => FALSE,
		),
		'description' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'comments' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'status' => array(
			'type' => 'VARCHAR',
			'constraint' => 10,
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