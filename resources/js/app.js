import "./bootstrap";
import shoppingCart from "./shoppingCart.js";
// Core Js
import jQuery from "jquery";
window.$ = jQuery;
window.jQuery = jQuery;

import "tw-elements";

import SimpleBar from "simplebar";
window.SimpleBar = SimpleBar;
import "simplebar/dist/simplebar.css";

// animate css
import "animate.css";

// You will need a ResizeObserver polyfill for browsers that don't support it! (iOS Safari, Edge, ...)
import ResizeObserver from "resize-observer-polyfill";
window.ResizeObserver = ResizeObserver;

import leaflet from "leaflet";
window.leaflet = leaflet;

import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
window.Calendar = Calendar;
window.dayGridPlugin = dayGridPlugin;
window.timeGridPlugin = timeGridPlugin;
window.listPlugin = listPlugin;

import Cleave from "cleave.js";
window.Cleave = Cleave;



import * as Chart from "chart.js";
window.Chart = Chart;
import ApexCharts from "apexcharts";
window.ApexCharts = ApexCharts;

import "country-select-js";

// Drag and Drop for kenban
import dragula from "dragula/dist/dragula";
import "dragula/dist/dragula.css";
window.dragula = dragula;

// Icon
import "iconify-icon";

// SweetAlert
import Swal from "sweetalert2";
window.Swal = Swal;

// tooltip and popover
import tippy from "tippy.js";
import "tippy.js/dist/tippy.css";
window.tippy = tippy;


// DATA-TABLE
import DataTable from "datatables.net-dt";
window.DataTable = DataTable;

// OWL CAROUSEL
// import 'owl.carousel/dist/assets/owl.carousel.css';
// import 'owl.carousel';
import cleave from 'cleave.js'
window.cleave = cleave;


// jQuery validation
import validate from "jquery-validation";
window.validate = validate;

import.meta.glob(["../images/**"]);

// Vue Component
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import { createApp } from 'vue';
import { VueSignaturePad } from 'vue-signature-pad';
import TermsAndConditionForm from '../js/components/TermsAndConditionForm.vue';
import 'gasparesganga-jquery-loading-overlay';
import Editor from '@tinymce/tinymce-vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

app.config.globalProperties.$cart = new shoppingCart();


import CustomerForm from '../js/components/CustomerForm.vue';
import LocationCategories from '../js/components/LocationCategories.vue';
import FamilyMemberForm from '../js/components/FamilyMemberForm.vue';
import TicketForm from '../js/components/TicketForm.vue';
import TermsAndCondition from '../js/components/TermsConditions.vue';
import HomeSlider from '../js/components/HomeSlider.vue';
import LocationModal from '../js/components/modals/LocationModal.vue';
import CheckoutCart from '../js/components/CheckoutCart.vue';

app.component('customer-form', CustomerForm);
app.component('ticket-form', TicketForm);
app.component('family-member-form', FamilyMemberForm);
app.component('location-categories', LocationCategories);
app.component('terms-conditions', TermsAndCondition);
app.component('location-modal', LocationModal);
app.component('home-slider', HomeSlider);
app.component('checkout-cart', CheckoutCart);


//booking section
//parties
import BookingParties from '../js/components/booking/Parties.vue';
app.component('booking-parties', BookingParties);
//groups
import BookingGroups from '../js/components/booking/Groups.vue';
app.component('booking-groups', BookingGroups);
//memberships
import Memberships from '../js/components/booking/Memberships.vue';
app.component('booking-memberships', Memberships);

import Events from '../js/components/booking/Events.vue';
app.component('booking-events', Events);

import Camp from '../js/components/CampForm.vue';
app.component('booking-camp', Camp);

import PackageOptions from '../js/components/booking/PackageOptions.vue';
app.component('package-options', PackageOptions);
import Plans from '../js/components/booking/Plans.vue';
app.component('booking-plans', PackageOptions);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
app.component("VueSignaturePad", VueSignaturePad);
app.component("editor", Editor);
app.component('terms-and-condition-form', TermsAndConditionForm);
app.mount('#app');

const globalSearchApp = createApp({});

import GlobalSearch from '../js/components/GlobalSearch.vue';
globalSearchApp.component('global-search', GlobalSearch);

globalSearchApp.mount('#global-search-app');



//custom js


