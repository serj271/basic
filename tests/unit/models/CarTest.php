<?php 
namespace models;
//use app\tests\fixtures\CarFixture;
use app\tests\fixtures\CarFixture;
use app\models\Car;

class CarTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
	public function _fixtures()
	{
		return ['cars' => CarFixture::className()];
	}
    protected function _before()
    {
		$this->tester->haveFixtures([
        'cars' => [
            'class' => CarFixture::className(),
            'dataFile' => codecept_data_dir() . 'cars.php'
        ]
    ]);
    }

    protected function _after()
    {
    }

    public function testCreate()
    {
		$car = new Car();
		$car->name = 'Название';
		$car->model = 'bmw';
		expect_that($car->save());
    }
    /**
     * empty form
     */
    public function testCreateEmptyFormSubmit()
    {
    }
    /**
     * delete car
     */
    public function testDelete()
    {
    }
    /**
     * update car
     */
    public function testUpdate()
    {
    }
}