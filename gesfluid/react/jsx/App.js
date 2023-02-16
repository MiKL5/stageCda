import React from "react";

import InterventionForm from "./InterventionForm";
import InterventionList from "./InterventionList";

const App = () => {

  return (
    <React.StrictMode>
    {
      window.location.pathname === '/' &&
        <InterventionList />
    }
    { 
      window.location.pathname !== '/' &&
        <InterventionForm />
    }
    </React.StrictMode>
  )
}

export default App;
