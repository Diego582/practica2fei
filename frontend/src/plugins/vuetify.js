import Vue from "vue";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";

Vue.use(Vuetify);

export default new Vuetify({
  icons: {
    iconfont: "mdi",
  },
  theme: {
    options: {
      customProperties: true,
    },
    themes: {
      light: {
        primary: "#1E88E5",
        secondary: "#A67830",
        tertiary: "#F2C377",
        accent: "#1BFAEC",
        error: "#FB795A",
        info: "#FAA41B",
        success: "#12E39A",
        warning: "#C70B02",
        purple: "#0FFA66",
      },
    },
  },
});
