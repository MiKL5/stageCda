import React from "react";
import User from "./User";
import Interventions from "./Interventions";

const InterventionList = () => {
  return (
    <div className="section">
      <div className="section-center">
        <div className="container">
          <User data={window.user} />
          <div>
            <Interventions data={window.user} />
          </div>
        </div>
      </div>
    </div>
  )
}

export default InterventionList;
