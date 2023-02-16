import React from "react";
import { createRoot } from "react-dom/client";
// import "./css/index.css";

import App from "./jsx/App";

const container = document.getElementById("root");

if (container) {
  const root = createRoot(container);

  root.render(
    <div className="container mt-2">
      <React.StrictMode>
        <App />
      </React.StrictMode>
    </div>
);
}
