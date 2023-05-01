// App.js
import React, { useState } from "react";
import "./App.css";
import Authentification from "./Authentification";
import GestionDonnees from "../src/GestionDonnees";

const App = () => {
  const [currentPage, setCurrentPage] = useState("gestionDonnees");

  const goToAuthentification = () => {
    setCurrentPage("authentification");
  };

  const goToGestionDonnees = () => {
    setCurrentPage("gestionDonnees");
  };

  return (
    <div className="App">
      {currentPage === "gestionDonnees" && (
        <>
          <GestionDonnees goToAuthentification={goToAuthentification} />
        </>
      )}
      {currentPage === "authentification" && (
        <>
          <Authentification />
          <button className="button3" onClick={goToGestionDonnees}>
            Retour
          </button>
        </>
      )}
    </div>
  );
};

export default App;
