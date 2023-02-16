import React from "react";
import { useState } from "react";

const FluidCollecting = (props) => {

  const [D, setD] = useState(0);
  const [E, setE] = useState(0);
  const [sumDE, setSumDE] = useState(0);

  const onFluidDChange = (e) => {
    let d = Number(e.target.value);
    setD(d);
    setSumDE(d+E)
    props.onDChange(d);
  }

  const onBsffChange = (e) => {
    let bsff = e.target.value;
    props.onBSFFChange(bsff);
  }

  const onFluidEChange = (ev) => {
    let e = Number(ev.target.value);
    setE(e);
    setSumDE(D+e);
    props.onEChange(e);
  }

  return (
    <div className="col-md-6">
      <div className="form-floating m-2">
        <input
          type="number"
          className="border border-0 form-control form-control-sm"
          id="totalRetrievedFluidQuantity"
          disabled
          value={sumDE}
        />
        <label htmlFor="totalRetrievedFluidQuantity" className="fw-bold text-danger">
          <i className="fas fa-turn-up"></i> Quantité totale récupérée <sup>(D+E)</sup></label>
      </div>
      <div className="form-floating m-2">
        <input
          type="number"
          className="form-control form-control-sm"
          id="forProcessingFluidQuantity"
          defaultValue="0"
          min="0"
          max={props.capacity}
          onChange={onFluidDChange}
        />
        <label htmlFor="forProcessingFluidQuantity" className="fw-bold">
          <sup>(D)</sup> Dont fluide destiné au traitement
        </label>
      </div>
      <div className="form-floating m-2">
        <input
          type="text"
          className="form-control form-control-sm"
          id="bsffNumber"
          onChange={onBsffChange}
        />
        <label htmlFor="bsffNumber" className="fw-bold">
          Numéro du BSFF (si connu)
        </label>
      </div>
      <div className="form-floating m-2">
        <input
          type="number"
          className="form-control form-control-sm"
          id="reusableFluidQuantity"
          defaultValue="0"
          min="0"
          max={props.capacity}
          onChange={onFluidEChange}
        />
        <label htmlFor="reusableFluidQuantity" className="fw-bold">
          <sup>(E)</sup> Dont fluide conservé pour réutilisation
        </label>
      </div>
    </div>
  )
}

export default FluidCollecting;
