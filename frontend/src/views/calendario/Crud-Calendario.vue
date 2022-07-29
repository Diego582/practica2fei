<template>
  <v-container fluid grid-list-lg text-lg-left>
    <v-data-table
      :headers="headers"
      :items="calendarios"
      sort-by="calendario"
      class="elevation-1"
      :search="search"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Aprobacion y Carga Calendario </v-toolbar-title>
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
                      <v-select
                        v-model="editedItemCompartido.id"
                        label="Reservas de Aulas"
                        :items="reservas"
                        :hint="`${editedItemCompartido.id.id}, ${editedItemCompartido.id.observacion}`"
                        item-text="observacion"
                        item-value="id"
                        single-line
                      ></v-select>
                      <v-text-field
                        v-model="editedItem.start"
                        label="Desde"
                        type="datetime-local"
                      ></v-text-field>
                      <v-text-field
                        v-model="editedItem.end"
                        label="Hasta"
                        type="datetime-local"
                      ></v-text-field>
                      <v-text-field
                        v-model="editedItem.color"
                        label="Color"
                        type="color"
                      ></v-text-field>
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
    <CalendarioReserva></CalendarioReserva>
  </v-container>
</template>

<script>
import axios from "axios";
import CalendarioReserva from "@/components/CalendarioReserva.vue";

export default {
  name: "CrudCalendario",
  data() {
    return {
      calendario: "",
      url: "",
      errors: "",
      dialog: false,
      dialogDelete: false,
      search: "",
      profesores: "",
      headers: [
        { text: "Nro de Reserva", value: "id" },
        { text: "Descripcion", value: "name" },
        { text: "Fecha Desde", value: "start" },
        { text: "Fecha Hasta", value: "end" },
        { text: "Color", value: "color" },
        { text: "Detalle", value: "details" },
        { text: "Actions", value: "actions", sortable: false },
      ],
      calendarios: [],
      reservas: [],
      editedIndex: -1,
      editedItem: {
        id: "",
        name: "",
        start: "",
        end: "",
        color: "",
      },
      defaultItem: {
        id: "",
        name: "",
        start: "",
        end: "",
        color: "",
      },
      editedItemCompartido: {
        id: "",
        id_calendario: "",
        id_reserva: "",
        details: "",
      },
      inicio: "",
      currentlyEditing: null,
    };
  },
  mounted() {
    this.listarCalendarios();
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
      this.editedIndex = this.calendarios.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },
    deleteItem(item) {
      this.editedIndex = this.calendarios.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
      this.axiosDelete(item);
    },
    deleteItemConfirm() {
      this.calendarios.splice(this.editedIndex, 1);
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
      let url = "http://127.0.0.1:8000/apiv1/calendario";
      if (this.editedIndex > -1) {
        axios.put(url + "/" + this.editedItem.id, this.editedItem);
        Object.assign(this.calendarios[this.editedIndex], this.editedItem);
      } else {
        axios
          .post(url, this.editedItem)
          .then((response) => {
            this.editedItem = response.data;
            this.calendarios.push(this.editedItem);
          })
          .catch((e) => {
            this.errors = e;
            // Capturamos los errores
          });
      }
      this.close();
    },
    async listarCalendarios() {
      await this.axios
        .get("apiv1/calendario")
        .then((response) => {
          this.calendarios = response.data;
          //solicitamos los datos a la api
        })
        .catch((e) => {
          this.errors = e;
          // Capturamos los errores
        });
    },
    async axiosDelete(item) {
      await this.axios.delete("apiv1/calendario/" + item.id).catch((e) => {
        this.errors = e;
        // Capturamos los errores
      });
    },
    crearCalendario() {
      /*  console.log("ingreso calendario al crear", this.calendarios);
      const name = "prueba1";
      const start = this.calendarios.start;
      const end = this.calendarios.end;
      const color = this.calendarios.color;
      const contador = 4;

      for (let i = 0; i < contador; i++) {
        this.editedItem.name = name;
        this.editedItem.start = start;
        this.editedItem.end = end;
        this.editedItem.color = color;
        console.log("despues del for", this.editedItem);
        this.calendarios.push({
          name: name,
          start: start,
          end: end,
          color: color,
        });
      } */
    },
  },
  components: { CalendarioReserva },
};
</script>
