import React from "react";
import { useEffect, useState } from "react";
import ax from "./Axios";

const InterventionTypes = (props) => {

  const [types, setTypes] = useState([]);
  useEffect(() => {
    ax.get('/intervention_types').then((response) => {
      setTypes(response.data);
    })
  }, [])

  return (
    <div className="form-floating m-2">
      <select
        key={props.data} // reset if equipment changed
        onChange={(e) => {props.onChange(types[e.target.value])}}
        className="form-select form-select-sm"
        id="typeLabel"
      >
      <option defaultValue={null}>------</option>
      {
        types.map((type, i) => (
          <option value={i} key={type.id}>
            {type.name}
          </option>
        ))
      }
      </select>
      <label htmlFor="typeLabel" className="fw-bold">
        <i className="fas fa-screwdriver-wrench"></i> Nature de l'intervention
      </label>
    </div>
  )
}

export default InterventionTypes;
