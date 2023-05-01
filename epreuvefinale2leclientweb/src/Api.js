import axios from "axios";

// Entrez votre clé API ici
const apiKey = "apikey1";

const Api = axios.create({
  baseURL: "http://127.0.0.1/Epreuve_Finale_(base_ex04)",
  headers: {
    Authorization: "Bearer " + apiKey,
  },
});

export default Api;