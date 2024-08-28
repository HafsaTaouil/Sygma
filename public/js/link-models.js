document.addEventListener('DOMContentLoaded', function() {

    var chosenCar = document.getElementById("chosen-car");
    var marquesContainer = document.getElementById("marques-container");
    var firstModel = document.getElementsByClassName("first-model")[0];
    var modelsSelect = document.getElementById("modeles");
    var makeName= document.getElementsByClassName("make-name")[0];

    var makes = [];
    var models = [];

    var timesClicked = 0;

    function checkChosenCar() {
        //console.log(chosenCar.textContent);  

        if (chosenCar.textContent.trim() !== "Choisir la marque") {
            if(!firstModel.querySelector("h5.qst-2")){
                var h5 = document.createElement("h5");
                h5.textContent = "2- Choose the Model :";
                h5.classList.add("fontfamily");
                h5.classList.add("qst-2");
                firstModel.appendChild(h5);

                modelsSelect.style.display="flex";
                modelsSelect.classList.add("justify-text");
                modelsSelect.style.width="15%";

                firstModel.append(modelsSelect);
            }
            
        }       
    }

    marquesContainer.addEventListener('click', function(event) {
        var clickedElement = event.target;

        if (clickedElement.tagName === 'LI' || clickedElement.closest('li')) {

            var selectedMarque = clickedElement.closest('li').querySelector("div.inline-flex").textContent.trim();
            selectedMarque = selectedMarque.replace('directions_car', '').trim();
            chosenCar.textContent = selectedMarque;

            makes.push(selectedMarque);

            checkChosenCar();
        }
    });


    modelsSelect.addEventListener('change',()=>{
        if(chosenCar.textContent.trim() !== "Choisir la marque" && modelsSelect.value!=="Choisir le modèle"){
            

            const modalToggleButton = document.querySelector('[data-modal-target="progress-modal"]');
            if (modalToggleButton) {
                modalToggleButton.click();

                var marqueVal = chosenCar.textContent.split(" ");


                document.getElementsByClassName("makeSelected")[0].textContent = marqueVal;
                document.getElementsByClassName("modelSelected")[0].textContent = modelsSelect.value;
                models.push(modelsSelect.value);

            }

        }
    });

    var continueBtn = document.getElementById("continue");
    continueBtn.addEventListener('click', () => {
        timesClicked++;
    successLinking = true;

    var modelNumber = document.getElementById("model-number");
    modelNumber.textContent = "Model 2";

    make2 = chosenCar.textContent.split(" ").slice(1).join(" ");
    model2 = modelsSelect.value;

    chosenCar.textContent = "Choisir la marque";
    modelsSelect.value = "Choisir le modèle";

    document.getElementById("first-sec").textContent = "You've successfully selected the second model";
    continueBtn.textContent="Link Models";


    

    

    


    continueBtn.style.backgroundColor="#009999";


    if(timesClicked===2){
        console.log("models successfully linked!");
        modalToggle2.click();
        document.getElementById("marque1").textContent=makes[0]+" "+models[0];
        document.getElementById("marque2").textContent=makes[1]+" "+models[1];


        //WORKING ON THE BACKEND
        const make1 = makes[0];
        const model1 = models[0];
        const make2 = makes[1];
        const model2 = models[1];

       

        // Make an AJAX request to link models
    fetch('/link-models', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ make1, model1, make2, model2 }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log('Models linked successfully:');            
        }
    })
    .catch(error => console.error('Error:', error));
        
    }


});

    









});




