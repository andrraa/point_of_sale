// AXIOS
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// JQUERY
import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

// SWEETALERT2
import Swal from 'sweetalert2';
window.Swal = Swal;

// SELECT2
import select2 from 'select2';
select2();