document.addEventListener('DOMContentLoaded', function() {

    const manualReport = document.getElementById("manual-report");
    const autoReport = document.getElementById("auto-report");
    const closeModal = document.getElementById("closeModal");

    document.getElementById("modal-overlay").style.display="block";
    document.getElementById("select-modal").style.display="flex";

    manualReport.addEventListener('click',()=>{
        document.getElementById("modal-overlay").style.display="none";
        document.getElementById("select-modal").style.display="none";
        
    });
    autoReport.addEventListener('click',()=>{
        document.getElementById("modal-overlay").style.display="none";
        document.getElementById("select-modal").style.display="none";
    });
    
    closeModal.addEventListener('click',(event)=>{
        
        event.preventDefault();
        var modalGuide = document.getElementById("modal-guide");
        modalGuide.textContent="Merci de sélectionnez l'option qui vous convient!";
        modalGuide.style.color="red";
        
        

    });

    var ulsContainer = document.getElementById("uls-container");
    var rectoVersoImport = document.getElementById("recto-verso");
    var divContainer = document.getElementById("report-creation-via-vrd1"); 
    var iCG = document.getElementById("iCG");
    const form1 = document.getElementsByClassName("report-creation-via-vrd1")[0];

    function validateImmatriculationInput(numberEntered) {
        const moroccoRegex = /^[1-9٠-٩]{1,5}[\s|][أبدهوطABDHET][\s|][1-9٠-٩]{1,2}$/;
    
        return moroccoRegex.test(numberEntered);
    }


    document.getElementById('submit_all').addEventListener('submit', function(event) {
        
        event.preventDefault(); 
    
        const uls = ulsContainer.getElementsByTagName('ul');
        const ul1 = uls[0];
        const ul2 = uls[1];
        const inputElements1 = ul1.getElementsByTagName("input");
        const inputElements2 = ul2.getElementsByTagName("input");
        const inputElements = [...inputElements1, ...inputElements2];
    
        let isValid = true; 
    
        inputElements.forEach(input => {

            if(input.parentElement.id==='numero'){
                const errorMessage = input.nextElementSibling;
                if (input.value.trim() === "" || !validateImmatriculationInput(input.value)) {
                    isValid = false; 
                    errorMessage.textContent = "The registration number should be in the format: '12345 | أ | 67'.";
                    errorMessage.style.display = "block";
                } else {
                    errorMessage.textContent = "";
                    errorMessage.style.display = "none";
                }
            }
            else if(input.parentElement.id=="modele"){
                
            }
            else if(input.parentElement.id=="premiere"){
                const dateFormatRegex = /^\d{2}-[A-Za-z]{3}-\d{4}$/;
                const errorMessage = input.nextElementSibling;
                if (input.value.trim() === "" || !dateFormatRegex.test(input.value) ) {
                    isValid = false; 
                    errorMessage.textContent = "The First Registration date should be in the format: '24-Aug-2019";
                    errorMessage.style.display = "block";
                } else {
                    errorMessage.textContent = "";
                    errorMessage.style.display = "none";
                }
            }
            else{
                const errorMessage = input.nextElementSibling;
                if (input.value.trim() === "") {
                    isValid = false; 
                    errorMessage.textContent = "This field is required";
                    errorMessage.style.display = "block";
                } else {
                    errorMessage.textContent = "";
                    errorMessage.style.display = "none";
                }
            }
        });
    
        if (isValid) {
            this.submit();
        } else {
            console.log("Form submission prevented due to empty fields.");
        }
    });
    

        

    


    
    const toggleModalButton = document.getElementById('toggleModal');
    const selectModal = document.getElementById('select-modal');
    const modalOverlay = document.getElementById('modal-overlay');
    function hideModal() {
        if (selectModal && modalOverlay) {
            selectModal.remove();
            modalOverlay.remove();
            toggleModalButton.remove();
            
        }
    }
    

    if (toggleModalButton) {

        const event = new Event('click');
        toggleModalButton.dispatchEvent(event);
        console.log("btn clicked");
    } else {
        console.error("Button with ID 'toggleModal' not found.");
    }

    

    function manualCreation() {
        divContainer.style.display = "block";
        ulsContainer.style.display = "flex";
        rectoVersoImport.style.display = "none";
        document.querySelector(".recto-verso").textContent = "Remplir les champs suivants | Carte grise";
        const uls = ulsContainer.getElementsByTagName("ul");
        const inputElements = [...uls[0].getElementsByTagName("input"), ...uls[1].getElementsByTagName("input")];
        
        // for (const input of inputElements) {
        //     if (input.value === "") {
        //         input.style.backgroundColor = "white";
        //     }
        //     input.addEventListener("input", () => {
        //         input.style.backgroundColor = input.value === "" ? "#D37676" : "white";
        //     });
        // }


        validateInputs();

    }

    function showFirstForm() {
        rectoVersoImport.style.display = "flex";
        ulsContainer.style.display = "none";
        iCG.style.display = "block";
        form1.style.display = "block";
    }

    function autoCreation() {
        divContainer.style.display = 'block';
        showFirstForm();
        rectoVersoImport.style.display = "flex";
        iCG.style.display = "flex";
        document.querySelector(".recto-verso").textContent = "Remplir les champs suivants | Carte grise";
        form1.style.display = 'block';
    }

    //const continueModal = document.getElementById("continueModal");
    

    var optionSelected = false;

    // Check if the elements exist
    if (manualReport  && closeModal) {

        manualReport.addEventListener('click',()=>{
            
            document.getElementById("toggleModal").style.display="none";

            manualCreation();
            hideModal();
           
            
        });
        autoReport.addEventListener('click',()=>{
            
            document.getElementById("toggleModal").style.display="none";
            autoCreation();
            hideModal();
            

            
        });

    } else {
        console.error("One or more elements with the specified IDs do not exist in the DOM.");
    }
});
