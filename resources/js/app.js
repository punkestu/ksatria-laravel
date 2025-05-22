import './bootstrap';

import AOS from "aos";
import jQuery from 'jquery';

window.AOS = AOS;

AOS.init({
    once: false, // animation happens only once
    duration: 800, // animation duration in ms
});

window.$ = jQuery;
window.jQuery = jQuery;
