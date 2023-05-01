import React, { useState, useEffect } from "react";
import Api from "../src/Api";
import OpenWeatherApi from "../src/OpenWeatherApi";
import "./GestionDonnees.css";
import Modal from "react-modal";

//import Authentification from "./Authentification";

Modal.setAppElement("#root");

const GestionDonnees = ({ goToAuthentification }) => {
  const [contacts, setContacts] = useState([]);
  const [ville, setVille] = useState("");
  const [meteo, setMeteo] = useState(null);

  // Nouveaux états pour gérer les actions
  const [nom, setNom] = useState("");
  const [prenom, setPrenom] = useState("");
  const [email, setEmail] = useState("");
  const [message, setMessage] = useState("");
  const [contactId, setContactId] = useState("");

  // États pour gérer l'ouverture des modals
  const [modalAjouterOuvert, setModalAjouterOuvert] = useState(false);
  const [modalModifierOuvert, setModalModifierOuvert] = useState(false);

  // Fonctions pour gérer l'ouverture et la fermeture des modals
  const ouvrirModalAjouter = () => {
    setModalAjouterOuvert(true);
  };

  const fermerModalAjouter = () => {
    setModalAjouterOuvert(false);
  };

  const ouvrirModalModifier = () => {
    setModalModifierOuvert(true);
  };

  const fermerModalModifier = () => {
    setModalModifierOuvert(false);
  };

  useEffect(() => {
    recupererContacts();
  }, []);

  const recupererContacts = () => {
    Api({
      method: "get",
      url: "/contacts/lister",
    })
      .then((reponse) => {
        setContacts(reponse.data);
      })
      .catch((erreur) => {
        console.log(erreur);
      });
  };

  const ajouterContact = (contact) => {
    Api({
      method: "post",
      url: "/contacts/ajouter",
      data: contact,
    })
      .then((reponse) => {
        recupererContacts();
      })
      .catch((erreur) => {
        console.log(erreur);
      });
  };

  const mettreAJourContact = (id, contact) => {
    Api({
      method: "put",
      url: `/contacts/mettreajour/${id}`,
      data: contact,
    })
      .then((reponse) => {
        recupererContacts();
      })
      .catch((erreur) => {
        console.log(erreur);
      });
  };

  const supprimerContact = (id) => {
    Api({
      method: "delete",
      url: `/contacts/supprimer/${id}`,
    })
      .then((reponse) => {
        recupererContacts();
      })
      .catch((erreur) => {
        console.log(erreur);
      });
  };

  const recupererMeteo = () => {
    OpenWeatherApi({
      method: "get",
      url: "weather",
      params: {
        q: ville,
        units: "metric",
      },
    })
      .then((reponse) => {
        setMeteo(reponse.data);
      })
      .catch((erreur) => {
        console.log(erreur);
      });
  };

  return (
    <div className="container">
        <div className="title-container">
    <h1 className="title">Epreuve Finale - Service Web</h1>
    <h2 className="name">Francis Payan</h2>
  </div>
  <button className="button3" onClick={goToAuthentification}>
        Authentification
  </button>
  <div className="content">
    <div className="part">
      <h2>Ajouter un contact</h2>
      <button className="button3" onClick={ouvrirModalAjouter}>
        Ajouter un contact
      </button>
      <Modal isOpen={modalAjouterOuvert} onRequestClose={fermerModalAjouter}>
        <div className="modal-content">
          <h2>Ajouter un contact</h2>
          <input
            className="input"
            type="text"
            placeholder="Nom"
            value={nom}
            onChange={(e) => setNom(e.target.value)}
          />
          <input
            className="input"
            type="text"
            placeholder="Prénom"
            value={prenom}
            onChange={(e) => setPrenom(e.target.value)}
          />
          <input
            className="input"
            type="text"
            placeholder="Email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
          />
          <input
            className="input"
            type="text"
            placeholder="Message"
            value={message}
            onChange={(e) => setMessage(e.target.value)}
          />
          <button
            className="button3"
            onClick={() => {
              ajouterContact({ nom, prenom, email, message });
              fermerModalAjouter();
            }}
          >
            Ajouter
          </button>
          <button className="button3" onClick={fermerModalAjouter}>
            Annuler
          </button>
        </div>
      </Modal>

      <h2>Mettre à jour un contact</h2>
      <button className="button3" onClick={ouvrirModalModifier}>
        Modifier un contact
      </button>
      <Modal isOpen={modalModifierOuvert} onRequestClose={fermerModalModifier}>
      <div className="modal-content">
          <h2>Mettre à jour un contact</h2>
          <input
            className="input"
            type="text"
            placeholder="ID du contact"
            value={contactId}
            onChange={(e) => setContactId(e.target.value)}
          />
          <input
            className="input"
            type="text"
            placeholder="Nom"
            value={nom}
            onChange={(e) => setNom(e.target.value)}
          />
          <input
            className="input"
            type="text"
            placeholder="Prénom"
            value={prenom}
            onChange={(e) => setPrenom(e.target.value)}
          />
          <input
            className="input"
            type="text"
            placeholder="Email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
          />
          <input
            className="input"
            type="text"
            placeholder="Message"
            value={message}
            onChange={(e) => setMessage(e.target.value)}
          />
          <button
            className="button3"
            onClick={() => {
              mettreAJourContact(contactId, { nom, prenom, email, message });
              fermerModalModifier();
            }}
          >
            Mettre à jour
          </button>
          <button className="button3" onClick={fermerModalModifier}>
            Annuler
          </button>
        </div>
      </Modal>

      <h2>Supprimer un contact</h2>
      <input
        className="input"
        type="text"
        placeholder="ID du contact"
        value={contactId}
        onChange={(e) => setContactId(e.target.value)}
      />
      <button
        className="button3"
        onClick={() => {
          supprimerContact(contactId);
        }}
      >
        Supprimer
      </button>
    </div>

    <div className="part">
      <h1>Météo</h1>
      <input
        className="input"
        type="text"
        placeholder="Ville"
        value={ville}
        onChange={(e) => setVille(e.target.value)}
      />
      <button
        className="button3"
        onClick={() => {
          recupererMeteo();
        }}
      >
        Rechercher
      </button>

      {meteo && (
        <div>
          <img
            src={`http://openweathermap.org/img/wn/${meteo.weather[0].icon}@2x.png`}
            alt={meteo.weather[0].description}
          />
          <h2>{meteo.name}</h2>
          <p>Température : {meteo.main.temp}°C</p>
          <p>Description : {meteo.weather[0].description}</p>
        </div>
      )}
    </div>
    
  </div>
  <h1>Liste des contacts</h1>
    <ul className="contact-list">
      {contacts.map((contact) => (
        <li key={contact.id} className="contact-box">
          <p className="contact-info">ID: {contact.id}</p>
          <p className="contact-info">Nom: {contact.nom}</p>
          <p className="contact-info">Prénom: {contact.prenom}</p>
          <p className="contact-info">Email: {contact.email}</p>
          <p className="contact-info">Message: {contact.message}</p>
        </li>
      ))}
    </ul>
</div>
  );
};

export default GestionDonnees;


