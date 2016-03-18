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
							{name: 'id'			, data: 'id'			, searchable: false	, orderable: true},
							{name: 'username'	, data: 'username'		, searchable: true	, orderable: true},
							{name: 'email'		, data: 'email'			, searchable: true  , orderable: true},
							{name: 'role_id'	, data: 'role_id'		, searchable: false	, orderable: true},
							{name: 'options'	, data: 'options'		, searchable: false	, orderable: false}
						]
		});
	}
);