// src/Authentification.js
import React, { useState } from "react";
// import GestionDonnees from "./GestionDonnees";
import GestionDonnees from "../src/GestionDonnees";
import Api from "../src/Api";

const Authentification = () => {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");
  const [apiKey, setApiKey] = useState("");
  const [loggedIn, setLoggedIn] = useState(false);

  const login = () => {
    Api({
      method: "post",
      url: "/login",
      data: {
        username: username,
        password: password,
      },      
    })
      .then((reponse) => {
        setApiKey(reponse.data.api_key);
        setLoggedIn(true);
      })
      .catch((erreur) => {
        console.log(erreur);
      });
  };

  const genererNouvelleCle = () => {
    Api({
      method: "post",
      url: "/login",
      data: {
        username: username,
        password: password,
      },
    })
      .then((reponse) => {
        setApiKey(reponse.data.api_key);
      })
      .catch((erreur) => {
        console.log(erreur);
      });
  };

  return (
    <div>
      <h1>Authentification</h1>
      {!loggedIn && (
        <div>
          <input
            className="input"
            type="text"
            placeholder="Code usager"
            value={username}
            onChange={(e) => setUsername(e.target.value)}
          />
          <input
            className="input"
            type="password"
            placeholder="Mot de passe"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
          />
          <button className="button3" onClick={login}>
            Afficher ma clé API
          </button>
        </div>
      )}
      {loggedIn && (
        <div>
          <div className="apiKeyContainer">
            Votre clé API: <strong>{apiKey}</strong>
          </div>
          <button className="button3" onClick={genererNouvelleCle}>
            Générer une nouvelle clé API
          </button>
          <GestionDonnees />
        </div>
      )}
    </div>
  );
};

export default Authentification;
