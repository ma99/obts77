require('./bootstrap');

import { createApp } from 'vue';
import { router } from './router';
import { store } from './store/index';

// import { tns } from "./node_modules/tiny-slider/src/tiny-slider";
// import { tns } from 'tiny-slider/src/tiny-slider';

// const app = createApp(App).use(router)
// app.mount('#app')


// import ExampleComponent from './components/ExampleComponent.vue';
// import Dashboard from './views/dashboard/Main';

// createApp({
// 	components: {
// 		'example-component': ExampleComponent,
// 		// 'component-b': ComponentB
// 	}
// }).mount('#app');

const app = createApp({});

app.component('csrf-token', require('./components/CsrfToken.vue').default);
app.component('example-component', require('./components/ExampleComponent.vue').default);
app.component('example-event', require('./components/ExampleEvent.vue').default);
app.component('App', require('./views/App').default);
app.component('Dashboard', require('./views/dashboard/Main').default);
app.component('seat-display', require('./components/SeatDisplay.vue').default);
// app.component('seat-layout', require('./components/SeatLayout.vue').default);
// app.component('modal', require('./components/Modal.vue').default);
// app.component('app-modal', require('./components/AppModal.vue').default);
app.component('show-alert', require('./components/Alert.vue').default);
app.component('high-light', require('./components/Highlighter.vue').default);
app.component('loader', require('./components/Loader.vue').default);
app.component('expand', require('./components/ExpandButton.vue').default);
app.component('add-section', require('./components/AddSection.vue').default);
app.component('border', require('./components/Border.vue').default);
app.component('autocomplete', require('./components/Autocomplete.vue').default);
app.component('stops-map', require('./components/stops/StopsMap.vue').default);
app.component('header-icon', require('./components/HeaderIcon.vue').default);
app.component('discount', require('./components/Discount.vue').default);

app.use(router)
	.use(store)
	.mount('#app');