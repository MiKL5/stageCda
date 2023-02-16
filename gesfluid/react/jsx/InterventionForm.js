import React from "react";
import { useState, useEffect } from "react";
import User from "./User";
import Detectors from "./Detectors";
import DetectorControlDate from "./DetectorControlDate"
import Equipment from "./Equipment";
import InterventionTypes from "./InterventionTypes";
import OtherType from "./OtherType";
import Leakage from "./Leakage";
import Containers from "./Containers";
import EquipmentDetails from "./EquipmentDetails";
import FluidHandling from "./FluidHandling";
import Wastes from "./Wastes";
import FluidDestination from "./FluidDestination";
import Remarks from "./Remarks";

import ax from "./Axios";

const InterventionForm = () => {

  // Current date
  const date = new Date();
  date.setDate(date.getDate());
  const now = date.toLocaleDateString("fr-CA");
  
  // States

  const [interventionDate, setInterventionDate] = useState(now);
  const [equipment, setEquipment] = useState(null);
  const [type, setType] = useState(null);
  const [otherType, setOtherType] = useState("");

  // Intervention type is 5 or 6
  const [leakControl, setLeakControl] = useState(false);

  // Intervention type is not 5 and not 6
  // Leak control is mandatory after an intervention
  const [mandatoryLeakControl, setMandatoryLeakControl] = useState(false);

  // Detector used for leakage control
  const [detector, setDetector] = useState(null);
  const [leakLocations, setLeakLocations] = useState([]);
  const [leakFixed, setLeakFixed] = useState([]);

  // Fluid quantities
  const [fluidQuantities, setFluidQuantities] = useState({
    'A': 0, 'B': 0, 'C': 0, 'D': 0, 'E': 0, 'BSFF': ''
  });

  const [container, setContainer] = useState(null);
  const [fluidDestination, setFluidDestination] = useState("");
  const [remarks, setRemarks] = useState("");
  const [pdfPath, setPdfPath] = useState("");
  const [leaksPosted, setLeaksPosted] = useState(false);

  // In case of input error → used to disable submit button
  const [formError, setFormError] = useState(false);

  useEffect(() => {
    if (leaksPosted) {
      window.open(pdfPath, '_blank');
      window.location.reload();
    } else {
      // check for form errors here
      if (!equipment)
        setFormError(true);
      else if (!type)
        setFormError(true);
      else if (type.id != 5 && type.id != 6 && checkFluidHandling())
        setFormError(true);
      else if (((fluidQuantities.D > 0) || (fluidQuantities.E > 0)) && !container)
        setFormError(true);
      else if (!equipment.leakDetectionSystem && !detector)
        setFormError(true);
      else if (type.id === 8 && !otherType)
        setFormError(true)
      else if (checkLeaks())
        setFormError(true);
      else
        setFormError(false);
    }
  });


  // Check fluid quantities conformity
  // A B C must be a positive number if loadingFluid is true
  // D or E must be a positive number if collectingFluid is true
  // A B C must be less or equal than equipment capacity
  // D or E must be less or equal than equipment capacity
  //
  // Return true if there is an error
  const checkFluidHandling = () => {
    let q = fluidQuantities;
    let d = fluidDestination;
    let w = equipment.weight;
    let tAbc = q.A + q.B + q.C;
    let tDe = q.D + q.E;
    
    if (q.D > 0 && !d)
      return true
    else if (tAbc <= 0 && tDe <= 0)
      return true
    else if (q.D > 0 && q.E > 0)
      return true
    else if (q.A > w || q.B > w || q.C > w)
      return true
    else if (q.D > w || q.E > w)
      return true
    else if (tAbc > w || tDe > w)
      return true
    else
      return false
  }

  const checkLeaks = () => {
    let l = leakLocations;
    if (l.length === 0)
      return false;
    for (let i = 0; i < l.length; i++) {
      if (!l[i])
        return true;
    }
    return false;
  }

  // Events
  
  const onInterventionDateChange = (e) => {
    setInterventionDate(e.target.value);
  }

  const onEquipmentChange = (e) => {
    handleReset();
    setEquipment(e);
  }

  const onTypeChange = (e) => {
    if (!e) {
      setLeakControl(false);
      setMandatoryLeakControl(false);
    }
    else {
     setLeakControl((e.id === 5 || e.id === 6));
     setMandatoryLeakControl((e.id !== 5 && e.id !== 6))
    }

    setType(e);
    setDetector(null);
  }

  const onOtherTypeChange = (e) => {
    setOtherType(e.target.value);
  }

  const onDetectorChange = (e) => {
    setDetector(e);
  }

  const onLeakLocationChange = (e) => {
    setLeakLocations(e);
  }

  const onLeakFixedChange = (e) => {
    setLeakFixed(e);
  }

  const onFluidQuantitiesChange = (e) => {
    let sumABC = e.A + e.B + e.C;
    let sumDE = e.D + e.B;
    setFormError(isNaN(sumABC) || isNaN(sumDE));
    setFluidQuantities(e);
  }

  const onContainerChange = (e) => {
    setContainer(e);
  }

  const onFluidDestinationChange = (e) => {
    setFluidDestination(e.target.value);
  }

  const onRemarksChange = (e) => {
    setRemarks(e.target.value);
  }

  const postLeaks = async (interventionID) => {
    // POST leaks one by one
    let count = leakLocations.length;
    for (let i = 0;  i < count;  i++) {
      let leak = {
        "num": i+1,
        "count": count,
        "location": leakLocations[i],
        "fixed": leakFixed[i],
        "intervention": "/api/interventions/" + interventionID,
      }

      await ax.post('/leakages',
        leak
      )
      .catch((error) => {
        console.log('ERROR leakage POST', error);
        return
      });
    }
    setLeaksPosted(true);
  }

  const handleSubmit = (e) => {
    e.preventDefault();
    let intervention = {
      "date": interventionDate,
      "virginFluidQuantity": fluidQuantities.A,
      "recycledFluidQuantity": fluidQuantities.B,
      "regeneratedFluidQuantity": fluidQuantities.C,
      "forProcessingFluidQuantity": fluidQuantities.D,
      "bsffNumber": fluidQuantities.BSFF,
      "reusableFluidQuantity": fluidQuantities.E,
      "collectedFluidDestination": fluidDestination,
      "remarks": remarks,
      "interventionType": "/api/intervention_types/" + type.id,
      "otherInterventionType": otherType,
      "equipment": "/api/equipment/" + equipment.id,
      "container": container?"/api/containers/" + container.id:null,
      "accessory": detector?"/api/accessories/" + detector.id:null,
      "leaks": leakLocations.length > 0,
      "user": "/api/users/" + window.user,
      "pdfPath": "",
    };

    // POST intervention
    ax.post('/interventions',
      intervention
    )
    .then((response) => {
      // POST leaks
      postLeaks(response.data.id);
      setPdfPath(response.data.pdfPath);
    })
    .catch((error) => {
      console.log('ERROR', error);
    });
  }

  const handleReset = () => {
    setEquipment(null);
    setType(null);
    setOtherType("");
    setLeakControl(false);
    setMandatoryLeakControl(false);
    setDetector(null);
    setLeakLocations([]);
    setLeakFixed([]);
    setFluidQuantities({ 'A': 0, 'B': 0, 'C': 0, 'D': 0, 'E': 0, 'BSFF': ''});
    setContainer(null);
    setFluidDestination("");
    setRemarks("");
    setPdfPath("");
    setLeaksPosted(false);
    setFormError(false);
  }

  // Collected fluid will be installed in another equipment
  const mustInstall = () => {
    return fluidQuantities.D > 0;
  }

  return (
    <div className="section">
      <div className="section-center">
        <div className="container">
          <User data={window.user} />
          <div>
            <div className="form-floating m-2">
              <input
                type="date"
                id="interventionDate"
                className="form-control form-control-sm"
                defaultValue={now}
                onChange={onInterventionDateChange}
              />
              <label htmlFor="interventionDate" className="fw-bold">
               <i className="fas fa-calendar-days"></i> Date de l'intervention
              </label>
            </div>
            <Equipment onChange={onEquipmentChange} />
            { equipment &&
              <>
                <EquipmentDetails data={equipment} />
                <InterventionTypes onChange={onTypeChange} data={equipment.id} />
              </>
            }
            { type?.id === 8  &&
                <OtherType onChange={onOtherTypeChange} />
            }
            { equipment && type && !leakControl &&
              <>
                <FluidHandling
                  capacity={equipment.weight}
                  onChange={onFluidQuantitiesChange}
                />
                {
                  (mustInstall() || fluidQuantities.E > 0) &&
                    <Containers
                      data={equipment.fluid}
                      onChange={onContainerChange}
                    />
                }

                { fluidQuantities.D > 0 &&
                  <Wastes data={equipment.fluid.fluidType}/>
                }
              </>
            }

            { mustInstall() &&
                <FluidDestination onChange={onFluidDestinationChange} />
            }

            { type && !equipment?.leakDetectionSystem &&
              <>
                <Detectors data={type.id} onChange={onDetectorChange} />
                {  detector &&
                  <DetectorControlDate data={detector} />
                }
              </>
            }
           
            { (leakControl || mandatoryLeakControl) &&
                <Leakage
                  data={type?.id}
                  onLocationChange={onLeakLocationChange}
                  onFixedChange={onLeakFixedChange}
                />
            }
            

            { equipment &&
              <Remarks onChange={onRemarksChange} />                
            }
            
            <div className="d-flex d-flex-row align-items-center justify-content-between m-2">
              <div>
                <button className="btn btn-sm btn-warning" type="reset" onClick={() => {window.location.reload()}}>Annuler</button>
              </div>
              <div>
                <button
                  className="btn btn-sm btn-danger"
                  type="submit"
                  disabled={formError}
                  onClick={handleSubmit}
                >
                  Enregistrer
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default InterventionForm;
