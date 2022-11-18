import _ from 'lodash';
window._ = _;

import axois from 'axios';
window.axios = axois;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common["Authorization"] = "Bearer " + localStorage.getItem('token');
window.axios.defaults.withCredentials = true;