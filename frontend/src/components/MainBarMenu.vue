<template>
  <v-container>
    <v-app-bar app elevation="4" color="primary">
      <v-app-bar-nav-icon @click="drawer = true" dark></v-app-bar-nav-icon>
      <v-spacer></v-spacer>
      <v-app-bar-title class="white--text">Aulas Curza</v-app-bar-title>
      <v-spacer></v-spacer>
      <v-btn small text fab>
        <v-icon color="white">mdi-cog-outline</v-icon>
      </v-btn>
      <v-btn small text fab @click="logout">
        <v-icon color="white">mdi-exit-to-app</v-icon>
      </v-btn>
    </v-app-bar>

    <v-navigation-drawer app v-model="drawer" temporary color="tertiary">
      <v-list-item>
        <v-img
          alt="Aulas Logo"
          class="shrink mr-2"
          contain
          :src="require('../assets/logo.png')"
          transition="scale-transition"
          width="50"
        />
        <v-list-item-content>
          <v-list-item-title class="text-center text-h6">
            Aulas CURZA
          </v-list-item-title>
          <v-list-item-subtitle class="text-center text-h6">
            FeI
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
      <v-divider></v-divider>
      <v-list-item-title class="text-center text-h7"> Menu </v-list-item-title>
      <v-divider></v-divider>
      <v-list dense>
        <v-list-item v-for="item in items" :key="item.title" :to="item.to" link>
          <v-list-item-icon>
            <v-icon color="primary">{{ item.icon }}</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="text-h8">{{
              item.title
            }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
  </v-container>
</template>

<script>
export default {
  name: "MainBarMenu",
  data: () => ({
    drawer: false,
    items: [
      { title: "Home", icon: "mdi-home", to: "/" },
      { title: "Carrera", icon: "mdi-account-school", to: "/carrera" },
      { title: "Profesor", icon: "mdi-account-tie", to: "/profesor" },
      { title: "Materia", icon: "mdi-form-select", to: "/materia" },
      { title: "Aula", icon: "mdi-home-import-outline", to: "/aula" },
      {
        title: "Reservar Aula",
        icon: " mdi-clipboard-clock",
        to: "/reservaaula",
      },
      {
        title: "Horario Materia",
        icon: "mdi-clock-check",
        to: "/horariomateria",
      },

      { title: "About", icon: "mdi-all-inclusive-box", to: "/about" },
    ],
  }),
  methods: {
    logout() {
      console.log("Logout...");
    },
  },
};
</script>
