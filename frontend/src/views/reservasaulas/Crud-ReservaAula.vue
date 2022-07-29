<template>
  <v-container fluid grid-list-lg text-lg-left>
    <v-data-table
      :headers="headers"
      :items="reservas"
      sort-by="reservaAula"
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
          <v-toolbar-title>Reserva Aula</v-toolbar-title>
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
                        v-model="editedItem.id_aula"
                        label="Aulas"
                        :items="aulas"
                        :hint="`${editedItem.id_aula.id}, ${editedItem.id_aula.descripcion}`"
                        item-text="descripcion"
                        item-value="id"
                        single-line
                      ></v-select>
                      <v-text-field
                        v-model="editedItem.fh_desde"
                        label="Desde"
                        type="datetime-local"
                      ></v-text-field>
                      <v-text-field
                        v-model="editedItem.fh_hasta"
                        label="Hasta"
                        type="datetime-local"
                      ></v-text-field>
                      <v-text-field
                        v-model="editedItem.observacion"
                        label="Observacion"
                        type="text"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="error" text @click="close"> Cancelar </v-btn>
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
                <v-btn color="error" text @click="closeDelete">Cancel</v-btn>
                <v-btn color="success" text @click="deleteItemConfirm"
                  >OK</v-btn
                >
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>

          <!-- ESTE ES EL MODAL DE PROCESAMIENTO -->
          <v-dialog v-model="dialog2" max-width="500px">
            <v-card>
              <v-card-title>
                <span class="text-h5">Procesar Reserva</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="8" md="6">
                      <v-text-field
                        v-model="editedItem.id"
                        label="Id Reserva"
                        type="text"
                        readonly
                      ></v-text-field>

                      <v-select
                        v-model="editedItem.id_aula"
                        label="Aulas"
                        :items="aulas"
                        :hint="`${editedItem.id_aula.id}, ${editedItem.id_aula.descripcion}`"
                        item-text="descripcion"
                        item-value="id"
                        readonly
                        single-line
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="8" md="6">
                      <v-text-field
                        v-model="editedItem.fh_desde"
                        label="Desde"
                        type="datetime-local"
                        readonly
                      ></v-text-field>
                      <v-text-field
                        v-model="editedItem.fh_hasta"
                        label="Hasta"
                        type="datetime-local"
                        readonly
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="12" md="12">
                      <v-text-field
                        v-model="editedItem.observacion"
                        label="Observacion"
                        type="text"
                        readonly
                      ></v-text-field>
                    </v-col>
                  </v-row>

                  <v-row>
                    <v-col cols="12" sm="12" md="12">
                      <v-card-subtitle class="ma-0 pa-0 text-center">
                        <span class="text-h10">Opciones</span>
                      </v-card-subtitle>
                      <v-text-field
                        v-model="editedItem.color"
                        label="Color"
                        type="color"
                      ></v-text-field>
                      <v-text-field
                        v-model="editedItem.detail"
                        label="Detalle del Proceso"
                        type="text"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="warning" text @click="close"> Cancelar </v-btn>
                <v-btn color="success" text @click="generar"> Aprobar </v-btn>
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

        <v-icon color="tertiary" small class="mr-2" @click="procesarItem(item)">
          mdi-check-underline-circle
        </v-icon>
      </template>
    </v-data-table>
    <CalendarioReserva></CalendarioReserva>
  </v-container>
</template>

<script>
import CalendarioReserva from "@/components/CalendarioReserva.vue";

