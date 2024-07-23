const reportCreationManually = document.getElementById('report-creation-manually');
var ulsContainer = document.getElementById("uls-container");
var rectoVersoImport = document.getElementById("recto-verso");
var divContainer = document.getElementById("report-creation-via-vrd1"); 
const form1 = document.getElementsByClassName("report-creation-via-vrd1")[0];






function toggleDisableDiv(){
    const div = document.getElementsByClassName('p-5')[0];
    div.classList.toggle('disabled');
}

function validateImmatriculationInput(numberEntered){

    const moroccoRegex = /^\d{1,5} [\u0600-\u06FF] \d{1,2}$/;
    const franceOldRegex = /^[A-Z]{2}-\d{3}-[A-Z]{2}$/;
    const franceNewRegex = /^[A-Z]{2}-\d{3}-[A-Z]{2}$/;  
    const algeriaOldRegex = /^\d{3} [A-Z]{1,2} \d{1,3}$/;  
    const algeriaNewRegex = /^\d{2} \d{4} \d{2}$/;  
    const tunisiaRegex = /^\d{3} \d{3}$/;

    return moroccoRegex.test(numberEntered) || franceOldRegex.test(numberEntered) || franceNewRegex.test(numberEntered) || algeriaOldRegex.test(numberEntered) || algeriaNewRegex.test(numberEntered) || tunisiaRegex.test(numberEntered);
}

// The logic for handling the "Réssayer" button si it can be hidden when th epage is loaded for the first time.

document.addEventListener('DOMContentLoaded', (event) => {
    var isButtonClicked = false;

    const button2 = document.getElementById('report-creation-via-vrd');
    const retryBtn = document.getElementById('retry-btn');

    function showRetryBtn() {
        isButtonClicked = true;
        retryBtn.style.display = "block";
    }

    reportCreationManually.addEventListener('click', showRetryBtn);
    button2.addEventListener('click', showRetryBtn);

    retryBtn.style.display = "none";
    retryBtn.addEventListener('click',()=>{
        toggleDisableDiv();
        if(divContainer.style.display!="none"){
            divContainer.style.display="none";
        }

    });

});




// The logic for the option to create the report manually

function toggleDisableDiv(){
    const div = document.getElementsByClassName('p-5')[0];
    div.classList.toggle('disabled');
}

/*
    ?the element of id 
        !report-creation-via-vrd1
        ?is the element that contains the option to import recto-verso + the fileds to be filled with the carte grise infos
*/

document.addEventListener('DOMContentLoaded', () => {

        divContainer.style.display="none";

        reportCreationManually.addEventListener('click', (event) => {

            event.preventDefault();

            console.log("reportCreation manually is clicked");

            toggleDisableDiv();

            /**
             * !
             */
            reinitializeFields();
                

            divContainer.style.display="block";

            ulsContainer.style.display = "flex";

            rectoVersoImport.style.display="none";

            document.querySelector(".recto-verso").textContent = "Remplir les champs suivants | Carte grise";

            const uls = ulsContainer.getElementsByTagName("ul");
            const ul1 = uls[0];
            const ul2 = uls[1];
            const inputElements1 = ul1.getElementsByTagName("input");
            const inputElements2 = ul2.getElementsByTagName("input");

            const inputElements = [...inputElements1, ...inputElements2];
            for(const input of inputElements){
                if (input.value == "") {
                    input.style.backgroundColor = "#D37676";
                }
                input.addEventListener("input", () => {
                    if (input.value == "") {
                        input.style.backgroundColor = "#D37676";
                    } else {
                        input.style.backgroundColor = "white";
                    }
                });
            }
    });
});





// The logic for the option to create the report via importing carte grise 







/**
 * 
 * !TO CHECK THE FIELDS PRE FILLED IF THEY ARE VALID 
 * 
 */

