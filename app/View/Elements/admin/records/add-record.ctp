<div class="row">	
	<div class="col-lg-12">
		<form id="addRecord" role="form" method="post" action="<?php echo $this->Html->url(array('controller' => "Records", 'action' => "addRecord",'admin' => false));?>">
			<div class="form-group">
				<label>Registro</label>
				<input type="numeric" class="form-control record" name="data[Record][record]" required>
				<p class="help-block">Ejemplo:  56787900</p>
				<p class="error-block" style="color: red;"></p>
			</div>

			<input type="hidden" name="data[Record][user_id]" value="<?php echo $userId;?>">		
		</form>
	</div>
</div>