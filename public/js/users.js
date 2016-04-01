jQuery(
	function($)
	{
		// DataTables
		window.decisionsListTable = $('#user-table').DataTable({
			serverSide	: true,
			ajax		: { url: '/Users/listusers', type: 'POST'},
			orderMulti	: false,
			scrollX		: false,
			ordering	: true,
			//autoWidth	: true,
			columns		: [
							{name: 'user_id'			, data: 'user_id'			, searchable: false	, orderable: true},
							{name: 'user_name'			, data: 'user_name'			, searchable: true	, orderable: true},
							{name: 'user_email'			, data: 'user_email'		, searchable: true  , orderable: true},
							{name: 'user_role_id'		, data: 'user_role_id'		, searchable: false	, orderable: false},
							{name: 'options'			, data: 'options'			, searchable: false	, orderable: false}
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