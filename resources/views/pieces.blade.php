<style>
    .tooltip:hover .tooltip-text {
        opacity: 1;
        visibility: visible;
    }
</style>

<x-app-layout>
    <div class="p-4 md:ml-52 grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-4" id="gridContainer">
        <h1 class="text-2xl font-bold mb-6 col-span-full">Liste des pièces</h1>
        <div class="flex flex-row gap-2 items-center col-span-full mb-4">
            <input type="text" placeholder="Search..." class="w-3/4 border-2 rounded-full border-[#009999] px-4 py-2">
            <i class="fa-solid fa-magnifying-glass bg-[#009999] px-4 py-2 rounded-full text-white text-xl"></i>

            <!-- Modal toggle Ajout piece -->
            <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                class="flex items-center text-white bg-[#009999] hover:bg-[#008080] transition-all rounded-full px-4 py-3"
                type="button">
                <i class="fas fa-plus mr-2"></i> Ajouter Nouvelle Piece
            </button>
        </div>

        <!-- Modal content Ajout Piece -->
        <div id="crud-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Créer une nouvelle piece
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="crud-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <!-- Inner form content -->
                        <form id="crud-modal-form" method="POST" action="{{ route('pieces.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="name"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Piece</label>
                                    <input type="text" name="name" id="name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Entrez la piece ..." required>
                                </div>
                                <div class="col-span-2">
                                    <label for="image"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Image</label>
                                    <input type="file" name="image" id="image"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        required>
                                </div>
                                <div class="col-span-1">
                                    <label for="prix_reparation"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prix de
                                        reparation</label>
                                    <input type="text" name="prix_reparation" id="prix_reparation"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Entrez le prix de reparation ..." required>
                                </div>
                                <div class="col-span-1">
                                    <label for="prix_remplacement"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prix de
                                        remplacement</label>
                                    <input type="text" name="prix_remplacement" id="prix_remplacement"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Entrez le prix de remplacement ..." required>
                                </div>
                            </div>
                            <!-- Inner form submit button -->
                            <button type="submit"
                                class="flex items-center text-white bg-[#009999] hover:bg-[#008080] transition-all rounded-full px-4 py-3">
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Ajouter
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($pieces as $piece)
            <div class="bg-white rounded-lg shadow-md p-4 transition-all duration-300 marque-card flex flex-col"
                id="marque-{{ $piece->id }}">
                <div class="flex justify-between">
                    <h2 class="text-xl font-semibold mb-4 cursor-pointer">
                        {{ $piece->name }}
                    </h2>
                    <div class="flex flex-col justify-between ">
                        <!-- Ajouter piece à modeles-->
                        <a href="{{ route('piece.add-to-model', ['piece' => $piece->id]) }}">
                            <span class="relative inline-block tooltip">
                                <i class="fas fa-plus text-[#008080]"></i>
                                <span
                                    class="text-nowrap tooltip-text opacity-0 bg-gray-100 text-gray-700 text-xs rounded-lg py-2 px-4 absolute z-10 mt-1 transition duration-200 ease-in-out opacity-0 invisible">
                                    <i class="fas fa-info text-gray-700 mx-1 "></i> Ajouter la pièce à d'autres modèles
                                </span>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="flex justify-between">

                    <!-- Update piece button -->
                    <button data-modal-target="update-piece-{{ $piece->id }}"
                        data-modal-toggle="update-piece-{{ $piece->id }}"
                        class="flex items-center text-[#008080] transition-all rounded-full">
                        <i class="fas fa-pen"></i>
                    </button>
                    <!-- Delete piece button -->
                    <form method="POST" action="{{ route('pieces.destroy', $piece->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center text-red-600 transition-all rounded-full">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
                <img class="rounded-lg my-4" src="{{ asset($piece->image) }}" alt="Piece Image">
                <div class="font-semibold">
                    <p>Prix de reparation : <span class="text-lg text-[#008080]">{{ $piece->prix_reparation }}</span>
                    </p>
                    <p>Prix de remplacement : <span class="text-lg text-[#008080]">{{ $piece->prix_remplacement }}</span>
                    </p>
                </div>
                <a href="#" onclick="toggleDetails({{ $piece->id }})"
                    class=" mt-4 flex items-center font-medium text-[#009999] dark:text-[#008080] dark:hover:[#008080] hover:text-[#008080] hover:underline">
                    Afficher Plus
                    <i class=" text[#009999] hover:text-[#008080] fas fa-caret-down mx-2"></i>
                </a>

                <!-- Hidden details -->
                <div id="details-{{ $piece->id }}" class="hidden">
                    @foreach ($piece->parties as $partie)
                        <div class="text-gray-700">
                            <p class="font-semibold">
                                Partie: <span class="text-gray-600">{{ $partie->name }}</span>
                            </p>
                            @foreach ($partie->modeles as $modele)
                                <div class="ml-4 text-gray-600">
                                    <p>Modèle: {{ $modele->name }} ({{ $modele->marque->name }})</p>
                                    <p class="mb-2">Années: {{ $modele->pivot->min_year }} - {{ $modele->pivot->max_year }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Update Piece Modal -->
            <div id="update-piece-{{ $piece->id }}" tabindex="-1" aria-hidden="true"
                class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Update Piece</h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="update-piece-{{ $piece->id }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-6 space-y-6">
                            <form id="crud-modal-form" method="POST" action="{{ route('pieces.update', $piece->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="grid gap-4 mb-4 grid-cols-2">
                                    <div class="col-span-2">
                                        <label for="name"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Piece</label>
                                        <input type="text" name="name" id="name" value="{{ $piece->name }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="Entrez la piece ..." required>
                                    </div>
                                    <div class="col-span-2">
                                        <label for="image"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Image</label>
                                        <input type="file" name="image" id="image"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        @if($piece->image)
                                            <img src="{{ asset($piece->image) }}" alt="Piece Image" class="mt-2 h-20">
                                        @endif
                                    </div>
                                    <div class="col-span-1">
                                        <label for="prix_reparation"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prix de
                                            reparation</label>
                                        <input type="text" name="prix_reparation" id="prix_reparation"
                                            value="{{ $piece->prix_reparation }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="Entrez le prix de reparation ..." required>
                                    </div>
                                    <div class="col-span-1">
                                        <label for="prix_remplacement"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prix de
                                            remplacement</label>
                                        <input type="text" name="prix_remplacement" id="prix_remplacement"
                                            value="{{ $piece->prix_remplacement }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="Entrez le prix de remplacement ..." required>
                                    </div>
                                </div>
                                <!-- Inner form submit button -->
                                <button type="submit"
                                    class="flex items-center text-white bg-[#009999] hover:bg-[#008080] transition-all rounded-full px-4 py-3">
                                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Mettre à jour
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        function toggleDetails(pieceId) {
            const detailsElement = document.getElementById('details-' + pieceId);
            detailsElement.classList.toggle('hidden');
        }

        //Sweet alert
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: '{{ session('error') }}',
                });
            @endif

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: '{{ session('success') }}',
                });
            @endif
        });
    </script>
</x-app-layout>