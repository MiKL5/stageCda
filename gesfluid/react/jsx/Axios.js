import axios from "axios";

// Create an axios object with default headers
const ax = axios.create({
  baseURL: "/api",
  headers: {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Access-Control-Allow-Origin": "*",
  },
});

// Catch unauthorized request and redirect if error
ax.interceptors.response.use((response) => response, (error) => {
  if (error.response.status === 401) {
    window.location = '/login';
  }
});

export default ax;
