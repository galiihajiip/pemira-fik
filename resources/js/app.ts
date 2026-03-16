import "../css/app.css";
import "./bootstrap";
import BackgroundMusic from "./components/BackgroundMusic.vue";
import OceanDecor from "./components/OceanDecor.vue";

import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createApp, DefineComponent, h } from "vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>("./pages/**/*.vue"),
        ),
    setup({ el, App, props, plugin }) {
        createApp({
            render: () =>
                h("div", { class: "app-shell" }, [
                    h(OceanDecor),
                    h(BackgroundMusic),
                    h("div", { class: "app-content" }, [h(App, props)]),
                ]),
        })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: "#f97316",
    },
});
