import axios from "axios";
import env from "react-dotenv";

const headers = {};
const api = axios.create({
    baseURL: env.API_URL,
    timeout: 1000,
    headers: headers
});

export default api;