function checkFields(){
    var nonFilled = false;
    const uls = ulsContainer.getElementsByTagName("ul");
    const ul1 = uls[0];
    const ul2 = uls[1];
    const inputElements1 = ul1.getElementsByTagName("input");
    const inputElements2 = ul2.getElementsByTagName("input");

    const inputElements = [...inputElements1 , ...inputElements2];
    

    var marque  = document.getElementById("marque").firstElementChild;
    var modele =document.getElementById("modele").firstElementChild;

    var numero = document.getElementById("numero");


    for (const input of inputElements) {

        if(input.parentElement === numero){


            const validAndStyleInput = ()=>{
                var isImmatriculationValid = validateImmatriculationInput(input.value);
                input.style.backgroundColor = isImmatriculationValid ? 'white' :'red';
                console.log(isImmatriculationValid);
            };

            validAndStyleInput();

            input.addEventListener('input',validAndStyleInput);  
        }
        

        if(input.value=="--"){
            input.style.backgroundColor = 'red';
            nonFilled=true;
        }
        
        input.addEventListener("input", () => {
            if (input.value === "--" || input.value.trim() === "") {
                input.style.backgroundColor = 'red';
                nonFilled = true;
            } else {
                input.style.backgroundColor = 'white';
            }
        });
    }



    if(marque.value!=="--"){

            if(modele.value=="--"){
                modele.remove();
                var modeleSelect = document.createElement("select");

                let firstLetter = marque.value[0].toUpperCase();
                let rest = marque.value.slice("1").toLowerCase();
                var marqueName = firstLetter+rest;

                var encodedMarque = encodeURIComponent(marqueName);
                fetch(`/marque/modeles/${encodedMarque}`)
                .then(response => response.json())
                .then(data => {
                    var existingModeleSelect = document.getElementById('modele-ops');
                    if (existingModeleSelect) {
                        existingModeleSelect.remove();
                    }

                    modeleSelect.style.width = '200px';
                    modeleSelect.style.height = '35px';
                    modeleSelect.classList.add("bg-white", "border", "border-gray-300", "text-gray-900", "text-sm", "rounded-lg", "focus:ring-blue-500", "focus:border-blue-500", "block", "w-full", "p-2.5", "dark:bg-gray-700", "dark:border-gray-600", "dark:placeholder-gray-400", "dark:text-white", "dark:focus:ring-blue-500", "dark:focus:border-blue-500");
                    modeleSelect.setAttribute("id", "modele-ops");

                    var defaultOption = document.createElement('option');
                    defaultOption.value = '--';
                    defaultOption.text = '-- Select Modele --';
                    modeleSelect.appendChild(defaultOption);

                    data.forEach(modele => {
                        var option = document.createElement('option');
                        option.value = modele.id;
                        option.text = modele.name;
                        modeleSelect.appendChild(option);
                    });

                    if(modeleSelect.options[modeleSelect.selectedIndex].text==="-- Select Modele --"){
                            console.log("haha yes thats red");
                            modeleSelect.style.backgroundColor="red";
                    }
                    modeleSelect.addEventListener("change",()=>{
                         if(modeleSelect.options[modeleSelect.selectedIndex].text==="-- Select Modele --"){
                            console.log("haha yes thats red");
                            modeleSelect.style.backgroundColor="red";
                         }else{
                            modeleSelect.style.backgroundColor="white";

                         }
                    })    
                    var modele = document.getElementById('modele');
                    var modeleInput = modele.firstElementChild;
                    modeleInput.value = modeleSelect.value;

                    })
                    .catch(error => {
                        console.error('Error fetching models:', error);
                    });

                document.getElementById("modele").appendChild(modeleSelect);
            }
        }
    return nonFilled;
};









function showFirstForm(){
    var iCG=document.getElementById("iCG");

    rectoVersoImport.style.display="flex";
    ulsContainer.style.display="none";
    iCG.style.display="block";
    form1.style.display="block";
}

var reportCreationViaVrd = document.getElementById("report-creation-via-vrd");
    reportCreationViaVrd.addEventListener('click',()=>{
        
        toggleDisableDiv();
        divContainer.style.display='block';
        console.log("création via vrd");
        showFirstForm();
        rectoVersoImport.style.display="flex";
        iCG.style.display="flex";
        document.querySelector(".recto-verso").textContent = "Remplir les champs suivants | Carte grise";
        form1.style.display = 'block';
        
    //by default the following element is on display none
    // document.getElementById("uls-container").style.display="none";

    });


    


    //here the logic to handle the results after fetching the fields of the uls container from the api

    function modalTextDone(){
        const modalText = document.getElementById('modalText');
        ulsContainer.style.display = 'flex';
        rectoVersoImport.style.display="none";
        document.querySelector(".recto-verso").textContent="Informations | Carte grise";

        checkFields();
        if(checkFields()==true){
            //console.log("yes missing fields exist");
            const spanElem = document.createElement("span");
            spanElem.textContent = "Champs manquants!";
            spanElem.classList.add("font-medium");

            const divElem = document.createElement("div");

            divElem.appendChild(spanElem);

            divElem.appendChild(document.createTextNode(" Merci de remplir les champs en rouge manuellement."));
            divElem.classList.add("p-4", "mb-4", "text-sm", "text-red-800", "rounded-lg", "bg-red-50", "dark:bg-gray-800", "dark:text-red-400");
            divElem.setAttribute("role", "alert");
            divElem.setAttribute("id","error-missing-fields");
            ulsContainer.parentElement.appendChild(divElem);
        }
        

    }