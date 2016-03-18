jQuery(
	function($)
	{
		// DataTables
		window.rolesListTable = $('#roles-table').DataTable({
			serverSide	: true,
			ajax		: { url: '/Roles/listroles', type: 'POST'},
			orderMulti	: false,
			scrollX		: false,
			ordering	: true,
			//autoWidth	: true,
			columns		: [
							{name: 'id'			, data: 'id'			, searchable: false	, orderable: true},
							{name: 'name'		, data: 'name'			, searchable: true	, orderable: true},
							{name: 'options'	, data: 'options'		, searchable: false	, orderable: false}
						]
		});
	}
);