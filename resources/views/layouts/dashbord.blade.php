<div class="drawer lg:drawer-open">
  <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
  <div class="drawer-content flex flex-col items-center justify-center">
  </div>

  <div class="drawer-side h-screen">
    <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>

    <ul class="menu bg-gray-700 text-white text-base-content w-80 p-4 h-full space-y-2">

      <li class="text-xs uppercase text-gray-400 mb-1 ml-2">📌 Actions</li>
      <li><a href="{{ route('commandes.create') }}">🛒 Enregistrer une vente</a></li>
      <li><a href="{{ route('depenses.create') }}">💸 Enregistrer une dépense</a></li>

      <li class="text-xs uppercase text-gray-400 mt-4 mb-1 ml-2">📈 Suivi</li>
      <li><a href="{{ route('totalJournalier') }}">📊 Total journalier</a></li>
      <li><a href="{{ route('depenses.index') }}">🧾 Dépenses d'une journée</a></li>
        <li><a href="{{ route('commandes.index') }}">📃 Liste des commandes de la journée</a></li>
      <li class="text-xs uppercase text-gray-400 mt-4 mb-1 ml-2">⚙️ Gestion</li>
      <li><a href="{{ route('produits.index') }}">📦 Inventaire produits</a></li>
      @can('view-user')
        <li><a href="{{ route('users.index') }}">👥 Utilisateurs</a></li>
      @endcan
      @can('view-client')
      <li><a href="{{ route('clients.index') }}">👥 clients</a></li>

      @endcan
      <li><a href="{{ route('allCommande') }}">👥 Liste de tous les commandes</a></li>

      <li class="text-xs uppercase text-gray-400 mt-4 mb-1 ml-2">🔒 Session</li>
      <li>
        <form action="{{ route('logout') }}" method="post">
          @csrf
          <button>🚪 Déconnexion</button>
        </form>
      </li>
    </ul>
  </div>
</div>
