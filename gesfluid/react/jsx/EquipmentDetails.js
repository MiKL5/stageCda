import React from "react";

const EquipmentDetails = (props) => {

  return (
    <div className="container mt-1 mb-1">
      <div className="d-md-flex flex-md-row justify-content-between">
        <div className="form-floating flex-xl-fill">
          <input
            type="text"
            disabled
            className="border border-0 form-control form-control-sm rounded-0"
            id="equipmentName"
            value={props.data.name}
          />
          <label htmlFor="equipmentName" className="small fw-bold text-success">
            <i className="fas fa-tag"></i> Identification
          </label>
        </div>
        <div className="form-floating flex-xl-fill">
          <input
            type="text"
            disabled
            className="border border-0 form-control form-control-sm rounded-0"
            id="fluidName"
            value={props.data.fluid.name}
          />
          <label htmlFor="fluidName" className="small fw-bold text-success">
            <i className="fas fa-droplet"></i> Dénomination du fluide
          </label>
        </div>
        <div className="form-floating flex-xl-fill">
          <input
            type="text"
            disabled
            className="border border-0 form-control form-control-sm rounded-0"
            id="fluidQuantity"
            value={props.data.weight.toFixed(2)}
          />
          <label htmlFor="fluidQuantity" className="small fw-bold text-success">
            <i className="fas fa-weight-hanging"></i> Charge totale (kg)
          </label>
        </div>
         <div className="form-floating flex-xl-fill">
          <input
            type="text"
            disabled
            className="border border-0 form-control form-control-sm rounded-0"
            id="fluidCO2"
            value={props.data.co2EqTonnage.toFixed(2)} 
          />
          <label htmlFor="fluidCO2" className="small fw-bold text-success">
            <i className="fas fa-cloud"></i> Tonnage équivalent C0<sub>2</sub>
          </label>
        </div>
      </div>
      <div className="form-check form-switch mt-1">
        <input
          type="checkbox"
          disabled
          className="form-check-input"
          role="switch"
          id="leakDetectionSystem"
          checked={props.data.leakDetectionSystem}
        />
        <label htmlFor="leakDetectionSystem" className="small fw-bold text-success">
          <i className="fas fa-wind"></i> Présence d'un système permanent de détection de fuites
        </label>
      </div>
    </div>
  )
}

export default EquipmentDetails;
