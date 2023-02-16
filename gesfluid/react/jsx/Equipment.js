import React from "react";
import { useEffect, useState } from "react";
import ax from "./Axios";

const Equipment = (props) => {

  const [equipment, setEquipment] = useState([]);
  useEffect(() => {
    ax.get("/equipment").then((response) => {
      setEquipment(response.data)
    })
  }, [])

  return (
    <div className="form-floating m-2">
      <select
        onChange={(e) => {props.onChange(equipment[e.target.value])}}
        className="form-select form-select-sm"
        id="equipmentLabel"
      >
      <option defaultValue={null}>------</option>
      {
        equipment.map((gear, i) => (
          <option value={i} key={gear.id}>
            {gear.name}
          </option>
        ))
      }
      </select>
      <label htmlFor="equipmentLabel" className="fw-bold">
        <i className="fas fa-gears"></i> Equipement concerné
      </label>
    </div>
  )
}

export default Equipment;
