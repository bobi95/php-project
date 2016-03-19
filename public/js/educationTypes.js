jQuery(
	function($)
	{
		// DataTables
		window.ЕducationTypesListTable = $('#educationType-table').DataTable({
			serverSide	: true,
			ajax		: { url: '/EducationTypes/listeducationTypes', type: 'POST'},
			orderMulti	: false,
			scrollX		: false,
			ordering	: true,
			//autoWidth	: true,
			columns		: [
							{name: 'id'			, data: 'id'			, searchable: false	, orderable: true},
							{name: 'name'		, data: 'name'			, searchable: true	, orderable: true},	
							{name: 'number'		, data: 'number'		, searchable: true	, orderable: true},
							{name: 'options'	, data: 'options'		, searchable: false	, orderable: false}
						]
		});
	}
);