import Vue from "vue";

import Vuetify from "vuetify";
import "@mdi/font/css/materialdesignicons.css";
import "vuetify/dist/vuetify.min.css";

import hu from "vuetify/es5/locale/hu";

Vue.use(Vuetify);

const theme = {
    ...window.Theme
};

const options = {
    icons: {
        iconfont: "mdi"
    },
    theme: {
        themes: {
            light: theme,
            dark: theme
        },
        dark: false
    },
    rtl: false,
    lang: {
        locales: {
            hu
        },
        current: "hu"
    }
};

export default new Vuetify(options);
