import "./bootstrap";
import * as Charts from "./chart";

import AOS from "aos";
import jQuery from "jquery";
import ApexCharts from "apexcharts";
import ApexTree from "apextree";
import MicroModal from "micromodal";
import * as Fullcalendar from "fullcalendar";

window.AOS = AOS;
window.ApexCharts = ApexCharts;
window.ApexTree = ApexTree;
window.Charts = Charts;
window.MicroModal = MicroModal;
window.FullCalendar = Fullcalendar;

MicroModal.init();

AOS.init({
    once: false, // animation happens only once
    duration: 800, // animation duration in ms
});

window.$ = jQuery;
window.jQuery = jQuery;

window.isTokenValid = () => {
    if (
        localStorage.getItem("sync_token") &&
        localStorage.getItem("sync_token_expiry")
    ) {
        const expiry = new Date(localStorage.getItem("sync_token_expiry"));
        if (expiry > new Date()) {
            return true;
        }
    }

    return false;
};

window.syncToken = async () => {
    if (window.isTokenValid()) {
        return;
    }
    await $.ajax({
        url: $('meta[name="sync-token-url"]').attr("content"),
        type: "GET",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            Accept: "application/json",
        },
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            localStorage.setItem("sync_token", response.token);
            localStorage.setItem("sync_token_expiry", response.expires_at);
        },
        error: function () {
            alert("An error occurred while fetching the token.");
        },
    });
};
