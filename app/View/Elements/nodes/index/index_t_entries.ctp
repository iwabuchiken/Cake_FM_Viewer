<?php $i = 0; ?>

<?php foreach ($node_array as $node): ?>
<tr>
		<td class="td_id">
		
			<?php 
				echo $i + 1; 
			?>
			
		</td>
		
		<td><?php echo $node['sn']; ?></td>
		
		<td><?php echo $node['text']; ?></td>
		
</tr>

<?php $i += 1; ?>

<?php endforeach; ?>
<?php unset($node); ?>
