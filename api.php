<?php
	require_once __DIR__ . '/prob.php';
	require_once __DIR__ . '/DBase.php';

	$N = 40;
	$iq = isset($_GET['iq']) ? intval($_GET['iq']) : 0;
	$from = isset($_GET['from']) ? intval($_GET['from']) : 0;
	$to  = isset($_GET['to']) ? intval($_GET['to']) : 100;
	
	$fCalls = DBase::open('calls.che');	//Таблица числа вызовов
	$arr = DBase::calls($fCalls);
	foreach ($arr as &$el)
	{
		$el['level'] = random_int($from, $to);
		$el['used'] = false;
	}
	unset($el);
	
	$X = 0;
	for ($i = 1;$i <= $N;$i++)	
	{
		$probs = Prob::probs($arr);	
		$weights = Prob::weights($probs);
		$r = Prob::randWeight($weights);
		$arr[$r]['calls']++;
		$arr[$r]['used'] = true;
		$res[$i] = array(
			'num' => $i,
			'id' => $arr[$r]['id'],
			'calls' => $arr[$r]['calls'],
			'level' => $arr[$r]['level'],
			'answer' => Prob::answer($iq, $arr[$r]['level'])
		);
		if ($res[$i]['answer'] === 'YES') $X++;	
	}	
				
	DBase::putCalls($fCalls, $arr);
	DBase::close($fCalls);
	$fStats = DBase::open('stats.che');	//Таблица истории вызовов
	$stat = DBase::stat($fStats);
	$num = $stat[0];
	$stat = $stat[1];
	$stat[$num] = array(
		'num' => $num,
		'iq' => $iq,
		'range' => "$from-$to",
		'X' => $X
	);
	DBase::putStat($fStats, $stat);
	DBase::close($fStats);
	
	/*
	$result = array(
		'result' => $res,
		'statistic' => $stat,
		'right_answers' => $X
	);
	echo json_encode($result);
	*/
	require_once 'view.php';
?>
