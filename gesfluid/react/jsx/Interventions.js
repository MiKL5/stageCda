import React, {useState, useEffect} from "react";
import ax from "./Axios";

const Interventions = (props) => {

  const [loading, setLoading] = useState(true);

  const [interventions, setInterventions] = useState([]);
  useEffect(() => {
    ax.get("/interventionsByUser/" + props.data)
      .then((response) => {
        setInterventions(response.data);
        setLoading(false);
      })
      .catch((error) => {
        console.log(error);
        setInterventions([]);
    })
  }, [props.data]);

  if (loading)
    return (
      <div className="container">
        <div className="spinner-border spinner-border-sm text-secondary m-2" role="status">
          <span className="visually-hidden">Chargement...</span>
        </div>
      </div>
    );

  if (interventions.length === 0) {
    return (
      <div className="container">
       <i className="fas fa-circle-xmark"></i><span className="small"> Pas d'intervention trouvée</span> 
      </div>
    )
  }

  return (
    <ul className="list-group list-group-flush">
    {
      interventions.map((intervention, i) => (
      
        <li className="list-group-item small" key={i}>
          {/* TODO: Display intervention type and equipment name */}
          <i className="fas fa-screwdriver"></i> <span>{new Date(intervention.date).toLocaleDateString('fr-CA')}</span> {intervention.interventionType.name} {intervention.equipment.name}<a href={intervention.pdfPath} target="_blank">PDF</a>
        </li>
      ))
    }
    </ul>
  )

}

export default Interventions;
