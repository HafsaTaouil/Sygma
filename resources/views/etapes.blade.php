<x-app-layout>
    <div class="p-4 md:ml-52 flex gap-2 flex-col">
        <h1 class="font-bold text-3xl">Etapes</h1>
        <div class="flex flex-col gap-2">
            <p>Etapes list</p>
            <div class="overflow-x-auto">
                <table class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>Etape</th>
                            <th>Questionnaire</th>
                            <th>
                                <button onclick="showCreateEtapeModal()" class="bg-green-500 p-2 rounded-lg text-white">Create New Etape</button>
                                <form action="{{ route('create.etape') }}" method = "POST">
                                    @csrf
                                <dialog id="createEtape" class="modal">
                                    <div class="modal-box max-w-[88em]">
                                        <h3 class="text-lg font-bold">New Etape</h3>
                                        <p class="py-4">Name of etape</p>
                                        <div class = "flex flex-col gap-2">
                                            <input placeholder = "Name of etape..." type="text" id="etapeName" name="etape_name" class="w-full p-2 border rounded-lg">
                                            <textarea placeholder = "Description..." class = "w-full p-2 border rounded-lg resize-none" name="etape_description" cols="30" rows="10"></textarea>
                                        </div>
                                        <p class="py-4">Questions</p>
                                        <div id="questionsContainer">
                                            <div class="flex flex-row items-center gap-2">
                                                <input type="text" name="questions[]" class="w-1/2 p-2 border rounded-lg">
                                                <select name="types[]" onchange = "handleTypeChange(this)" class = "w-1/2 p-2 border rounded-lg" id="">
                                                    <option value="Choix unique">Choix unique</option>
                                                    <option value="Multichoix">Multichoix</option>
                                                    <option value="Image">Image</option>
                                                    <option value="Remarque">Remarque</option>
                                                </select>
                                                <button type = "button" class="px-2 py bg-green-500 rounded-lg text-white text-2xl" onclick="addQuestion()"><i class="fa-solid fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="modal-action">
                                            <button class="bg-green-500 p-4 text-white rounded-lg" onclick="submitEtape()">Submit</button>
                                            <button type = "button" class="btn" onclick="closeCreateEtapeModal()">Close</button>
                                        </div>
                                    </div>
                                </dialog>
                            </form>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $etape)
                        <tr>
                            <td>{{ $etape['name'] }}</td>
                            <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p>Order of etapes list</p>
            @foreach ($orders as $order)
            <ul class="steps">
                @foreach ($order->etapes() as $step)
                <li class="step step-success">{{ $step['name'] }}</li>
                @endforeach
            </ul>
            @endforeach
            <div>
                <button onclick="orderModal.showModal()" class="bg-green-500 p-2 rounded-lg text-white">Create New Order</button>
                <dialog id="orderModal" class="modal">
                    <div class="modal-box">
                        <h3 class="text-lg font-bold">New Order of Etapes</h3>
                        <form action="{{ route('create.order') }}" method = "POST">
                            @csrf
                        <div id="orderContainer">
                            <div class="flex flex-row items-center gap-2">
                                <select name="order_etapes[]" class="w-1/2 p-2 border rounded-lg">
                                    @foreach ($data as $etape)
                                        <option value="{{ $etape->id }}">{{ $etape->name }}</option>
                                    @endforeach
                                </select>
                                <button type = "button" class="px-2 py bg-green-500 rounded-lg text-white text-2xl" onclick="addOrderInput()"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="modal-action">
                            <button class="bg-green-500 p-4 text-white rounded-lg" onclick="submitOrder()">Submit</button>
                            <button type = "button" class="btn" onclick="closeOrderModal()">Close</button>
                        </div>
                    </form>
                    </div>
                </dialog>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    let questions = [];
    let types = [];

    function showCreateEtapeModal() {
        document.getElementById('createEtape').showModal();
    }

    function closeCreateEtapeModal() {
        document.getElementById('createEtape').close();
    }

    function addQuestion() {
        const questionContainer = document.createElement('div');
        questionContainer.className = 'flex flex-row items-center gap-2';

        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'questions[]';
        input.className = 'w-1/2 p-2 border rounded-lg';

        const type = document.createElement('select');
        type.name = 'type[]';
        type.className = 'w-1/2 p-2 border rounded-lg';

        const option1 = document.createElement('option');
        option1.value = 'Multichoix';
        option1.textContent = 'Multichoix';

        const option2 = document.createElement('option');
        option2.value = 'Choix unique';
        option2.textContent = 'Choix unique';

        const option3 = document.createElement('option');
        option3.value = 'Image';
        option3.textContent = 'Image';

        const option4 = document.createElement('option');
        option4.value = 'Remarque';
        option4.textContent = 'Remarque';

        const removeButton = document.createElement('button');
        removeButton.className = 'px-2 py bg-red-500 rounded-lg text-white text-2xl';
        removeButton.innerHTML = '<i class="fa-solid fa-minus"></i>';
        removeButton.onclick = () => questionContainer.remove();

        questionContainer.appendChild(input);
        questionContainer.appendChild(type);
        type.appendChild(option2);
        type.appendChild(option1);
        type.appendChild(option3);
        type.appendChild(option4);
        questionContainer.appendChild(removeButton);
        document.getElementById('questionsContainer').appendChild(questionContainer);
    }

    function handleTypeChange(selectElement) {
        const questionContainer = selectElement.parentElement;
        const existingMultichoixContainer = questionContainer.querySelector('.multichoix-container');
        const existingAddOptionButton = questionContainer.querySelector('.add-option-button');

        if (selectElement.value === 'Multichoix' && !existingMultichoixContainer) {
            const multichoixContainer = document.createElement('div');
            multichoixContainer.className = 'multichoix-container flex flex-col gap-2 mt-2';

            const addOptionButton = document.createElement('button');
            addOptionButton.type = 'button';
            addOptionButton.className = 'bg-blue-500 p-2 rounded-lg text-white add-option-button';
            addOptionButton.textContent = 'Add Option';
            addOptionButton.onclick = function () {
                const optionContainer = document.createElement('div');
                optionContainer.className = 'flex items-center gap-2';

                const optionInput = document.createElement('input');
                optionInput.type = 'text';
                optionInput.name = 'multichoix_options[]';
                optionInput.placeholder = 'Option...';
                optionInput.className = 'w-full p-2 border rounded-lg';

                const removeOptionButton = document.createElement('button');
                removeOptionButton.type = 'button';
                removeOptionButton.className = 'px-2 py bg-red-500 rounded-lg text-white text-2xl';
                removeOptionButton.innerHTML = '<i class="fa-solid fa-minus"></i>';
                removeOptionButton.onclick = () => optionContainer.remove();

                optionContainer.appendChild(optionInput);
                optionContainer.appendChild(removeOptionButton);

                multichoixContainer.appendChild(optionContainer);
            };

            questionContainer.appendChild(multichoixContainer);
            questionContainer.appendChild(addOptionButton);
        } else if (selectElement.value !== 'Multichoix' && existingMultichoixContainer) {
            existingMultichoixContainer.remove();
            if (existingAddOptionButton) {
                existingAddOptionButton.remove();
            }
        }
    }

    function submitEtape() {
        const etapeName = document.getElementById('etapeName').value;
        const inputs = document.querySelectorAll('#questionsContainer input');
        questions = Array.from(inputs).map(input => input.value);
        console.log({ etapeName, questions });
        closeCreateEtapeModal();
    }

    let orderEtapes = [];

    function addOrderInput() {
        const orderContainer = document.createElement('div');
        orderContainer.className = 'flex flex-row items-center gap-2';

        const select = document.createElement('select');
        select.name = 'order_etapes[]';
        select.className = 'w-1/2 p-2 border rounded-lg';

        let option = null;
        @foreach ($data as $etape)
            option = document.createElement('option');
            option.value = "{{ $etape->id }}";
            option.textContent = "{{ $etape->name }}";
            select.appendChild(option);
        @endforeach


        const removeButton = document.createElement('button');
        removeButton.className = 'px-2 py bg-red-500 rounded-lg text-white text-2xl';
        removeButton.innerHTML = '<i class="fa-solid fa-minus"></i>';
        removeButton.onclick = () => orderContainer.remove();

        orderContainer.appendChild(select);
        orderContainer.appendChild(removeButton);
        document.getElementById('orderContainer').appendChild(orderContainer);
    }

    function submitOrder() {
        const selects = document.querySelectorAll('#orderContainer select');
        orderEtapes = Array.from(selects).map(select => select.value);
        console.log(orderEtapes);
        closeOrderModal();
    }
</script>
