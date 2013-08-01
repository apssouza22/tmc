<?php

require_once '/home/apssouza/Projetos/jobs/tmc/include/config.php';

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-12 at 01:41:44.
 */
class QuedaTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var Queda
	 */
	protected $object;
	
	public function __construct()
	{
		$oDelete = new Delete(Queda::TB_NAME);
		$oDelete->exec();
	
	}

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new Queda;
		$this->oEquip = new stdClass();
		$this->oEquip->id =1;
		$this->oEquip->cliente_id =1;
		$this->oEquip->ip = '192.168.1.111';
	}
	
	public function testInicio()
	{
		$this->assertGreaterThan(0, $this->object->inicio($this->oEquip,1));
	}

	/**
	 * @covers Queda::getEquipamentosFora
	 * @todo   Implement testGetEquipamentosFora().
	 */
	public function testGetEquipamentosFora()
	{
		$this->assertTrue(is_array($this->object->getEquipamentosFora()));
	}

	

	/**
	 * @covers Queda::fim
	 * @todo   Implement testFim().
	 */
	public function testFim()
	{
		$this->assertGreaterThan(0, $this->object->fim($this->oEquip));
	}

}