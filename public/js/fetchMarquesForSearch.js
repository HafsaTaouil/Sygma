$(document).ready(() => {
    var marquesContainer = $("#marques-container");
    var modelesContainer = $("#modeles");
    const dropdown = $("#dropdown-states");

    function fetchMarquesAndModeles() {
        $.ajax({
            url: "/api/marques",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var topBtn = $("#states-button");
                

                marquesContainer.empty();


                response.forEach(marque => {
                    const li = $(`
                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                <div class="inline-flex items-center">
                                    <span class="material-symbols-outlined">directions_car</span>                                    
                                    ${marque.name}
                                </div>
                            </button>
                        </li>                    
                    `);

                    
                    li.find('button').on('click',()=>{
                        topBtn.html(`
                            <span class="material-symbols-outlined me-2">traffic_jam</span>
                            ${marque.name}
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        `);
                        dropdown.addClass('hidden');
                        
                        $.ajax({
                            url: `/api/marques/${marque.id}`, 
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                modelesContainer.empty();
                                
                                var modelesToRender = [];

                                const selectedOption = $(`<option>Choisir le modèle</option>`);
                                modelesContainer.append(selectedOption);

                                response.forEach(modele =>{
                                    if(!modelesToRender.includes(modele.name) && modele.name!="--"){
                                        modelesToRender.push(modele.name);
                                        const option = $(`
                                            <option>${modele.name}</option>
                                        `); 
                                        modelesContainer.append(option);
                                    }
                                });

                                
                                

                            },
                            error: function() {
                                console.log('Error fetching models of the marque:', marque.name);
                            },
                        });

                    });

                    marquesContainer.append(li);
                });
            },
            error: function(error) {
                console.log("Error:", error);
            }
        });
    }

    fetchMarquesAndModeles();
});
