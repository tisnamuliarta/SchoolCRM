$(function() {
    // change active
    //Date picker
    $('.getDatePicker').datepicker({
      todayBtn: 'linked',
      autoclose: true,
      format: 'yyyy-mm-dd'
    });
    $('.displayDatePicker').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    });

    // active link
    // var url = window.location;
    // $('ul.treeview-menu li a[href="' + url + '"]').parent().parent().parent().addClass('active');
    // $('li a[href="' + url + '"]').parent().addClass('active');
});