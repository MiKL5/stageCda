import React from "react";

const FluidDestination = (props) => {

  return (
    <div className="form-outline m-2">
      <label
        className="form-label small"
        htmlFor="collectedFluidDestination"
      >
        Installation prévue de destination du fluide récupéré
      </label>
      <textarea
        rows="4"
        id="collectedFluidDestination"
        className="form-control form-control-sm"
        placeholder="Nom, SIRET, adresse"
        onChange={(e) => {props.onChange(e)}}
      >
      </textarea>
    </div>
  )

}

export default FluidDestination;
