<div class="drawer lg:drawer-open">
  <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
  <div class="drawer-content flex flex-col items-center justify-center">
  </div>
  <div class="drawer-side">
    <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
    <ul class="menu bg-gray-700 text-white text-base-content min-h-full w-80 p-4">
      <li><a href="{{ route('commandes.create') }}">enregistrer une vente</a></li>
      <li><a href="{{ route('depenses.create') }}">enregistrer une depense</a></li>
      <li><a href="{{ route('users.index') }}">liste des utilisateurs</a></li>
      <li><a href="{{ route('produits.index') }}">inventaire des produits</a></li>
      <li><a href="{{ route('commandes.index') }}">voir la liste des commandes</a></li>
      <li><a href="{{ route('totalJournalier') }}">voir le total journalier</a></li>
      <li><a href="{{ route('depenses.index') }}">voir les depenses d'une journée</a></li>
      <li>
        <form action="{{route('logout')}}" method="post">
                @csrf
                <button>
                Déconnexion
                </button>

            </form></li>
    </ul>
  </div>
</div>
