$(document).ready(function(){
	var titulo_modal_original = $('#confirmar .modal-title').text();
	/**
	 * Agregar un nuevo clon
	 */
	$('.js-clon-agregar').on('click', function(evento, data)
	{
		evento.preventDefault();

		var $this			= $(this),
			$scope			= $this.parents('.js-clon-scope').first(),
			$base			= $('.js-clon-base', $scope),
			$contenedor		= $('.js-clon-contenedor', $scope),
			$clon			= $base.clone(),
			$tr;

		/**
		 * Hace visible al elemento clonado y quita los atributos de deshabilitado
		 */
		$clon.removeClass('hidden js-clon-base');
		$clon.find('input, select, textarea').each(function()
		{
			$(this).removeAttr('disabled');
		});
		$clon.find('select').selectpicker();
		$clon.find('input[type="checkbox"]').iCheck(
		{
			checkboxClass	: 'icheckbox_flat-red',
			radioClass		: 'iradio_flat-red',
			increaseArea	: '20%'
		});

		/**
		 * Si es accion clonar, copia los datos y escribe la fila bajo la seleccionada
		 */
		if ( typeof(data) === 'object' && typeof(data.clone) !== 'undefined' )
		{
			$tr			= $(data.element).parents('tr').first();
			$tr.find('input, select, textarea').each(function(index)
			{
				$clon.find('input, select, textarea').eq(index).val($(this).val());
			});
			$tr.after($clon.show());
		}

		/**
		 * Si es accion agregar, agrega la fila al final de la tabla
		 */
		else
		{
			$contenedor.append($clon.show());
		}

		/**
		 * Reindexa
		 */
		clonReindexar();

		/**
		 * Actualiza el alto del contenido
		 */
		page_content_onresize();
	});

	/**
	 * Eliminar clon
	 */
	$('.js-clon-contenedor').on('click', '.js-clon-eliminar', function(evento)
	{
		evento.preventDefault();

		var $this			= $(this),
			$tr				= $this.parents('tr').first();

		$tr.remove();

		/**
		 * Reindexa
		 */
		clonReindexar();
	});

	/**
	 * Clonar
	 */
	$('.js-clon-contenedor').on('click', '.js-clon-clonar', function(evento)
	{
		evento.preventDefault();
		var $scope			= $(this).parents('.js-clon-scope').first();
		$('.js-clon-agregar', $scope).trigger('click', { clone: true, element: this });
	});

	/**
	 * Agrega un clon en blanco si es necesario
	 */
	if ( $('.js-clon-blank').length )
	{
		$('.js-clon-blank').parents('.js-clon-scope').find('.js-clon-agregar').trigger('click');
	}

	/**
	 * Reindexa los input clonados, agregados o eliminados
	 */
	function clonReindexar()
	{
		var $contenedor			= $('.js-clon-contenedor');

		$contenedor.find('tr:visible').each(function(index)
		{
			$(this).find('input, select, textarea').each(function()
			{
				var $that		= $(this),
					nombre		= $that.attr('name').replace(/[(\d)]/g, (index + 1));

				$that.attr('name', nombre);
			});
		});
	}

	/**
	*	Calendario
	**/
	$(document).on('click','.calendar-box', function(){
		var box = $(this);
		var semana = box.data('semana');
		var dia = box.data('dia');
		if (box.text() == '') {
			modalAgregar(semana,dia);
		}else{
			var contenedor_input = box.children('.modificar').html();
			modal(semana,dia,contenedor_input);
		}

		$('#confirmar input[type="hidden"]').attr('type','text');

	});

	$(document).on('click','#confirmar-evento',function(){
		var semana = $(this).data('x');
		var dia = $(this).data('y');
		
	});

	function modal(x,y,bodys){
		var modal = $('#confirmar');
		var title = $('#confirmar .modal-title');
		var body = $('#confirmar .modal-body');
		var btn = $('#confirmar #confirmar-evento');
		body.html(bodys);
		btn.attr({'data-x': x, 'data-y':y});
		title.text('Modificar evento');
		modal.modal('show');
	}

	function modalAgregar(x,y){
		var modal = $('#confirmar');
		var title = $('#confirmar .modal-title');
		var body = $('#confirmar .modal-body');
		var btn = $('#confirmar #confirmar-evento');
		btn.attr({'data-x': x, 'data-y':y});
		body.text(x+'-'+y);
		title.text('Agregar evento');
		modal.modal('show');
	}

	function modificarEvento(x,y,value_name,value_comment){

	}
});