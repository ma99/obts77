// import Vue from 'vue'
// import Vuex from 'vuex'

// Vue.use(Vuex);
import { createStore } from 'vuex'

import state from "./state";
import * as getters from './getters';
import * as mutations from "./mutations";
import * as actions from "./actions";

import bus from "./modules/bus";
import driver from "./modules/driver";
import helper from "./modules/helper";
import supervisor from "./modules/supervisor";
import slide from "./modules/slide";
import city from "./modules/city";
import fare from "./modules/fare";
import schedule from "./modules/schedule";
import seatplan from "./modules/seatplan";
import route from "./modules/route";
import stop from "./modules/stop";
import type from "./modules/type";


export const store = createStore({
    state,
    getters,
    mutations,
    actions,

    modules: {
        bus,
        driver,
        helper,
        supervisor,
        slide,
        city,
        fare,
        route,
        schedule,
        seatplan,
        stop,
        type
    }    
});