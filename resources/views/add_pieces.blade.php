<x-app-layout>
    <div class="p-4 md:ml-52  flex gap-2 flex-col">

        <h1 class="text-2xl font-bold mb-6 col-span-full">Pieces</h1>
        <form id="all" method="POST" action="{{ route('all.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="w-6/12 mx-auto border border-gray-300 p-4 rounded-lg">

                <label for="pieces" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choisir une
                    pièce</label>
                <div class="flex items-center gap-2">
                    <select id="pieces" name="piece_id"
                        class="flex-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($pieces as $piece)
                            <option value="{{ $piece->id }}">{{ $piece->name }}</option>
                        @endforeach
                    </select>

                    <!-- Modal toggle Ajout piece -->
                    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                        class="flex items-center text-white bg-[#009999] hover:bg-[#008080] transition-all rounded-full px-4 py-3"
                        type="button">
                        <i class="fas fa-plus mr-2"></i> Ajouter Piece
                    </button>
                </div>

                <!-- Max Year -->
                <label for="max_year" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Entrez
                    Max année</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <select id="max_year" name="max_year"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @for ($year = date('Y'); $year >= 1994; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Min Year -->
                <label for="min_year" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Entrez
                    Min année</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                        <i class="fas fa-calendar-minus"></i>
                    </div>
                    <select id="min_year" name="min_year"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @for ($year = date('Y'); $year >= 1994; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="mt-4 w-full text-white bg-[#009999] hover:bg-[#008080] text-sm font-medium rounded-full py-2.5">
                    Envoyer
                </button>
            </div>
        </form>


        <!-- Modal content -->
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
                            <button type="button"
                                class="flex items-center text-white bg-[#009999] hover:bg-[#008080] transition-all rounded-full px-4 py-3"
                                onclick="submitModalForm()">
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
                    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                    <!-- Select2 -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
                    <script>
                        $(document).ready(function () {
                            $('#pieces').select2({
                                theme: 'classic',
                                placeholder: 'Selectionne une pièce',
                                allowClear: true
                            });
                        });

                        //form modal
                        function submitModalForm() {

                            document.getElementById('crud-modal-form').submit();
                        }


                    </script>
                    @include('layouts.footer')

</x-app-layout>