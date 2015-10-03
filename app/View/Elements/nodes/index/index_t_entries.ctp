<?php foreach ($result as $row): ?>
<tr>
		<td class="td_id">
		
			<?php 
				echo $row['_id']; 
			?>
			
		</td>
		
		<td><?php echo $row['text']; ?></td>
		
		<td class="td_news_time"><?php echo $row['created_at']; ?></td>
		<td class="td_news_time"><?php echo $row['modified_at']; ?></td>
		
</tr>
<?php endforeach; ?>
<?php unset($row); ?>
