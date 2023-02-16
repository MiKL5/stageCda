import React from "react";

const DetectorControlDate = (props) => {

  const controlDate = new Date(props.data.controlDate).toLocaleDateString("fr-fr")

  return (
    <div className="form-floating m-2">
      <input
        type="text"
        disabled
        className="border border-0 form-control form-control-sm"
        id="detectorControlDate"
        value={controlDate}
      />
      <label htmlFor="detectorControlDate" className="small fw-bold text-success">
        <i className="fas fa-clipboard-check"></i> Date du dernier contrôle ({props.data.name})
      </label>
    </div>
  )
}

export default DetectorControlDate;
