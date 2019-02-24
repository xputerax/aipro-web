try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    // window.PNotify = require('pnotify');

    window.PNotify = require('pnotify/dist/pnotify')
    require('pnotify/dist/pnotify.buttons')
    require('pnotify/dist/pnotify.nonblock')
    require('bootstrap');
    // window.$.fn.DataTable = require('datatables.net/js/jquery.dataTables');
    // window.$.fn.DataTable = require('datatables.net-bs/js/dataTables.bootstrap');

    // require('datatables.net');
    // window.datatables = require('datatables.net-bs');

    // require('fastclick/lib/fastclick');
    // require('nprogress/nprogress');
    // require('icheck/icheck');
    // require('pnotify/src/pnotify');
    // require('pnotify/src/pnotify.buttons');
    // require('pnotify/src/pnotify.nonblock');
    require('../gentelella/js/custom');

    // require('bootstrap-progressbar/bootstrap-progressbar');
    require('../gentelella/js/helpers/smartresize');

    // require('datatables.net-bs/js/dataTables.bootstrap');
    // require('datatables.net-buttons/js/dataTables.buttons');
    // require('datatables.net-buttons/js/buttons.flash');
    // require('datatables.net-buttons/js/buttons.html5');
    // require('datatables.net-buttons/js/buttons.print');
    // require('datatables.net-buttons-bs/js/buttons.bootstrap');
    // require('datatables.net-fixedheader/js/dataTables.fixedHeader');
    // require('datatables.net-keytable/js/dataTables.keyTable');
    // require('datatables.net-responsive/js/dataTables.responsive');
    // require('datatables.net-responsive-bs/js/responsive.bootstrap');
    // require('datatables.net-scroller/js/dataTables.scroller');

    // require('jszip/dist/jszip');
    // require('pdfmake/build/pdfmake');
    // require('pdfmake/build/vfs_fonts');

    require('select2');

} catch (e) {

}
