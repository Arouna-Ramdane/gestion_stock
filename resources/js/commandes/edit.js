document.addEventListener('DOMContentLoaded', () => {

    const prix_total = document.getElementById('prix_total');

    recalculerTotal();

    function ajouterPanier(nom, prix, qtd, id) {
        let le_prix = prompt("Entrer le prix :", prix);
        if (le_prix === null) {
            return;
        }

        let prix_achat = Number(le_prix);
        if (isNaN(prix_achat) || prix_achat <= 0) {
            alert("Prix invalide !");
            return;
        }

        const panier = document.getElementById('panier');

        // Vérifier si le produit est déjà ajouté
        const dejaAjoute = Array.from(panier.children).some(ligne =>
            ligne.querySelector('input[name="id_prod[]"]').value == id
        );
        if (dejaAjoute) {
            alert("Ce produit est déjà dans le panier.");
            return;
        }

        // Créer la ligne produit
        const ligne = document.createElement('div');
        ligne.className = 'flex items-center justify-between bg-white p-2 rounded shadow';

        ligne.innerHTML = `
            <input type="number" min="0" max="${qtd}" value="1"
                   class="w-16 p-1 border rounded modif_qte"
                   name="qte[]" onchange="modifierPrix(event, ${prix_achat})">
            <p class="flex-1 px-2">${nom}</p>
            <input type="hidden" name="id_prod[]" value="${id}">
            <input type="hidden" name="prix_unitaire[]" value="${prix_achat}">
            <input type="number"
                   class="prix_ligne font-bold w-20 p-1 border rounded"
                   name="id_prix_achat[]"
                   value="${prix_achat}"
                   onchange="recalculerTotal()"> FCFA
        `;
        panier.appendChild(ligne);

        prix_total.textContent = Number(prix_total.textContent) + prix_achat;
        document.getElementById('input_total').value = prix_total.textContent;
    }

   function modifierPrix(event, prix_unitaire) {
    const input = event.target;
    const qte   = Number(input.value);
    const ligne = input.closest('.flex');

    const prixInput = ligne.querySelector('.prix_ligne');

    if (qte <= 0) {
        ligne.remove();
        recalculerTotal();
        return;
    }

    const nouveauPrix = qte * prix_unitaire;

    prixInput.value = nouveauPrix;

    recalculerTotal();
}

    function recalculerTotal() {
        let total = 0;
        document.querySelectorAll('.prix_ligne').forEach(prixInput => {
            total += parseInt(prixInput.value);
        });

        document.getElementById('prix_total').textContent = total;
        document.getElementById('input_total').value = total;
    }

    document.getElementById('form').addEventListener('submit', e => {
        document.getElementById('input_total').value = prix_total.textContent;
    });

    const input = document.getElementById('client_input');
    const hiddenInput = document.getElementById('client_id');
    const datalist = document.getElementById('clients_list');

    if (input && hiddenInput && datalist) {
        input.addEventListener('input', function() {
            const val = this.value;
            const option = Array.from(datalist.options).find(opt => opt.value === val);
            hiddenInput.value = option ? option.dataset.id : '';
        });
    }

    window.ajouterPanier = ajouterPanier;
    window.modifierPrix = modifierPrix;
    window.recalculerTotal = recalculerTotal;

});
