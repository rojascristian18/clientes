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
	 * Dashboard - Grafico 1
	 */
	if ( $('#dashboard-line-1').length )
	{
		Morris.Line(
		{
			element			: 'dashboard-line-1',
			data			: [
				{ y: '2014-10-10', a: 2,b: 4},
				{ y: '2014-10-11', a: 4,b: 6},
				{ y: '2014-10-12', a: 7,b: 10},
				{ y: '2014-10-13', a: 5,b: 7},
				{ y: '2014-10-14', a: 6,b: 9},
				{ y: '2014-10-15', a: 9,b: 12},
				{ y: '2014-10-16', a: 18,b: 20}
			],
			xkey			: 'y',
			ykeys			: ['a','b'],
			labels			: ['Sales','Event'],
			resize			: true,
			hideHover		: true,
			xLabels			: 'day',
			gridTextSize	: '10px',
			lineColors		: ['#E1411E','#FFD559'],
			gridLineColor	: '#E5E5E5'
		});
	}

	/**
	*	Calendario
	**/

	var idCliente = $('#ClienteId').val();
	getCalendar(idCliente);

	function getCalendar(cliente){
		var url = webroot + "clientes/getCalendar/" + cliente;
		$.get( url , function( response ){

			$('#calendarioContainer').html(response);

		});
	}
});