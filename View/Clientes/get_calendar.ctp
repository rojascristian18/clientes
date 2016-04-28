<!-- CALENDARIO -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><sapan class="fa fa-calendar"></sapan> Calendario</h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table calendario">
				<thead>
					<tr>
						<th>Semana/Día</th>
						<th>Lunes</th>
						<th>Martes</th>
						<th>Miercoles</th>
						<th>Jueves</th>
						<th>Viernes</th>
					</tr>
				</thead>
				<tbody>
					<? for ($i=1; $i < 5; $i++) {
						echo "<tr><td><span class='semana'>Semana ".$i."</span></td>";
						for ($j=1; $j < 6; $j++) {
							echo "<td><div class='calendar-box' data-semana='".$i."' data-dia='".$j."'>";
							foreach ($this->request->data['Calendario'] as $indice => $posicion) {
								if ($posicion['semana'] == $i && $posicion['dia'] == $j) {
									echo "<div class='modificar'>";
									echo "<label>" . $posicion['nombre'] . "</label>";
									echo $this->Form->input('Calendario.'.$indice.'.id',array('type' => 'hidden'));
									echo "</div>";
								}
							}
							echo "</div></td>";
						}
						echo "<tr>";
					}?>
				</tbody>
			</table>

			<div class="modal fade" id="confirmar" tabindex="-1" role="dialog">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title">Registrar estado</h4>
			      </div>
			      <div class="modal-body">
			        
			      </div>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).on('click','.calendar-box', function(){
		var box = $(this);
		var semana = box.data('semana');
		var dia = box.data('dia');
		var cliente = $('#ClienteId').val();
		if (box.text() == '') {
			var url = webroot + "calendarios/addEvent/";
			
			$.ajax({
			  method: "GET",
			  url: url,
			  data: { cliente: cliente, semana: semana, dia:dia }
			})
			.done(function( response ) {
		    	modalAgregar(response);
		  	});

		}else{
			var id_evento = box.children('.modificar').children('input[type="hidden"]').first().val();
			var url = webroot + "calendarios/getEventById/" + id_evento;

			$.get( url , function( response ){

				modalEditar(response);

			});
		}

		$('#confirmar input[type="hidden"]').attr('type','text');

	});

	$(document).on('click','#confirmar-evento',function(){
		var semana = $(this).data('x');
		var dia = $(this).data('y');
		
	});

	function modalEditar(bodys){
		var modal = $('#confirmar');
		var title = $('#confirmar .modal-title');
		var body = $('#confirmar .modal-body');
		body.html(bodys);
		title.text('Modificar evento');
		modal.modal('show');
	}

	function modalAgregar(bodys){
		var modal = $('#confirmar');
		var title = $('#confirmar .modal-title');
		var body = $('#confirmar .modal-body');
		body.html(bodys);
		title.text('Agregar evento');
		modal.modal('show');
	}

	function modificarEvento(x,y,value_name,value_comment){

	}
</script>