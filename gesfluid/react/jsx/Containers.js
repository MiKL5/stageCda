import React from "react";
import { useEffect, useState } from "react";
import ax from "./Axios";

const Containers = (props) => {
  
  const [containers, setContainers] = useState([]);
  useEffect(() => {
    ax.get('/containersByFluid/' + props.data.id).then((response) => {
      setContainers(response.data);
    })
  }, [props.data])

  return (
    <div className="container">
      <div className="form-floating m-1">
        <select
          onChange={(e) => {props.onChange(containers[e.target.value])}}
          className="form-select form-select-sm"
          id="containerLabel"
        >
        <option defaultValue={null}>------</option>
        {
          containers.map((container, i) => (
            <option value={i} key={container.id}>
              {container.serialNumber}{/* -- {container.fluidQuantity.toFixed(2)}/{container.capacity.toFixed(2)} */}
            </option>
          ))
        }
        </select>
        <label htmlFor="containerLabel" className="fw-bold">
          <i className="fas fa-bottle-droplet"></i> Contenant
        </label>
      </div>
    </div>
  )
}

export default Containers;
