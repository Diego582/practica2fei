<template>
  <v-container fluid grid-list-lg text-lg-left>
    <v-data-table
      :headers="headers"
      :items="aulas"
      sort-by="aula"
      class="elevation-1"
      :search="search"
    >
      <template v-slot:no-data>
        <v-alert :value="true" color="warning" icon="warning">
          <span
            ><v-icon large>mdi-emoticon-confused-outline</v-icon>Lamentamos
            informar que no tienes Datos Cargados
          </span>
        </v-alert>
      </template>
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Aulas</v-toolbar-title>
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
                        v-model="editedItem.descripcion"
                        label="Descripcion"
                      ></v-text-field>
                      <v-text-field
                        v-model="editedItem.ubicacion"
                        label="Ubicacion"
                      ></v-text-field>
                      <v-text-field
                        v-model="editedItem.cant_proyector"
                        label="Cantidad Proyector"
                        type="number"
                      ></v-text-field>
                      <v-text-field
                        v-model="editedItem.aforo"
                        label="Aforo"
                      ></v-text-field>
                      <v-switch
                        v-model="editedItem.es_climatizada"
                        :input-value="editedItem.es_climatizada"
                        @change="(value) => changeState(value)"
                        :label="`Es climatizada `"
                      ></v-switch>
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
        <v-icon color="primary" small class="mr-2" @click="editItem(item)">
          mdi-pencil
        </v-icon>
        <v-icon color="error" small class="mr-2" @click="deleteItem(item)">
          mdi-delete
        </v-icon>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
export default {
  name: "CrudCarrera",

  data() {
    return {
      aula: "",
      url: "",
      errors: "",
      dialog: false,
      dialogDelete: false,
      search: "",
      headers: [
        { text: "Descripcion", value: "descripcion" },
        { text: "Ubicacion", value: "ubicacion" },
        { text: "Proyectores", value: "cant_proyector" },
        { text: "Aforo", value: "aforo" },
        { text: "Climatizada", value: "es_climatizada" },
        { text: "Actions", value: "actions", sortable: false },
      ],
      aulas: [],
      editedIndex: -1,
      editedItem: {
        descripcion: "",
        ubicacion: "",
        cant_proyector: "",
        aforo: "",
        es_climatizada: "",
      },
      defaultItem: {
        descripcion: "",
        ubicacion: "",
        cant_proyector: "",
        aforo: "",
        es_climatizada: "",
      },
    };
  },
  mounted() {
    this.listarAulas();
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
    initialize() {},
    editItem(item) {
      this.editedIndex = this.aulas.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },
    deleteItem(item) {
      this.editedIndex = this.aulas.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },
    deleteItemConfirm() {
      this.aulas.splice(this.editedIndex, 1);
      this.axiosDelete(this.editedItem);
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
      if (this.editedIndex > -1) {
        this.axiosUpdate();
        Object.assign(this.aulas[this.editedIndex], this.editedItem);
      } else {
        this.axiosCreate();
      }
      this.close();
    },
    // funcion para el swicth
    changeState(valor) {
      this.editedItem.es_climatizada = valor;
    },
    async listarAulas() {
      await this.axios
        .get("apiv1/aula")
        .then((response) => {
          this.aulas = response.data;
          //solicitamos los datos a la api
        })
        .catch((e) => {
          this.errors = e;
          // Capturamos los errores
        });
    },
    async axiosDelete(item) {
      await this.axios.delete("apiv1/aula/" + item.id).catch((e) => {
        this.errors = e;
        // Capturamos los errores
      });
    },
    async axiosCreate() {
      await this.axios
        .post("apiv1/aula", this.editedItem)
        .then((response) => {
          this.editedItem = response.data;
          this.aulas.push(this.editedItem);
        })
        .catch((e) => {
          this.errors = e;
          // Capturamos los errores
        });
    },
    async axiosUpdate() {
      await this.axios
        .put("apiv1/aula/" + this.editedItem.id, this.editedItem)
        .catch((e) => {
          this.errors = e;
          // Capturamos los errores
        });
    },
  },
};
</script>
