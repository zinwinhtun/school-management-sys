import 'bootstrap';
import 'bootstrap-icons/font/bootstrap-icons.css';
import toastr from 'toastr';
import 'toastr/build/toastr.css';
import { Chart, registerables } from 'chart.js';


// Toastr configuration
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

Chart.register(...registerables);

window.toastr = toastr;
window.Chart = Chart;


