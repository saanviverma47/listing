<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_listings extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'listings';

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
		'slug' => array(
			'type' => 'VARCHAR',
			'constraint' => 100,
			'null' => FALSE,
		),
		'category_id' => array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => FALSE,
		),
		'subcategory_id' => array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => FALSE,
		),
		'country_id' => array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => FALSE,
		),
		'state_id' => array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => FALSE,
		),
		'city_id' => array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => FALSE,
		),
		'pincode' => array(
			'type' => 'INT',
			'constraint' => 10,
			'null' => FALSE,
		),
		'address' => array(
			'type' => 'VARCHAR',
			'constraint' => 250,
			'null' => FALSE,
		),
		'latitude' => array(
			'type' => 'VARCHAR',
			'constraint' => 30,
			'null' => FALSE,
		),
		'longitude' => array(
			'type' => 'VARCHAR',
			'constraint' => 30,
			'null' => FALSE,
		),
		'contact_person' => array(
			'type' => 'VARCHAR',
			'constraint' => 50,
			'null' => FALSE,
		),
		'phone_number' => array(
			'type' => 'VARCHAR',
			'constraint' => 20,
			'null' => FALSE,
		),
		'mobile_number' => array(
			'type' => 'VARCHAR',
			'constraint' => 30,
			'null' => FALSE,
		),
		'tollfree' => array(
			'type' => 'VARCHAR',
			'constraint' => 30,
			'null' => FALSE,
		),
		'fax' => array(
			'type' => 'VARCHAR',
			'constraint' => 30,
			'null' => FALSE,
		),
		'email' => array(
			'type' => 'VARCHAR',
			'constraint' => 100,
			'null' => FALSE,
		),
		'website' => array(
			'type' => 'VARCHAR',
			'constraint' => 100,
			'null' => FALSE,
		),
		'description' => array(
			'type' => 'LONGTEXT',
			'null' => FALSE,
		),
		'keywords' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
			'deleted' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'default' => '0',
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