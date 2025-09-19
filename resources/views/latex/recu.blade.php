\documentclass[10pt]{article}
\usepackage[utf8]{inputenc}
\usepackage[OT1]{fontenc}
\usepackage{array}
\usepackage[table]{xcolor}   % pour \rowcolors
\usepackage{colortbl}
\usepackage{fancyhdr}     % pour l'en-tête et pied de page
\usepackage{geometry}
\geometry{margin=1cm}

\pagestyle{fancy}
\fancyhf{}
\lhead{\textbf{Reçu de paiement}}
\rhead{ETS AROUNA}


\definecolor{lightgray}{RGB}{230,230,230}
\definecolor{headerblue}{RGB}{41,128,185}

\begin{document}

\noindent
\begin{center}
\large\textbf{ETABLISSEMENT AROUNA} \\[0.1cm]
\textbf{COMMERCE GENERAL} \\[0.1cm]
VENTE DE MATERIAUX ELECTRIQUES, APPAREILS ELECTRONIQUES ET DIVERS\\
ROUTE DE BASSAR à 100 Mètres de la Station MRS, BP 573 SOKODE-TOGO\\
Email : arouna.youssaou@gmail.com / Contacts : 90 29 08 36 / 90 98 22 11
\end{center}


\vspace{0.5cm}

\noindent
\large\textbf{FACTURE \hfill Sokodé, le {{ $commande->dateCommande }}}

\vspace{0.3cm}

\noindent
\textbf{Client : {{ $commande->first_name }} {{ $commande->name }} {{ $commande->contact }}}

\vspace{0.3cm}

\rowcolors{2}{lightgray}{white}
\begin{tabular}{|p{1.5cm}|p{6cm}|p{2cm}|p{2cm}|p{2.5cm}|}
\hline
\rowcolor{headerblue}\color{white}\textbf{QTE} & \color{white}\textbf{DESIGNATION} & \color{white}\textbf{PU (FCFA)} & \color{white}\textbf{reduction accordé (FCFA)} & \color{white}\textbf{MONTANT (FCFA)} \\
\hline
@foreach($ligneCommande as $produit)
{{ $produit->quantite }} & {{ $produit->libelle }} & {{ number_format($produit->prix_ligne / $produit->quantite, 0, ',', ' ') }} & {{ number_format($produit->prix-$produit->prix_ligne / $produit->quantite, 0, ',', ' ') }} & {{ number_format($produit->prix_ligne, 0, ',', ' ') }} \\
\hline
@endforeach
\end{tabular}

\vspace{0.5cm}

\noindent
\textbf{TOTAL : {{ number_format($commande->prix_total, 0, ',', ' ') }} FCFA}

\vspace{0.5cm}

\noindent
Arrêté la présente Facture à la somme de {{ number_format($commande->prix_total, 0, ',', ' ') }} FCFA

\vspace{0.5cm}

\noindent
\textbf{Signature :} \underline{\hspace{5cm}}

\vspace{0.5cm}

\noindent
NB : une fois le stock acheté \& contrôlé par le serviteur, il ne doit plus être ramené après 72h

\vspace{0.7cm}

\begin{center}
\large\textbf{ETABLISSEMENT AROUNA VOUS REMERCI DE VOTRE FIDELITE } \\[0.1cm]
\end{center}


\end{document}
