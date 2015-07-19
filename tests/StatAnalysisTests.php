<?php
/**
 * @author eamon
 * test case class for  StatAnalysis
 **/


require_once '../simpletest/autorun.php';

class StatisticalAnalysisTests extends UnitTestCase {
	private $statAnalysisOBJ;
	
	public function setUp()  {
		require_once '../app/tools/StatAnalysis.php';
		$this->statAnalysisOBJ = new StatAnalysis();
	}
	
	public function tearDown() {
		$this->statisticalAnalysisOBJ = null;
	}
	
	/**
	 * Test to calculate the average of an array of numbers
	 */
	public function testAverage() {
		$array = array(1, 2, 3, 4,  5, 6, 7, 8, 9, 10);
		$num = 1;
		$str = "abcde";
		$this->assertEqual(5.5, $this->statAnalysisOBJ->calcAverage($array));
		$this->assertNotEqual(10, $this->statAnalysisOBJ->calcAverage($array));
		$this->assertFalse($this->statAnalysisOBJ->calcAverage($num));
		$this->assertFalse($this->statAnalysisOBJ->calcAverage($str));
	}
	
	/**
	 * Test to calculate the standard deviation of an
	 * array of numbers
	 */
	public function testStandardDeviation() {
		$array = array(2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47);
		$num = 1;
		$str = "abcde";
		$this->assertEqual(14.818, $this->statAnalysisOBJ->calcStandardDeviation($array));
		$this->assertNotEqual(50, $this->statAnalysisOBJ->calcAverage($array));
		$this->assertFalse($this->statAnalysisOBJ->calcStandardDeviation($num));
		$this->assertFalse($this->statAnalysisOBJ->calcStandardDeviation($str));
	}
	
	
	/**
	 * Test the extraction of an inner 
	 * array of ints from an array of arrays
	 */
	public function testToIntArray() {
		$outerArray = array( array("age" => "1"), array("age" => "2"),
				array("age" => 3) );
		$innerArray = array(1, 2, 3);
		$num = 1;
		$str = "abcde";
		$this->assertEqual($innerArray, $this->statAnalysisOBJ->toIntArray($outerArray));
		$this->assertFalse($this->statAnalysisOBJ->toIntArray($num));
		$this->assertFalse($this->statAnalysisOBJ->toIntArray($str));
	}
	
	
		
}
?>