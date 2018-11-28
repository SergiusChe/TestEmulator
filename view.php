<div>
	<h3>Текущее испытание</h3>
	<table width="100%">
		<?php if (isset($res)): ?>
			<tr> 
				<th>Номер</th>
				<th>ID</th>
				<th>Использован раз</th>
				<th>Сложность</th>
				<th>Задача решена</th>
			</tr>
			<?php foreach ($res as $el): ?>
				<tr> 
					<td><?=$el['num'];?></td>
					<td><?=$el['id'];?></td>
					<td><?=$el['calls'];?></td>
					<td><?=$el['level'];?></td>
					<td><?=$el['answer'];?></td>
				</tr>
			<?php endforeach; ?>					
		<?php endif; ?>
	</table>
</div>
<?php if (isset($X)): ?>
	<h3>Правильных ответов: <?=$X;?> из 40</h3>
<?php endif; ?>
<div>
	<h3>История Испытаний</h3>
	<table width="100%">
		<?php if (isset($stat)): ?>
			<tr> 
				<th>Номер</th>
				<th>IQ</th>
				<th>Сложность задач</th>
				<th>Решено из 40</th>
			</tr>
			<?php foreach ($stat as $el): ?>
				<tr> 
					<td><?=$el['num'];?></td>
					<td><?=$el['iq'];?></td>
					<td><?=$el['range'];?></td>
					<td><?=$el['X'];?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</table>
</body>
