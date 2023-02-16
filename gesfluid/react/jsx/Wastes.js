import React from "react";

const Wastes = (props) => {

  return (
    <div className="container">
      <div className="my-2 bg-secondary p-2 rounded">
        <div className="text-light">
          <i className="fas fa-dumpster"></i> Dénomination ADR/RID
        </div>
      </div>
      <div>
        {props.data.flammable &&
          <div className="border border-0 rounded-0" disabled>
            <i className="fas fa-dumpster-fire"></i> {props.data.name}
          </div>
        }
        {props.data.flammable ||
          <div className="border border-0 rounded-0" disabled>
            <i className="fas fa-dumpster"></i> {props.data.name}
          </div>
        }
      </div>
    <hr />
    </div>
  )
}

export default Wastes;
