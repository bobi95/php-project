jQuery(
	function($)
	{
		// DataTables
		window.rolesListTable = $('#assessment-table').DataTable({
			serverSide	: true,
			ajax		: { url: '/assessments/listassessments', type: 'POST'},
			orderMulti	: false,
			scrollX		: false,
			ordering	: true,
			//autoWidth	: true,
			columns		: [
							{name: 'sa_id'					, data: 'sa_id'						, searchable: false	, orderable: true},
							{name: 'sa_student_id'			, data: 'sa_student_id'				, searchable: true	, orderable: true},
							{name: 'sa_subject_id'			, data: 'sa_subject_id'				, searchable: false	, orderable: true},
							{name: 'sa_assesment'			, data: 'sa_assesment'				, searchable: false	, orderable: true},
							{name: 'sa_workload_lectures'	, data: 'sa_workload_lectures'		, searchable: false	, orderable: true},
							{name: 'sa_workload_exercises'	, data: 'sa_workload_exercises'		, searchable: false	, orderable: true},
							{name: 'options'				, data: 'options'					, searchable: false	, orderable: false}
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