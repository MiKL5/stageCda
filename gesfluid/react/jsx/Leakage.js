import React from "react";
import { useState } from "react";
import { Tooltip } from "react-tooltip";
import 'react-tooltip/dist/react-tooltip.css';

const Leak = (props) => {

  return (
    <>
      <span className="input-group-text border border-0 bg-secondary text-light rounded me-2">{props.id+1}</span>
      <input
        key={props.data}
        type="text"
        id={props.id}
        className="form-control form-control-sm border border-0 ml-2 me-2"
        onChange={(e) => {props.onChange(e)}}
        placeholder="Localisation de la fuite"
        autoFocus
      />
    </>
  )
}

const Leakage = (props) => {

  const [leakComponents, setLeakComponents] = useState([]);
  const [locations, setLocations] = useState([]);
  const [fixed, setFixed] = useState([]);

  const addLeak = () => {
    let index = leakComponents.length;

    setLeakComponents([
      ...leakComponents,
      <Leak data={props.data} id={index} onChange={onLeakChange} />
    ]);

    let locationsCopy = [...locations, ""];
    let fixedCopy = [...fixed];
    fixedCopy.push(false);
    setLocations(locationsCopy);
    setFixed(fixedCopy);
    props.onLocationChange(locationsCopy);
    props.onFixedChange(fixedCopy);
  }

  const removeLeak = (e) => {
    let index = e.target.id - 20;
    let leakComponentsCopy = [...leakComponents];
    let locationsCopy = [...locations];
    let fixedCopy = [...fixed]
    leakComponentsCopy.splice(index, 1);
    locationsCopy.splice(index, 1);
    fixedCopy.splice(index, 1);
    setLeakComponents(leakComponentsCopy);
    setLocations(locationsCopy);
    setFixed(fixedCopy);
    props.onLocationChange(locationsCopy);
    props.onFixedChange(fixedCopy);
  }

  const onLeakChange = (e) => {
    let index = e.target.id;
    let locationsCopy = [...locations];
    locationsCopy[index] = e.target.value;
    setLocations(locationsCopy);
    props.onLocationChange(locationsCopy);
  }

  const onLeakFixed = (e) => {
    let index = e.target.id - 10;
    let fixedCopy = [...fixed];
    fixedCopy[index] = e.target.checked;
    setFixed(fixedCopy);
    props.onFixedChange(fixedCopy);
  }

  return (
    <div className="container">
      <div className="d-flex d-flex-row justify-content-between align-items-center my-2 bg-secondary p-2 rounded">
        <div className="text-light">
          <i className="fas fa-wind"></i> Fuites constatées lors du contrôle d'étanchéité
        </div>
  
        <button
          type="button"
          className="btn btn-sm btn-outline-light"
          onClick={addLeak}
          disabled={leakComponents.length === 3}
        >
          <i className="fas fa-plus"></i> Ajouter
        </button>
      </div>
      { leakComponents.length > 0 &&
        <fieldset className="m-2 border border-1 rounded">
        {
          leakComponents.map((leak, i) => (
            <div key={i} className="input-group m-2 d-flex d-flex-row align-items-center justify-content-even">
              {leak}
              <input
                type="checkbox"
                className="btn-check"
                id={10+i}
                autoComplete="off"
                onClick={onLeakFixed}
              />
              <label id="tt-wrench" htmlFor={10+i} className="btn btn-outline-secondary border border-0 rounded">
                <i className="fas fa-wrench"></i>
              </label>
              <Tooltip anchorId="tt-wrench" content="Fuite réparée" />
              <button
                type="button"
                id={20+i}
                className="btn-close me-3 rounded-circle"
                onClick={removeLeak}
                aria-label="Close"
                disabled={i+1 < leakComponents.length}
              >
              </button>
            </div>
          ))
        }
        </fieldset>
      }
    </div>
  )
}

export default Leakage;
