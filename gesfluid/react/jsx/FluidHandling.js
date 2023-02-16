import React from "react";
import { useState } from "react";
import { Tooltip } from "react-tooltip";
import 'react-tooltip/dist/react-tooltip.css';

import FluidLoading from "./FluidLoading";
import FluidCollecting from "./FluidCollecting";

const FluidHandling = (props) => {

  const [fluidQuantities, setFluidQuantities] = useState({
    'A': 0, 'B': 0, 'C': 0, 'D': 0, 'E': 0, 'BSFF': ''
  });

  const [fluidLoading, setFluidLoading] = useState(false);
  const [fluidCollecting, setFluidCollecting] = useState(false);

  const onFluidAChange = (e) => {
    let A = e;
    let fq = {
      ...fluidQuantities,
      A: A
    };
    setFluidQuantities(fq);
    props.onChange(fq);
  }

  const onFluidBChange = (e) => {
    let B = e;
    let fq = {
      ...fluidQuantities,
      B: B
    };
    setFluidQuantities(fq);
    props.onChange(fq);
  }

  const onFluidCChange = (e) => {
    let C = e;
    let fq = {
      ...fluidQuantities,
      C: C
    };
    setFluidQuantities(fq);
    props.onChange(fq);
  }

  const onFluidDChange = (e) => {
    let D = e;
    let fq = {
      ...fluidQuantities,
      D: D
    };
    setFluidQuantities(fq);
    props.onChange(fq);
  }

  const onFluidEChange = (e) => {
    let E = e;
    let fq = {
      ...fluidQuantities,
      E: E
    };
    setFluidQuantities(fq);
    props.onChange(fq);
  }

  const onBsffChange = (e) => {
    let fq = {
      ...fluidQuantities,
      BSFF: e
    };
    setFluidQuantities(fq);
    props.onChange(fq);
  }

  const onLoadingClick = (e) => {
    setFluidLoading(e.target.checked);
    if (!e.target.checked) {
      let fq = {
        ...fluidQuantities,
        A: 0,
        B: 0,
        C: 0,
      }
      setFluidQuantities(fq);
      props.onChange(fq);
    }
  }

  const onCollectingClick = (e) => {
    setFluidCollecting(e.target.checked);
    if (!e.target.checked) {
      let fq = {
        ...fluidQuantities,
        D: 0,
        BSFF: '',
        E: 0,
      }
      setFluidQuantities(fq);
      props.onChange(fq);
    }
  }

  return (
    <div className="container">
      <div className="d-flex bg-secondary text-light rounded mx-auto p-2">
        <div className="me-auto">
          <i className="fas fa-droplet"></i> Manipulation du fluide frigorigène
        </div>
        <div>
          <input className="btn-check" type="checkbox" role="switch" id="loadingFluid" onClick={(e) => {onLoadingClick(e)}} />
          <label
            className="btn border-0 btn-outline-dark btn-sm text-white"
            htmlFor="loadingFluid"
            id="tt-load"
          >
            <i className="fas fa-turn-down"></i>
          </label>
          <Tooltip anchorId="tt-load" content="Chargement" />
        </div>
        <div>
          <input className="btn-check" type="checkbox" role="switch" id="collectingFluid" onClick={(e) => {onCollectingClick(e)}} />
          <label
            className="btn border-0 btn-outline-dark btn-sm text-white"
            htmlFor="collectingFluid"
            id="tt-collect"
          >
            <i className="fas fa-turn-up"></i>
          </label>
          <Tooltip anchorId="tt-collect" content="Récupération" />
        </div>
      </div>
      <div className="d-md-flex flex-md-row justify-content-between">
        { fluidLoading &&
          <FluidLoading
            capacity={props.capacity}
            onAChange={onFluidAChange}
            onBChange={onFluidBChange}
            onCChange={onFluidCChange}
          />
        }
        { fluidCollecting &&
          <FluidCollecting
            capacity={props.capacity}
            onDChange={onFluidDChange}
            onBSFFChange={onBsffChange}
            onEChange={onFluidEChange}
          />
        }
      </div>
    </div>
  )
}

export default FluidHandling;
