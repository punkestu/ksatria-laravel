import './bootstrap';

import AOS from "aos";

window.AOS = AOS;

AOS.init({
    once: false, // animation happens only once
    duration: 800, // animation duration in ms
});