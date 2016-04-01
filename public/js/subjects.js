jQuery(
	function($)
	{
		// DataTables
		window.rolesListTable = $('#subjects-table').DataTable({
			serverSide	: true,
			ajax		: { url: '/Subjects/listsubjects', type: 'POST'},
			orderMulti	: false,
			scrollX		: false,
			ordering	: true,
			//autoWidth	: true,
			columns		: [
							{name: 'subject_id'					, data: 'subject_id'					, searchable: false	, orderable: true},
							{name: 'subject_name'				, data: 'subject_name'					, searchable: true	, orderable: true},
							{name: 'subject_workload_lectures'	, data: 'subject_workload_lectures'		, searchable: true	, orderable: true},
							{name: 'subject_workload_exercises'	, data: 'subject_workload_exercises'	, searchable: true	, orderable: true},
							{name: 'options'					, data: 'options'						, searchable: false	, orderable: false}
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