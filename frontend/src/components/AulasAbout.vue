<template>
  <div>
    <MainBarMenu></MainBarMenu>
    <v-container>
      <h1>Esto es about</h1>
    </v-container>
  </div>
</template>

<script>
import MainBarMenu from "./MainBarMenu.vue";
export default {
  name: "AulasAbout",
  components: { MainBarMenu },
};
</script>
