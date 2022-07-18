import authService from "@/services/auth.service";
import Vue from "vue";
import VueRouter from "vue-router";
import AulasHome from "../components/AulasHome";
import LoginSistema from "../components/LoginSistema";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "Default",
    redirect: "/home",
    component: AulasHome,
  },
  {
    path: "/auth",
    name: "auth",
    component: LoginSistema,
    children: [
      {
        path: "login",
        name: "login",
        component: LoginSistema,
      },
    ],
  },
  {
    path: "/home",
    name: "home",
    component: AulasHome,
  },
  {
    path: "/about",
    name: "about",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(/* webpackChunkName: "about" */ "../components/AulasAbout.vue"),
  },
  {
    path: "/carrera",
    name: "ListarCarreras",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */ "../views/carreras/Crud-Carrera.vue"
      ),
  },
  {
    path: "/profesor",
    name: "ListarProfesores",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */ "../views/profesores/Crud-Profesor.vue"
      ),
  },
  {
    path: "/materia",
    name: "ListarMaterias",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */ "../views/materias/Crud-Materia.vue"
      ),
  },
  {
    path: "/horariomateria",
    name: "ListarHorarioMaterias",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */ "../views/horariosmaterias/Crud-HorarioMateria.vue"
      ),
  },
  {
    path: "/aula",
    name: "ListarAulas",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */ "../views/aulas/Crud-Aula.vue"
      ),
  },
  {
    path: "/reservaaula",
    name: "ListarReservasAulas",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(
        /* webpackChunkName: "about" */ "../views/reservasaulas/Crud-ReservaAula.vue"
      ),
  },
];

// eslint-disable-next-line no-new
const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

router.beforeEach((to, from, next) => {
  console.log(to, from);
  if (to.name === "home" && !authService.isLoggedIn()) {
    next({ name: "login" });
  } else if (authService.isLoggedIn() && to.name !== "home") {
    next({ name: "home" });
  } else {
    next();
  }
});

export default router;
