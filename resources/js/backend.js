var $ = window.$ = window.jQuery = require('jquery');
var DataTable = require('datatables.net');

require('datatables.net-bs');
require( 'datatables.net-buttons' );
require( 'datatables.net-responsive' );
require('bootstrap');
require('../gentelella/js/custom');
require('../gentelella/js/helpers/smartresize');
require('select2');

$.fn.dataTable = DataTable;
$.fn.dataTableSettings = DataTable.settings;
$.fn.dataTableExt = DataTable.ext;

DataTable.$ = $;

$.fn.DataTable = function ( opts ) {
  return $(this).dataTable( opts ).api();
};