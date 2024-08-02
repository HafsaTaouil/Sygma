document.addEventListener('DOMContentLoaded', function() {

    function triggerEscapeKey() {
        const event = new KeyboardEvent('keydown', {
            key: 'Escape',
            keyCode: 27,
            code: 'Escape',
            which: 27,
            bubbles: true,
            cancelable: true
        });
        document.dispatchEvent(event);
    }

    
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

    var ulsContainer = document.getElementById("uls-container");
    var rectoVersoImport = document.getElementById("recto-verso");
    var divContainer = document.getElementById("report-creation-via-vrd1"); 
    var iCG = document.getElementById("iCG");
    const form1 = document.getElementsByClassName("report-creation-via-vrd1")[0];

    function manualCreation() {
        divContainer.style.display = "block";
        ulsContainer.style.display = "flex";
        rectoVersoImport.style.display = "none";
        document.querySelector(".recto-verso").textContent = "Remplir les champs suivants | Carte grise";
        const uls = ulsContainer.getElementsByTagName("ul");
        const inputElements = [...uls[0].getElementsByTagName("input"), ...uls[1].getElementsByTagName("input")];
        
        for (const input of inputElements) {
            if (input.value === "") {
                input.style.backgroundColor = "#D37676";
            }
            input.addEventListener("input", () => {
                input.style.backgroundColor = input.value === "" ? "#D37676" : "white";
            });
        }
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
    const manualReport = document.getElementById("manual-report");
    const autoReport = document.getElementById("auto-report");
    const closeModal = document.getElementById("closeModal");

    // Check if the elements exist
    if (manualReport  && closeModal) {

        manualReport.addEventListener('click',()=>{
            
            manualCreation();
            hideModal();
            triggerEscapeKey();
            triggerEscapeKey();
            
        });
        autoReport.addEventListener('click',()=>{
            
            autoCreation();
            hideModal();
            triggerEscapeKey();
            triggerEscapeKey();
            
        });

    } else {
        console.error("One or more elements with the specified IDs do not exist in the DOM.");
    }
});
