<?php
	
	class StatAnalysis {
		
		/** 
		 * Calculate the average of an array of numbers.
		 * @param array
		 * @return integer
		 */
		public function calcAverage($arr)
		{
			if (is_array($arr)) {
				$sum = array_sum($arr);
				$numberOfElements = count($arr);
				return round($sum/$numberOfElements, 3);
			}
			return false;
		}
		
		/**
		 * Calcluate the standard deviation of an array of numbers.
		 * @param array
		 * @return float
		 */
		public function calcStandardDeviation($arr)
		{
			if (is_array($arr)) {
				$fAvg = array_sum($arr) / count($arr);
				$fVariance = 0.0;
				
				foreach ($arr as $i)
				{
					$fVariance += pow($i - $fAvg, 2);
				}
			
				$fVariance /= count($arr);			
				return (float) round(sqrt($fVariance), 3);
			}
			return false;
		}
		
		/**
		 * Create an integer array with just the
		 * values from the resultset
		 * @param array
		 * @return array
		 */
		public function toIntArray($outerArray) {
			$arrInt = array();
			if (is_array($outerArray)) {
				foreach ($outerArray as $key => $row) {
					foreach($row as $name => $value)
					{
						$arrInt[] = intval($value);
					}
				}
				return $arrInt;
			}
			return false;
		}
		
		
	}

?>