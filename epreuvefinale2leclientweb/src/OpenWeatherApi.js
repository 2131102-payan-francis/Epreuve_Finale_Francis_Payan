import axios from "axios";

const apiKey = "b9bbeb02c59a475dc1f0ae5845535e96";

const OpenWeatherApi = axios.create({
  baseURL: "https://api.openweathermap.org/data/2.5/",
  params: {
    appid: apiKey,
  },
});

export default OpenWeatherApi;
