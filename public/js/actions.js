jQuery(
	function($)
	{
		// DataTables
		window.ActionsListTable = $('#actions-table').DataTable({
			serverSide	: true,
			ajax		: { url: '/actions/listactions', type: 'POST'},
			orderMulti	: false,
			scrollX		: false,
			ordering	: true,
			//autoWidth	: true,
			columns		: [
							{name: 'id'				, data: 'id'			, searchable: false	, orderable: true},
							{name: 'name'			, data: 'name'			, searchable: true	, orderable: true},
							{name: 'controller_id'	, data: 'controller_id'	, searchable: true	, orderable: true},
							{name: 'options'		, data: 'options'		, searchable: false	, orderable: false}
						]
		});

		// Delete decision from DataTables
		$(document).on(
			'click',
			'.delete-button',
			function(e)
			{
				e.preventDefault();

				if (window.MODAL_ACTIVE) return;
				window.MODAL_ACTIVE = true;

				var
					$this = $(this),
					deletionUrl = $this.data('href');

				$('#confirm-deletion').on(
					'click.deletionEvents',
					function()
					{
						$('#delete-modal').modal('hide');

						window.location.href = deletionUrl;
					}
				);

				$('#delete-modal')
					.modal()
					.on(
						'show.bs.modal',
						function()
						{
							window.MODAL_ACTIVE = true;
						}
					)
					.on(
						'hide.bs.modal',
						function()
						{
							window.MODAL_ACTIVE = false;
							$('#confirm-deletion').off('.deletionEvents');
						}
					);
			}
		);
	}
);