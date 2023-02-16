import React from "react";

const Remarks = (props) => {

  return (
    <div className="form-outline m-2">
      <label
        className="form-label small"
        htmlFor="remarks"
      >
        Observations
      </label>
      <textarea
        rows="4"
        id="remarks"
        className="form-control form-control-sm"
        onChange={(e) => {props.onChange(e)}}
      >
      </textarea>
    </div>
  )
}

export default Remarks;
