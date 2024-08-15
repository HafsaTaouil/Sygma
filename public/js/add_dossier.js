const reportCreationManually = document.getElementById('report-creation-manually');
var ulsContainer = document.getElementById("uls-container");
var rectoVersoImport = document.getElementById("recto-verso");
var divContainer = document.getElementById("report-creation-via-vrd1"); 
const form1 = document.getElementsByClassName("report-creation-via-vrd1")[0];



function validateImmatriculationInput(numberEntered) {
    const moroccoRegex = /^[1-9٠-٩]{1,5}[\s|][أبدهوطABDHET][\s|][1-9٠-٩]{1,2}$/;

    return moroccoRegex.test(numberEntered);
}



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
    

    var marque  = document.getElementById("marque").children[1];
    var modele =document.getElementById("modele").children[1];


    for (const input of inputElements) {
        if(input.parentElement.id!=="modele"){

            if(input.parentElement.id==='numero'){
                const errorMessage = input.nextElementSibling;
                if (input.value.trim() === "" || !validateImmatriculationInput(input.value)) {
                    errorMessage.textContent = "The registration number should be in the format: '12345 | أ | 67'.";
                    errorMessage.style.display = "block";
                } else {
                    errorMessage.textContent = "";
                    errorMessage.style.display = "none";
                }
            }
            else{
                const errorMessage = input.nextElementSibling;
                
                if (input.value.trim() === "" || input.value.trim() === "--") {
                    errorMessage.textContent = "This field is required";
                    errorMessage.style.display = "block";
                } else {
                    errorMessage.textContent = "";
                    errorMessage.style.display = "none";
                }
            }

        }
    }


    if(marque.value!=="--"){
            if(modele.value=="--"){
                modele.remove();
                var modeleSelect = document.createElement("select");

                modeleSelect.style.minWidth="100%";

                let firstLetter = marque.value[0].toUpperCase();
                let rest = marque.value.slice("1").toLowerCase();
                console.log("rest: \n"+rest);
                var marqueName = firstLetter+rest;

                console.log("marque name: \n"+marqueName);

                var encodedMarque = encodeURIComponent(marqueName);
                fetch(`/marque/modeles/${encodedMarque}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Fetched data:', data);
                    var existingModeleSelect = document.getElementById('modele-ops');
                    if (existingModeleSelect) {
                        existingModeleSelect.remove();
                    }

                    modeleSelect.style.width = '200px';
                    modeleSelect.style.height = '35px';
                    modeleSelect.classList.add("bg-white", "border", "border-gray-300", "text-gray-900", "text-sm", "rounded-lg", "focus:ring-blue-500", "focus:border-blue-500", "block", "w-full", "p-2.5", "dark:bg-gray-700", "dark:border-gray-600", "dark:placeholder-gray-400", "dark:text-white", "dark:focus:ring-blue-500", "dark:focus:border-blue-500");
                    modeleSelect.setAttribute("id", "modele-ops");
                    modeleSelect.setAttribute("name","data[Machine][modele]");
                    var defaultOption = document.createElement('option');
                    defaultOption.value = '--';
                    defaultOption.text = '-- Select Modele --';
                    modeleSelect.appendChild(defaultOption);
                    var modeles = [];
                    data.forEach(modele => {
                        var option = document.createElement('option');
                        option.value = modele.id;
                        option.text = modele.name;
                        if(!modeles.includes(option.text)){
                            if(option.text!=="--"){
                                modeles.push(option.text);
                                modeleSelect.appendChild(option);
                            }
                        }
                        
                    });

                    if(modeleSelect.options[modeleSelect.selectedIndex].text==="-- Select Modele --"){
                            const span = document.createElement('span');
                            span.classList.add("error-message","text-red-600","text-xs");
                            span.textContent = "Brand selection is required.";
                            span.style.display = "block";
                            modeleSelect.parentElement.appendChild(span);

                            
                    }else{
                        span.textContent = "";
                        span.style.display = "none";
                    }
                      
                    var modele = document.getElementById('modele');
                    var modeleInput = modele.children[1];
                    modeleInput.value = modeleSelect.value;

                    })
                    .catch(error => {
                        console.error('Error fetching models:', error);
                    });
                modeleSelect.style.backgroundColor="white";
                modeleSelect.style.color="black";
                document.getElementById("modele").appendChild(modeleSelect);
            }
        }
    return nonFilled;
};













    


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



    //The logic for showing the model once the page is loaded 
    
    
    


  


    

    
    
