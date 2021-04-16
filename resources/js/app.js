import $ from 'jquery';
import flatpickr from "flatpickr"
import 'jquery-ui/ui/widgets/datepicker.js';

window.$ = window.jQuery = $;
window.Popper = require('popper.js').default;
require('./bootstrap');

window.flatpickr = flatpickr

require( 'datatables.net' );
require( 'datatables.net-bs' );


