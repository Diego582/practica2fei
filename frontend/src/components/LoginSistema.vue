<template>
  <v-app>
    <v-main class="ma-0 pa-0">
      <v-container class="full-height" fluid>
        <v-row justify="center">
          <v-col cols="12" sm="8" md="8">
            <v-card class="elevation-12">
              <v-window v-model="step">
                <v-window-item :value="1">
                  <v-row>
                    <v-col cols="12" md="8">
                      <v-card-text class="mt-12">
                        <h1
                          class="text-center display-4 primary--text text--terciary-3"
                        >
                          CURZA
                        </h1>
                        <h2 class="text-center mlt-4">Iniciar sesión</h2>

                        <v-form
                          v-on:submit.prevent="login"
                          ref="form"
                          v-model="valida"
                          lazy-validation
                        >
                          <v-text-field
                            v-model="form.username"
                            label="Username"
                            name="username"
                            prepend-icon="mdi-account"
                            type="text"
                            color="teal terciary-3"
                            :rules="usernameRules"
                            required
                          />

                          <v-text-field
                            v-model="form.password"
                            label="Password"
                            name="Password"
                            prepend-icon="mdi-lock"
                            color="teal terciary-3"
                            :type="show ? 'text' : 'password'"
                            :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                            @click:append="show = !show"
                            :rules="passRules"
                            required
                          />

                          <v-card-actions class="justify-center">
                            <v-btn
                              type="submit"
                              rounded
                              color="secondary terciary-3"
                              dark
                            >
                              Ingresar</v-btn
                            >
                          </v-card-actions>
                          <h3 class="text-center mt-4">
                            Olvidaste tu contraseña ?
                          </h3>
                        </v-form>
                      </v-card-text>
                    </v-col>
                    <v-col cols="12" md="4" class="primary terciary">
                      <v-card-text class="white--text mt-12">
                        <h1 class="text-center display-1">No tenes Usuario?</h1>
                        <h5 class="text-center">
                          Ingrese sus datos personales y le habilitaremos uno
                          !!!
                        </h5>
                      </v-card-text>
                      <div class="text-center">
                        <v-btn rounded outlined dark @click="step++"
                          >Registrarse</v-btn
                        >
                      </div>
                    </v-col>
                  </v-row>
                </v-window-item>
                <v-window-item :value="2">
                  <v-row class="fill-height">
                    <v-col cols="12" md="4" class="secondary terciary-3">
                      <v-card-text class="white--text mt-12">
                        <h1 class="text-center display-1">Bienvenido!</h1>
                        <h5 class="text-center">
                          Este conectado con nosotros, inicie sesión con su
                          información personal
                        </h5>
                      </v-card-text>
                      <div class="text-center">
                        <v-btn rounded outlined dark @click="step--"
                          >Iniciar</v-btn
                        >
                      </div>
                    </v-col>

                    <v-col cols="12" md="8" m-4>
                      <v-card-text class="mt-12">
                        <h1
                          class="text-center display-2 secondary--text text--terciary-3"
                        >
                          Crear Cuenta
                        </h1>

                        <v-form v-on:submit.prevent="crearUsuario">
                          <v-text-field
                            v-model="username"
                            label="Username"
                            name="Username"
                            prepend-icon="mdi-account"
                            type="text"
                            color="teal terciary-3"
                            :rules="usernameRules"
                            required
                          />
                          <v-text-field
                            v-model="name"
                            label="Nombre"
                            name="Name"
                            prepend-icon="mdi-account"
                            type="text"
                            color="teal terciary-3"
                            :rules="nameRules"
                            required
                          />
                          <v-text-field
                            v-model="apellido"
                            label="Apellido"
                            name="apellido"
                            prepend-icon="mdi-account"
                            type="text"
                            color="teal terciary-3"
                            :rules="apellidoRules"
                            required
                          />
                          <v-text-field
                            v-model="email"
                            label="Correo Electrónico"
                            name="email"
                            prepend-icon="mdi-email"
                            type="text"
                            color="teal terciary-3"
                            :rules="emailRules"
                            required
                          />

                          <v-text-field
                            v-model="password"
                            id="password"
                            label="Contraseña"
                            name="password"
                            prepend-icon="mdi-lock"
                            color="teal terciary-3"
                            :rules="passRules"
                            :type="show ? 'text' : 'password'"
                            :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                            @click:append="show = !show"
                            required
                          />
                          <v-card-actions class="justify-center">
                            <v-btn
                              type="submit"
                              rounded
                              color="primary terciary-3"
                              dark
                              >Registrarse</v-btn
                            >
                          </v-card-actions>
                        </v-form>
                      </v-card-text>
                    </v-col>
                  </v-row>
                </v-window-item>
              </v-window>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import axios from "axios";
import authService from "../services/auth.service";

export default {
  name: "LoginSistema",
  data: () => ({
    step: 1,
    email: "",
    valida: true,
    show: false,
    form: {
      username: "",
      password: "",
    },
    errors: null,
    error: false,
    error_msg: "",
    name: "",
    apellido: "",
    password: "",
    username: "",

    nameRules: [
      (v) => !!v || "Nombre es Requerido",
      (v) => v.length <= 10 || "El nombre no puede exeder 10 carcateres",
    ],
    usernameRules: [
      (v) => !!v || "Nombre de Usuario es Requerido",
      (v) => v.length <= 10 || "El nombre no puede exeder 10 carcateres",
    ],
    apellidoRules: [
      (v) => !!v || "Apellido es Requerido",
      (v) => v.length <= 10 || "El nombre no puede exeder 10 carcateres",
    ],
    passRules: [
      (v) =>
        /^(?=\w*\d)(?=\w*[a-z])\S{8,16}$/.test(v) ||
        "La contraseña es invalida",
    ],
    emailRules: [
      (v) => !!v || "El correo electrónico es requerido",
      (v) => /.+@.+/.test(v) || "Debe ser un correo valido",
    ],
    contVerfRules: [(v) => !!v || "La contraseña es requerida"],
    props: {
      source: String,
    },
  }),
  methods: {
    async login() {
      console.log("Login", this.form);
      const { success, errors } = await authService.login(this.form);
      if (success) {
        this.$router.push({ name: "home" });
      } else {
        this.errors = errors;
      }
    },
  },
  crearUsuario() {
    let json = {
      email: this.email,
      name: this.name,
      apellido: this.apellido,
      password: this.password,
    };
    axios.post("http://127.0.0.1:8000/apiv1/usuario", json).then((data) => {
      console.log(data);
    });
  },
};
</script>
