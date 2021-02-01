$("[data-checkboxes]").each(function() {
  var me = $(this),
    group = me.data('checkboxes'),
    role = me.data('checkbox-role');

  me.change(function() {
    var all = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'),
      checked = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"]):checked'),
      dad = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
      total = all.length,
      checked_length = checked.length;

    if(role == 'dad') {
      if(me.is(':checked')) {
        all.prop('checked', true);
      }else{
        all.prop('checked', false);
      }
    }else{
      if(checked_length >= total) {
        dad.prop('checked', true);
      }else{
        dad.prop('checked', false);
      }
    }
  });
});

$("#table-1").dataTable({
  "columnDefs": [
    { "sortable": false, "targets": [2,3] }
  ]
});
$("#table-2").dataTable({
  "columnDefs": [
    { "sortable": false, "targets": [0,2,3] }
  ]
});

$(document).ready(function() {
    $('#tableKriteria').dataTable({
      "lengthMenu": [5,10,25,50]
    });
});

$(document).ready(function() {
    $('#tableParameter').dataTable({
      "lengthMenu": [5,10,25,50]
    });
});

$(document).ready(function() {
    $('#tableData1').dataTable({
      "lengthMenu": [5,10,25,50]
    });
});

$(document).ready(function() {
    $('#tableData').dataTable({
      "lengthMenu": [5,10,25,50]
    });
});

$(document).ready(function() {
    $('#tableA').dataTable({
      "lengthMenu": [5,10,25,50]
    });
});

$(document).ready(function() {
    $('#tableB').dataTable({
      "lengthMenu": [5,10,25,50]
    });
});

$(document).ready(function() {
    $('#tableC').dataTable({
      "lengthMenu": [5,10,25,50]
    });
});

$(document).ready(function() {
    $('#tableD').dataTable({
      "lengthMenu": [5,10,25,50]
    });
});

$(document).ready(function() {
    $('#tableE').dataTable({
      "lengthMenu": [5,10,25,50]
    });
});

$(document).ready(function() {
    $('#tableF').dataTable({
      "lengthMenu": [5,10,25,50]
    });
});

$(document).ready(function() {
    $('#tableG').dataTable({
      "lengthMenu": [5,10,25,50]
    });
});

$(document).ready(function() {
    $('#tableH').dataTable({
      "lengthMenu": [5,10,25,50]
    });
});

