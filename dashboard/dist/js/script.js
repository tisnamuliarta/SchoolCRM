$(function() {
    // change active
    //Date picker
    $('.getDatePicker').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      endDate: '0d',
    });
    $('.displayDatePicker').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      endDate: '0d',
    });

    // active link
    // var url = window.location;
    // $('ul.treeview-menu li a[href="' + url + '"]').parent().parent().parent().addClass('active');
    // $('li a[href="' + url + '"]').parent().addClass('active');
});