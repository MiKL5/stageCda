import React from "react";
import { useState } from "react";

const FluidLoading = (props) => {

  const [A, setA] = useState(0);
  const [B, setB] = useState(0);
  const [C, setC] = useState(0);
  const [sumABC, setSumABC] = useState(0);

  const onFluidAChange = (e) => {
    let a = Number(e.target.value);
    setA(a);
    setSumABC(a+B+C);
    props.onAChange(a);
  }

  const onFluidBChange = (e) => {
    let b = Number(e.target.value);
    setB(b);
    setSumABC(A+b+C);
    props.onBChange(b);
  }

  const onFluidCChange = (e) => {
    let c = Number(e.target.value);
    setC(c);
    setSumABC(A+B+c);
    props.onCChange(c);
  }

  return (
    <div className="col-md-6">
      <div className="form-floating m-2">
        <input
          type="number"
          className="border border-0 form-control form-control-sm"
          id="totalLoadedFluidQuantity"
          disabled
          value={sumABC}
        />
        <label htmlFor="totalLoadedFluidQuantity" className="fw-bold text-danger">
          <i className="fas fa-turn-down"></i> Quantité totale chargée <sup>(A+B+C)</sup></label>
      </div>
      <div className="form-floating m-2">
        <input
          type="number"
          className="form-control form-control-sm"
          id="virginFluidQuantity"
          defaultValue="0"
          min="0"
          max={props.capacity}
          onChange={onFluidAChange}
        />
        <label htmlFor="virginFluidQuantity" className="fw-bold">
          <sup>(A)</sup> Dont fluide vierge
        </label>
      </div>
      <div className="form-floating m-2">
        <input
          type="number"
          className="form-control form-control-sm"
          id="recycledFluidQuantity"
          defaultValue="0"
          min="0"
          max={props.capacity}
          onChange={onFluidBChange}
        />
        <label htmlFor="recycledFluidQuantity" className="fw-bold">
          <sup>(B)</sup> Dont fluide recyclé
        </label>
      </div>
      <div className="form-floating m-2">
        <input
          type="number"
          className="form-control form-control-sm"
          id="regeneratedFluidQuantity"
          defaultValue="0"
          min="0"
          max={props.capacity}
          onChange={onFluidCChange}
        />
        <label htmlFor="regeneratedFluidQuantity" className="fw-bold">
          <sup>(C)</sup> Dont fluide régénéré
        </label>
      </div>
    </div>
  )
}

export default FluidLoading;
