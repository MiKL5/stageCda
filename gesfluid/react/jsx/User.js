import React from "react";
import { useEffect, useState } from "react";
import ax from "./Axios";

const User = (props) => {

  const [user, setUser] = useState("");
  useEffect(() => {
    ax.get('/users/' + props.data).then((response) => {
      setUser(response.data);
    })
  }, [props.data])

  return (
    <div className="mx-2 me-2 bg-secondary p-2 rounded">
      <div className="text-light">
        <i className="fas fa-user"></i> {user.firstName} {user.lastName}
      </div>
    </div>
  )
}

export default User;
