import React from "react";
import { useEffect, useState } from "react";
import ax from "./Axios";

const Detectors = (props) => {

  const [detectors, setDetectors] = useState([]);
  useEffect(() => {
    ax.get("/detectors").then((response) => {
      setDetectors(response.data);
    })
  }, [])

  return (
    <div className="form-floating m-2">
      <select
        key={props.data}
        onChange={(e) => {props.onChange(detectors[e.target.value])}}
        className="form-select form-select-sm"
        id="detectorLabel"
      >
      <option defaultValue={null}>------</option>
      {
        detectors.map((detector, i) => (
          <option value={i} key={detector.id}>
            {detector.name}
          </option>
        ))
      }
      </select>
      <label htmlFor="detectorLabel" className="fw-bold">
        <i className="fas fa-compass"></i> Détecteur de fuites
      </label>
    </div>
  )
}

export default Detectors;
