document.addEventListener('DOMContentLoaded', function() {


    const toggleModalButton = document.getElementById('toggleModal');
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

    let manualOrAutomatic = "none";
    const continueModal = document.getElementById("continueModal");
    const manualReport = document.getElementById("manual-report");
    const autoReport = document.getElementById("auto-report");
    const closeModal = document.getElementById("closeModal");

    // Check if the elements exist
    if (manualReport && continueModal && closeModal) {
        manualReport.addEventListener('click', () => {
            console.log("manualll clicked");
            manualOrAutomatic = 'manual';
        });
        autoReport.addEventListener('click', () => {
            console.log("autooo clicked");
            manualOrAutomatic = 'auto';
        });

        continueModal.addEventListener('click', () => {
            console.log("continue clicked");
            if (manualOrAutomatic === 'manual' || manualOrAutomatic === 'auto') {
                closeModal.click();
                if (manualOrAutomatic === 'manual') {
                    console.log("continue with manual creation");
                    manualCreation();
                } else if (manualOrAutomatic === 'auto') {
                    console.log("continue with auto creation");
                    autoCreation();
                }
            }
        });
    } else {
        console.error("One or more elements with the specified IDs do not exist in the DOM.");
    }
});
