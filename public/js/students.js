jQuery(
	function($)
	{
		// DataTables
		window.rolesListTable = $('#students-table').DataTable({
			serverSide	: true,
			ajax		: { url: '/students/liststudents', type: 'POST'},
			orderMulti	: false,
			scrollX		: false,
			ordering	: true,
			//autoWidth	: true,
			columns		: [
							{name: 'student_id'					, data: 'student_id'					, searchable: false	, orderable: true},
                            {name: 'student_names'              , data: 'student_names'                 , searchable: false , orderable: false},
							{name: 'student_fnumber'			, data: 'student_fnumber'				, searchable: true	, orderable: true},
							{name: 'student_course_id'			, data: 'student_course_id'				, searchable: false	, orderable: true},
							{name: 'student_speciality_id'		, data: 'student_speciality_id'			, searchable: false	, orderable: true},
							{name: 'student_education_form'		, data: 'student_education_form'		, searchable: false	, orderable: true},
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