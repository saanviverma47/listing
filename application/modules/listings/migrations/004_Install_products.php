<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_products extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'products';

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
			'title' => array(
					'type' => 'VARCHAR',
					'constraint' => 100,
					'null' => FALSE,
			),
			'type' => array(
					'type' => 'CHAR',
					'constraint' => 10,
					'null' => FALSE,
			),
			'image' => array(
					'type' => 'VARCHAR',
					'constraint' => 100,
					'null' => FALSE,
			),
			'description' => array(
					'type' => 'TEXT',
					'null' => FALSE,
			),
			'active' => array(
					'type' => 'TINYINT',
					'constraint' => 1,
					'null' => FALSE,
			),
			'created_on' => array(
					'type' => 'datetime',
					'default' => '0000-00-00 00:00:00',
			),
			'modified_on' => array(
					'type' => 'datetime',
					'default' => '0000-00-00 00:00:00',
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