var datatable = $('#dataTable').DataTable({ 
    initComplete: function() {
        var api = this.api();
        $('#mytable_filter input')
            .off('.DT')
            .on('input.DT', function() {
                api.search(this.value).draw();
        });
    },
    oLanguage: {
    sProcessing: "loading..."
    },
    processing: true,
    serverSide: true,
    ajax: {"url": url_base+"store/load_store", "type": "POST"},
    columns: [
        {"data": "nama_store"},
        {"data": "nama_pemilik"},
        {"data": "no_hp"},
        {"data": "nominal", render : function(data){
            return formatRupiah(data, "Rp.");
        }},
        {"data": "menu"},
    ],
    order: [[0, 'asc']],
    rowCallback: function(row, data, iDisplayIndex) {
        var info = this.fnPagingInfo();
        var page = info.iPage;
        var length = info.iLength;
        $('td:eq(0)', row).html();
    },
    "columnDefs": [
    { "searchable": false, "targets": [""] },  // Disable search on first and last columns
    { "targets": [3], "orderable": false},
    ],
    "rowReorder": {
        "selector": 'td:nth-child(0)'
    },
    "responsive": true,
});