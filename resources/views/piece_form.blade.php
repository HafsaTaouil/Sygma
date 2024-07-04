<!-- resources/views/add_to_model_form.blade.php -->
<x-app-layout>
    <div class="p-4 md:ml-52 flex gap-2 flex-col">
        <h1 class="text-2xl font-bold mb-6 col-span-full">Add piece to a model</h1>
        <form id="add-to-model" method="POST" action="{{ route('piece.store-model') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="piece_id" value="{{ request()->query('piece') }}">

            <div class="w-6/12 mx-auto border border-gray-300 p-4 rounded-lg">
                <!-- Select marque -->
                <div class="mb-4">
                    <label for="marque" class="block text-sm font-medium text-gray-900">Select a marque</label>
                    <select id="marque" name="marque_id" class="form-select block w-full mt-1">
                        <option value="">Select marque</option>
                        @foreach ($marques as $marque)
                            <option value="{{ $marque->id }}">{{ $marque->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Select modele -->
                <div class="mb-4">
                    <label for="modele" class="block text-sm font-medium text-gray-900">Select a modele</label>
                    <select id="modele" name="modele_id" class="form-select block w-full mt-1" disabled>
                        <option value="">Select modele</option>
                    </select>
                </div>
                <!-- Select partie -->
                <div class="mb-4">
                    <label for="partie" class="block text-sm font-medium text-gray-900">Select a part</label>
                    <select id="partie" name="partie_id" class="form-select block w-full mt-1">
                        <option value="">Select part</option>
                        @foreach ($parties as $partie)
                            <option value="{{ $partie->id }}">{{ $partie->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Min Year -->
                <div class="mb-4">
                    <label for="min_year" class="block text-sm font-medium text-gray-900">Minimum Year</label>
                    <input id="min_year" type="number" name="min_year" class="form-input block w-full mt-1">
                </div>
                <!-- Max Year -->
                <div class="mb-4">
                    <label for="max_year" class="block text-sm font-medium text-gray-900">Maximum Year</label>
                    <input id="max_year" type="number" name="max_year" class="form-input block w-full mt-1">
                </div>
                <!-- Submit Button -->
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add Piece to Model
                </button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const marqueSelect = document.getElementById('marque');
            const modeleSelect = document.getElementById('modele');

            marqueSelect.addEventListener('change', function () {
                const marqueId = this.value;
                if (marqueId) {
                    modeleSelect.innerHTML = '<option value="">Loading...</option>';

                    fetch(`/api/marques/${marqueId}/modeles`)
                        .then(response => response.json())
                        .then(data => {
                            modeleSelect.innerHTML = '<option value="">Select modele</option>';
                            data.forEach(modele => {
                                const option = document.createElement('option');
                                option.value = modele.id;
                                option.textContent = modele.name;
                                modeleSelect.appendChild(option);
                            });
                            modeleSelect.disabled = false;
                        });
                } else {
                    modeleSelect.innerHTML = '<option value="">Select marque first</option>';
                    modeleSelect.disabled = true;
                }
            });
        });
    </script>

</x-app-layout>
