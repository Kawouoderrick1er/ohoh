<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Edflex</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    /* Styles généraux */
body {
    font-family: sans-serif;
    margin: 0;
    color: #333;
}

.main-footer {
    background-color:rgba(24, 24, 43, 0.33);
    padding: 38px;
}

/* Section supérieure */
.footer-top {
    text-align: center;
    margin-bottom: 20px;
}

.footer-top h2 {
    font-size: 1.5em;
    margin-bottom: 10px;
}

.footer-buttons {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    color: white;
}

.demo-button {
    background-color: #007bff;
}

.mooc-button {
    background-color:rgb(3, 38, 68);
}

/* Section des liens */
.footer-links {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    margin-bottom: 20px;
}

.footer-links-col {
    flex: 1 1 150px;
    margin-bottom: 20px;
}

.footer-links-col h3 {
    font-size: 1.1em;
    margin-bottom: 10px;
}

.footer-links-col ul {
    list-style: none;
    padding: 0;
}

.footer-links-col li {
    margin-bottom: 5px;
}

.footer-links-col a {
    text-decoration: none;
    color: #333;
}

/* Section inférieure */
.footer-bottom {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    font-size: 0.8em;
}

.social-links img {
    width: 20px;
    margin-left: 5px;
}

.legal-links a {
    margin-left: 10px;
    color: #333;
}

/* Responsivité */
@media (max-width: 768px) {
    .footer-buttons {
        flex-direction: column;
        align-items: center;
    }

    .footer-links {
        flex-direction: column;
    }

    .footer-bottom {
        flex-direction: column;
        text-align: center;
    }
}
/* .main-footer {
    background: linear-gradient(to bottom,rgb(28, 26, 29),rgb(90, 22, 158)); /* Exemple de dégradé */
   
/* }  */
</style>
<body>
    <footer class="main-footer">
        <section class="footer-top">
            <h2>Comment DIGI-X-TECH peut enrichir la formation dans votre entreprise ?</h2>
            <p>Rencontrez un membre digital technoalogie afin de déterminer si la solution correspond aux besoins de votre entreprise lors d'un rendez-vous téléphonique, ou retournez sur DIGI-X-TECH vous former individuellement.</p>
            <div class="footer-buttons">
                <a href="" class="button demo-button">Je demande une démo pour mon entreprise</a>
                <a href="" class="button mooc-button">Je retourne sur digital technoalogie </a>
            </div>
        </section>
        <section class="footer-links">
            <div class="footer-links-col">
                <h3>Catalogue</h3>
                <ul>
                    <li><a href="">Business</a></li>
                    <li><a href="">People & Management</a></li>
                    <li><a href="">Développement personnel</a></li>
                    <li><a href="">Organisation du travail</a></li>
                    <li><a href="">Culture & Langues</a></li>
                    <li><a href="">Technologies et outils</a></li>
                    <li><a href="">Conformité, éthique et RSE</a></li>
                </ul>
            </div>
            <div class="footer-links-col">
                <h3>Solutions</h3>
                <ul>
                    <li><a href="">Notre solution</a></li>
                    <li><a href="">Notre offre</a></li>
                    <li><a href="">Nos éditeurs</a></li>
                    <li><a href="">Nos intégrations</a></li>
                </ul>
            </div>
            <div class="footer-links-col">
                <h3>Usages</h3>
                <ul>
                    <li><a href="">Renouveler plan formation</a></li>
                    <li><a href="">Augmenter engagement</a></li>
                    <li><a href="">Optimiser le budget</a></li>
                    <li><a href="">Evolution des compétences</a></li>
                    <li><a href="">Formation en entreprise</a></li>
                    <li><a href="">Organisation apprenante</a></li>
                    <li><a href="">Curation de contenu</a></li>
                </ul>
            </div>
            <div class="footer-links-col">
                <h3>À propos</h3>
                <ul>
                    <li><a href="">Notre équipe</a></li>
                    <li><a href="">Pourquoi Edflex</a></li>
                    <li><a href="">Partenaires diffusion</a></li>
                    <li><a href="">Partenaires contenu</a></li>
                    <li><a href="">Espace presse</a></li>
                   <li><a href="">L&D for good</a></li>
                </ul>
            </div>
            <div class="footer-links-col">
                <h3>Ressources</h3>
                <ul>
                    <li><a href="">Notre blog</a></li>
                    <li><a href="">Nos guides</a></li>
                    <li><a href="">Nos webinaires</a></li>
                    <li><a href="">Notre podcast</a></li>
                    <li><a href="">Nos cas clients</a></li>
                    <li><a href="">Nos top thématiques</a></li>
                    <li><a href="">Tout le catalogue</a></li>
                    <li><a href="">Rentrée du digital learning</a></li>
                    <li><a href="">Quiz : Optimisez vos formations</a></li>
                </ul>
            </div>
        </section>
        <section class="footer-bottom">
            <p>© 2025 DIGI-X-TECH, tous droits réservés</p>
            <div class="social-links">
                <a href=""><img src="Images/png/indeed.jpeg" alt="LinkedIn"></a>
                <a href=""><img src="Images/png/facebook.jpeg" alt="Facebook"></a>
                <a href=""><img src="Images/png/Instagram Logo and PNG (1).jpeg" alt="Twitter"></a>
            </div>
            <div class="legal-links">
                <a href="">Contact</a>
                <a href="">Confidentialité</a>
                <a href="">Mentions légales</a>
                <a href="">Documentation légale</a>
                <a href="">CGU</a>
                <a href="">Cookies</a>
                <a href="">Qualiopi</a>
                <a href="">FAQ</a>
            </div>
        </section>
    </footer>
</body>
</html>