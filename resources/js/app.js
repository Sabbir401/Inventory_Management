import "./bootstrap";

import { createApp } from "vue";

import router from "./router.js";

import app from "./layouts/app.vue";
import store from "./store/index.js";

createApp(app).use(router).use(store).mount("#app");
