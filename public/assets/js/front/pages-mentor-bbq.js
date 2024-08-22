/**
 * Page Card Home BBQ
 */

'use strict';

$(function () {
  // ajax setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var dtBbqTabl

  $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (event) {
    var tabID = $(event.target).attr('data-bs-target');
    if ( tabID === '#navs-tab-bbq' ) {
      if ( $.fn.DataTable.isDataTable( '.dt-table-bbq1' ) ) {
        var dtTable1 = new $.fn.dataTable.Api( '.dt-table-bbq1' );
        dtTable1.columns.adjust().responsive.recalc();
        /*dtTable1.ajax.reload(null,false);*/
      }
    }
    if ( tabID === '#navs-tab-surah' ) {
        if ( $.fn.DataTable.isDataTable( '.dt-table-bbq1' ) ) {
            var dtTable2 = new $.fn.dataTable.Api( '.dt-table-bbq1' );
            dtTable2.columns.adjust().responsive.recalc();
        }
    }
  } );

})
