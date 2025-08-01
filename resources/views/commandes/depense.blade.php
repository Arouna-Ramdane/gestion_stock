 <form action="{{ route('depenses') }}" method="get" class="bg-gray-100 p-4 rounded">
        <input type="hidden" name="date" value="{{ $date }}">
        <h3 class="font-semibold mb-2">➕ Ajouter une dépense :</h3>
        <div class="mb-2">
            <label>Montant (FCFA) :</label>
            <input type="number" name="montant" step="0.01" required class="border p-2 rounded w-full">
        </div>
        <div class="mb-2">
            <label>Motif (facultatif) :</label>
            <input type="text" name="motif" class="border p-2 rounded w-full">
        </div>
        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Enregistrer la dépense</button>
    </form>
