if (data.hasPieces) {
    part.style.fill = 'red';
    part.onclick = () => {
        const popoverContent = `
            <div class="p-4">
                <div class="font-semibold text-lg mb-2">${data.pieces[0].name}</div>
                <div class="mb-2">
                    <img src="${data.pieces[0].image}" alt="Piece Image" class="w-full">
                </div>
                <div class="text-sm mb-1">Prix de Réparation: ${data.pieces[0].prix_reparation}</div>
                <div class="text-sm mb-1">Prix de Remplacement: ${data.pieces[0].prix_remplacement}</div>
                <a href="#" class="flex items-center font-medium text-blue-600 dark:text-blue-500 dark:hover:text-blue-600 hover:text-blue-700 hover:underline">Read more <svg class="w-2 h-2 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg></a>
            </div>
        `;

        // Get the existing popover div
        const popover = document.getElementById(`popover-${marqueId}`);
        console.log('popover div: ',popover);
        
        // Update the popover content
        popover.innerHTML = popoverContent;
        
        // Position the popover near the clicked part
        const partRect = part.getBoundingClientRect();
        popover.style.top = `${partRect.bottom + window.scrollY}px`;
        popover.style.left = `${partRect.left + window.scrollX}px`;
        
        // Show the popover
        popover.classList.remove('hidden');
    };
}
