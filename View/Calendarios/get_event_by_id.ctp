<?= $this->Form->create('Calendario', array('class' => 'form-horizontal', 'type' => 'file', 'inputDefaults' => array('label' => false, 'div' => false, 'class' => 'form-control'))); ?>
<table class="table">
	<?= $this->Form->input('id'); ?>
	<?= $this->Form->input('cliente_id',array('type' => 'hidden')); ?>
	<?= $this->Form->input('dia',array('type' => 'hidden')); ?>
	<?= $this->Form->input('semana',array('type' => 'hidden')); ?>
	<tr>
		<th><?= $this->Form->label('nombre', 'Nombre'); ?></th>
		<td><?= $this->Form->input('nombre'); ?></td>
	</tr>
	<tr>
		<th><?= $this->Form->label('observacion', 'Observación'); ?></th>
		<td><?= $this->Form->input('observacion'); ?></td>
	</tr>
</table>

<div class="pull-right">
	<input type="submit" id="btn_guardar_evento" class="btn btn-primary esperar-carga" autocomplete="off" data-loading-text="Espera un momento..." value="Guardar cambios">
	<?= $this->Html->link('Cancelar', array(), array('class' => 'btn btn-danger','data-dismiss' => 'modal')); ?>
</div>
<?= $this->Form->end(); ?>
<script type="text/javascript">
	$('#btn_guardar_evento').on('click', function(e){
		e.preventDefault();
		var id 	= $('#CalendarioId').val();
		var url = webroot + "calendarios/saveEventById";
		
		var data = "";
		data += "id="+id;
		data += "&cliente="+$('#CalendarioClienteId').val();
		data += "&nombre="+$('#CalendarioNombre').val();
		data += "&dia="+$('#CalendarioDia').val();
		data += "&semana="+$('#CalendarioSemana').val();
		data += "&observacion="+$('#CalendarioObservacion').val();

		$.post( url , data , function(response){
			$('#confirmar .modal-body').html(response);
			var idCliente = $('#ClienteId').val();
			getCalendar(idCliente);
			setTimeout(function(){
				$('#confirmar').modal('hide');
			},3000);
		});
	});

	function getCalendar(cliente){
		var url = webroot + "clientes/getCalendar/" + cliente;
		$.get( url , function( response ){

			$('#calendarioContainer').html(response);

		});
	}
</script>