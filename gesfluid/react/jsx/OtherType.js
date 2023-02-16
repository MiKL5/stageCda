import React from "react";

// Input text for "other" intervention type
const OtherType = (props) => {
  
  return (
    <div className="m-2">
      <input
        type="text"
        className="form-control form-control-sm"
        id="otherInterventionType"
        placeholder="Veuillez préciser le type d'intervention..."
        onChange={(e) => {props.onChange(e)}}
        autoFocus
      />
    </div>
  )
}

export default OtherType;
