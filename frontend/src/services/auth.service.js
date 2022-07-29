import axios from "axios";

const authService = {
  usuario: null,
  async login(formData) {
    try {
      const { status, data } = await axios.post(
        "http://localhost:8000/apiv1/usuario/login",
        formData
      );
      console.log("Status", status);
      console.log("data", data);
      if (status === 200) {
        this.setUser(data);
        return { success: true };
      }
    } catch (e) {
      return {
        success: false,
        errors: e,
      };
    }
  },
  setUser(usuario) {
    this.usuario = usuario;
    localStorage.setItem("ACCESS_TOKEN", usuario.access_token);
  },
  isLoggedIn() {
    return !!localStorage.getItem("ACCESS_TOKEN");
  },
  getToken() {
    return localStorage.getItem("ACCESS_TOKEN");
  },
};

export default authService;