export default {
  name: "CrudReservaAula",
  data() {
    return {
      reservaAula: "",
      url: "",
      errors: "",
      dialog: false,
      dialog2: false,
      dialogDelete: false,
      search: "",
      aulas: "",
      profesores: "",
      headers: [
        { text: "Nro de Reserva", value: "id" },
        { text: "Aula", value: "id_aula" },
        { text: "Fecha Desde", value: "fh_desde" },
        { text: "Fecha Hasta", value: "fh_hasta" },
        { text: "Observaciones", value: "observacion" },
        { text: "Actions", value: "actions", sortable: false },
      ],
      reservas: [],
      editedIndex: -1,
      editedItem: {
        id: "",
        id_aula: "",
        fh_desde: "",
        fh_hasta: "",
        observacion: "",
        id_usuario: 1,
      },
      defaultItem: {
        id: "",
        id_aula: "",
        fh_desde: "",
        fh_hasta: "",
        observacion: "",
        id_usuario: 1,
      },
      crearCalendario: {
        id: "",
        name: "",
        start: "",
        end: "",
        color: "",
        details: "",
      },
      calendarios: [],
      relaciones: {
        id_calendario: "",
        id_reserva: "",
      },
    };
  },
  mounted() {
    this.listarReservas(), this.listarAulas();
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
      this.editedIndex = this.reservas.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },
    procesarItem(item) {
      this.editedIndex = this.reservas.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog2 = true; // cambiar a otro modal
    },
    deleteItem(item) {
      this.editedIndex = this.reservas.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },
    deleteItemConfirm() {
      this.reservas.splice(this.editedIndex, 1);
      this.axiosDelete(this.editedItem);
      this.closeDelete();
    },
    close() {
      this.dialog = false;
      this.dialog2 = false;
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
        Object.assign(this.reservas[this.editedIndex], this.editedItem);
      } else {
        this.axiosCreate();
      }
      this.close();
    },

    async listarReservas() {
      await this.axios
        .get("apiv1/reservaaula")
        .then((response) => {
          this.reservas = response.data;
          //solicitamos los datos a la api
        })
        .catch((e) => {
          this.errors = e;
          // Capturamos los errores
        });
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
      await this.axios.delete("apiv1/reservaaula/" + item.id).catch((e) => {
        this.errors = e;
        // Capturamos los errores
      });
    },
    async axiosCreate() {
      await this.axios
        .post("apiv1/reservaaula", this.editedItem)
        .then((response) => {
          this.editedItem = response.data;
          this.reservas.push(this.editedItem);
        })
        .catch((e) => {
          this.errors = e;
          // Capturamos los errores
        });
    },
    async axiosCreateCalendario(itemCalendario, idReserva) {
      let itemVinculado = [];
      itemVinculado.id_reserva = idReserva;

      await this.axios
        .post("apiv1/calendario", itemCalendario)
        .then((response) => {
          this.calendarios.push(response.data);
          itemVinculado.id_calendario = response.data.id;
        })
        .catch((e) => {
          this.errors = e;
          // Capturamos los errores
        });
      this.relaciones = Object.assign({}, itemVinculado);

      await this.axios
        .post("apiv1/calendarioreserva", this.relaciones)
        .then((response) => {
          this.calendarios.push(response.data);
        })
        .catch((e) => {
          this.errors = e;
          // Capturamos los errores
        });
    },

    async axiosUpdate() {
      await this.axios
        .put("apiv1/reservaaula/" + this.editedItem.id, this.editedItem)
        .catch((e) => {
          this.errors = e;
          // Capturamos los errores
        });
    },
    generar() {
      let fechaDesde = Date.parse(this.editedItem.fh_desde);
      let fechaHasta = Date.parse(this.editedItem.fh_hasta);
      let fechaInicial = new Date(fechaDesde);
      let fechaFinal = new Date(fechaHasta);
      let nombre = this.editedItem.observacion;
      let color = this.editedItem.color;
      let fechaFinCalendario = Date.parse(
        new Date(
          fechaInicial.getFullYear(),
          fechaInicial.getMonth(),
          fechaInicial.getDate(),
          fechaFinal.getHours(),
          fechaFinal.getMinutes(),
          fechaFinal.getSeconds()
        )
      );
      let detalle = this.editedItem.detail;
      let fechaIni = fechaDesde;
      let itemCalendario = [];
      for (let i = fechaDesde; i < fechaHasta; i++) {
        itemCalendario.name = nombre;
        itemCalendario.start = new Date(fechaIni);
        itemCalendario.end = new Date(fechaFinCalendario);
        itemCalendario.color = color;
        itemCalendario.details = detalle;
        i = i + 604800000;
        this.crearCalendario = Object.assign({}, itemCalendario);

        /*  console.log("despues del for detalle", this.crearCalendario.detail); */

        /* this.calendarios.push({
          name: nombre,
          start: fechaInicial,
          end: fechaFinal,
          color: color,
        }); */
        this.axiosCreateCalendario(this.crearCalendario, this.editedItem.id);

        fechaIni = parseInt(fechaIni) + 604800000;
        fechaFinCalendario = fechaFinCalendario + 604800000;
      }

      /* const difIncial =
        (parseInt(fechaFinal) - parseInt(fechaInicial)) / 86400000;
      const semana = fechaInicial + 604800000;
      const fechadate = new Date(fechaInicial);
      const horaInicial = fechadate.getHours();

      const semanadate = new Date(semana);

      console.log("esto es fecha Inicial con date", fechaInicial);
      console.log("esto es fecha Final con date", fechaFinal);
      console.log("esto es fecha Inicial SIN date", fechaDesde);
      console.log("esto es fecha Final SIN date", fechaHasta);
      console.log("esto es semana", semana);
      console.log("esto es desde con New date", fechadate);
      console.log("esto es semana con New date", semanadate);
      console.log("esto es semana diferencia Inicial", difIncial);
      console.log("esto es la hora Inicial con date", horaInicial);

      console.log("esto es nombre", nombre); */
      this.close();
    },
  },
  components: { CalendarioReserva },
};
</script>
