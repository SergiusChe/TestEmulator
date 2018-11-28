<?php
	class Prob
	{
		public static function answer($iq, $level)	
		{
			if ($level >= $iq) 
				$probability = 0;
			else
				$probability = 0.5 + ($iq / 100 + (($iq - $level) / $iq) * (1 - $iq / 100)) / 2; // вероятность пропорцинальна разности IQ и сложности задачи 

			$weights = array(		//Задаем функцию распределения вероятности
				'YES' => round($probability, 2),
				'NO' => 1
			);
			return self::randWeight($weights);
		}

		public static function probs($arr)	//Считаем функцию плотности вероятности на основе весов
		{
			$probs = array();
			$sumProbs = 0;
			foreach ($arr as $key => $el)
			{
				if ($el['used'] === false)
				{
					$probs[$key] = ($el['calls'] == 0) ? 1000000 : 1 / $el['calls'];
					$sumProbs += $probs[$key];
				}		
				else
					$probs[$key] = 0;	
			}

			foreach ($probs as $key => &$el)
				$el = $el / $sumProbs;	
			unset($el);
			return $probs;
		}

		public static function weights($probs)	//Интегрируем плотность, получаем функцию распределения
		{
			$summa = 0;
			foreach ($probs as $key => $prob)
			{
				$summa += $prob;
				$weights[$key] = round($summa, 2);	
			}
			return $weights;				
		}
	
		public static function randWeight($weights)   //рандомайзер, учитывающий функцию распределения вероятности
		{
			$randomed = random_int(1, 100) / 100;
			foreach ($weights as $key => $weight)
				if ($weight >= $randomed)
					return $key;
		}
	}
?>

