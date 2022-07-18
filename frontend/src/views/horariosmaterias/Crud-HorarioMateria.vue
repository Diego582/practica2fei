<template>
  <v-container fluid grid-list-lg text-lg-left>
    <v-data-table
      :headers="headers"
      :items="desserts"
      sort-by="horarioMaterias"
      class="elevation-1"
      :search="search"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title> Horario Materias</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
          <v-divider class="mx-4" inset vertical></v-divider>

          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                New Item
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">{{ formTitle }}</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="8" md="6">
                      <v-text-field
                        v-model="editedItem.nombre"
                        label="Nombre"
                      ></v-text-field>
                      <v-text-field
                        v-model="editedItem.cant_alumnos"
                        label="Cantidad de Alumnos"
                      ></v-text-field>
                      <v-select
                        v-model="editedItem.id_carrera"
                        label="Carrera"
                        :items="carreras"
                        :hint="`${editedItem.id_carrera.id}, ${editedItem.id_carrera.nombre}`"
                        item-text="nombre"
                        item-value="id"
                        single-line
                      ></v-select>
                      <v-select
                        v-model="editedItem.id_profesor"
                        label="Profesor"
                        :items="profesores"
                        :hint="`${editedItem.id_profesor.id}, ${editedItem.id_profesor.nombre}`"
                        item-text="nombre"
                        item-value="id"
                        single-line
                      ></v-select>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="warning" text @click="close"> Cancelar </v-btn>
                <v-btn color="success" text @click="save"> Guardar </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="text-h5"
                >Estas seguro de ELIMINAR este item?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="warning" text @click="closeDelete">Cancel</v-btn>
                <v-btn color="success" text @click="deleteItemConfirm"
                  >OK</v-btn
                >
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
        <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
import axios from "axios";

export default {
  name: "CrudHorarioMateria",

  data() {
    return {
      horarioMaterias: "",
      url: "",
      errors: "",
      dialog: false,
      dialogDelete: false,
      search: "",
      carreras: "",
      profesores: "",
      headers: [
        { text: "Nombre", value: "nombre" },
        { text: "Cantidad de Alumnos", value: "cant_alumnos" },
        { text: "Carrera", value: "id_carrera" },
        { text: "Profesor", value: "id_profesor" },
        { text: "Actions", value: "actions", sortable: false },
      ],
      desserts: [],
      editedIndex: -1,
      editedItem: {
        id: "",
        nombre: "",
        cant_alumnos: "",
        id_carrera: "",
        id_profesor: "",
      },
      defaultItem: {
        id: "",
        nombre: "",
        cant_alumnos: "",
        id_carrera: "",
        id_profesor: "",
      },
    };
  },
  mounted() {
    let url = "http://127.0.0.1:8000/apiv1/materia";

    axios
      .get(url)
      .then((response) => {
        this.desserts = response.data;
        //solicitamos los datos a la api
      })
      .catch((e) => {
        this.errors = e;
        // Capturamos los errores
      });

    axios
      .get("http://127.0.0.1:8000/apiv1/carrera")
      .then((response) => {
        this.carreras = response.data;
        //solicitamos los datos a la api
      })
      .catch((e) => {
        this.errors = e;
        // Capturamos los errores
      });

    axios
      .get("http://127.0.0.1:8000/apiv1/profesor")
      .then((response) => {
        this.profesores = response.data;
        //solicitamos los datos a la api
      })
      .catch((e) => {
        this.errors = e;
        // Capturamos los errores
      });
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo Item" : "Editar Item";
    },
  },
  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
      let url = "http://127.0.0.1:8000/apiv1/materia";

      axios
        .get(url)
        .then((response) => {
          this.desserts = response.data;
          //solicitamos los datos a la api
        })
        .catch((e) => {
          this.errors = e;
          // Capturamos los errores
        });
    },
    editItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },
    deleteItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
      axios.delete("http://127.0.0.1:8000/apiv1/materia/" + item.id);
    },
    deleteItemConfirm() {
      this.desserts.splice(this.editedIndex, 1);
      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },
    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },
    save() {
      let url = "http://127.0.0.1:8000/apiv1/materia";
      if (this.editedIndex > -1) {
        axios.put(url + "/" + this.editedItem.id, this.editedItem);
        Object.assign(this.desserts[this.editedIndex], this.editedItem);
      } else {
        this.desserts.push(this.editedItem);
        axios
          .post(url, this.editedItem)
          .then(function (response) {
            console.log("respuestadelPost", response);
            console.log("envio a Guardar", this.editItem);
          })
          .catch(function (error) {
            this.errors = error;
            console.log(error);
          });
      }
      this.close();
    },
  },
};
</script>
