import axios from "axios";

const authService = {
  usuario: null,
  async login(formData) {
    try {
      const { status, data } = await axios.post(
        "http://localhost:8000/apiv1/usuario/login",
        formData
      );
      if (status === 200) {
        this.setUser(data);
        return { success: true };
      }
    } catch (e) {
      return {
        success: false,
        /* errors: e.response.data.errors, */
      };
    }
  },
  setUser(usuario) {
    this.usuario = usuario;
    localStorage.setItem("ACCESS_TOKEN".usuario.access_token);
  },
  isLoggedIn() {
    return !!localStorage.getItem("ACCESS_TOKEN");
  },
};

export default authService;
