<x-app-layout>
    <div class="p-4 md:ml-52 grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-4" id="gridContainer">
        <h1 class="text-2xl font-bold mb-6 col-span-full">Marques</h1>
        <div class="flex flex-row gap-2 items-center col-span-full mb-4">
            <input type="text" placeholder="Search..." class="w-3/4 border-2 rounded-full border-[#009999] px-4 py-2">
            <i class="fa-solid fa-magnifying-glass bg-[#009999] px-4 py-2 rounded-full text-white text-xl"></i>

            <!-- Modal toggle Ajout Marque -->
            <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                class="flex items-center text-white bg-[#009999] hover:bg-[#008080] transition-all rounded-full px-4 py-3"
                type="button">
                <i class="fas fa-plus mr-2"></i> Ajouter Nouvelle Marque
            </button>

            <!-- Main modal Ajout Marque -->
            <div id="crud-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Créer une nouvelle marque
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-toggle="crud-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form class="p-4 md:p-5" method="POST" action="{{ route('marques.store') }}">
                            @csrf
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="name"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Marque</label>
                                    <input type="text" name="name" id="name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Entrez la marque ..." required>
                                </div>
                            </div>
                            <button type="submit"
                                class="flex items-center text-white bg-[#009999] hover:bg-[#008080] transition-all rounded-full px-4 py-3">
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Ajouter
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($marques as $marque)
            <div class="bg-white rounded-lg shadow-md p-4 transition-all duration-300 marque-card flex justify-around"
                id="marque-{{ $marque->id }}">
                <div>
                    <h2 class="text-xl font-semibold mb-2 cursor-pointer" onclick="toggleModeles({{ $marque->id }})">
                        {{ $marque->name }}
                    </h2>
                </div>
                <div id="modeles-{{ $marque->id }}"
                class="hidden overflow-y-auto w-3/4 transition-max-height duration-300 modeles-container" style="max-height: 400px;"></div>
                </div>
        @endforeach
    </div>


    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

    // sweet SweetAlert
            console.log("success!!!");
        @if(session('marque_created'))
            Swal.fire({
                title: 'Success!',
                text: 'Marque créée avec succès.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        async function toggleModeles(marqueId) {
            const modelesDiv = document.getElementById(`modeles-${marqueId}`);
            const marqueCard = document.getElementById(`marque-${marqueId}`);
            const gridContainer = document.getElementById('gridContainer');

            if (modelesDiv.classList.contains('hidden')) {
                try {
                    const response = await fetch(`/marques/${marqueId}/modeles`);
                    const data = await response.json();

                    modelesDiv.innerHTML = '';
                    data.forEach(modele => {
                        const modeleDiv = document.createElement('div');
                        modeleDiv.classList.add('bg-gray-100', 'p-2', 'rounded', 'mt-2');
                        modeleDiv.innerHTML = `
                        <div class="flex flex-row justify-between">
                            <div class="cursor-pointer">
                                <span style="cursor: pointer;" onclick="showSVG(${modele.id})">${modele.name}</span>
                                <div id="content-modele-${modele.id}" class="hidden"></div>
                            </div>
                            <div id="svgContainer-${modele.id}" class="hidden"></div>
                        </div>

                `;
                        modelesDiv.appendChild(modeleDiv);
                    });

                    modelesDiv.classList.remove('hidden');
                    gridContainer.classList.replace('lg:grid-cols-4', 'grid-cols-1');
                    marqueCard.classList.add('col-span-full');//col-span-full
                } catch (error) {
                    console.error('Error fetching and displaying modeles:', error);
                }
            } else {
                modelesDiv.classList.add('hidden');
                gridContainer.classList.replace('grid-cols-1', 'lg:grid-cols-4');
                marqueCard.classList.remove('col-span-full');
            }
        }


        //show svg
        function showSVG(modeleId) {
            const svgContainer = document.getElementById(`svgContainer-${modeleId}`);
            if (svgContainer.classList.contains('hidden')) {
                const bgImage = $(`.mapPath[data-id='${modeleId}']`).attr('data-bg');

                const svgContent = `
            <svg id="carSvg" class="m-auto w-fit md:w-full relative bottom-8" viewBox="180 -400 1500 1800"
                                xmlns="http://www.w3.org/2000/svg" id="car-map">
                                <g id="layer2" transform="matrix(0, 1, -1, 0, 254.000085527972, -254.000194186645)" style="transform-origin: 555.665px 834.02px;">
                                    <g id="g4113" transform="translate(-13.78 3.524)">
                                        <path class="mapPath" data-bg="https://www.aureliacar.com/Files/29327/Img/09/FT02146-SX-Aile-arriere-gauche-FIAT-500-phase-1--2007-2015--Neuve-a-peindre_1x800.jpg" data-id-name="14" data-name="Aile arriere gauche" data-id="path3070" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: rgb(255, 255, 255);" d="M 357.43 1085.43 C 393.14 1062.57 494.57 1006.86 494.57 1006.86 C 536 991.14 634.57 995.43 686 994 C 737.43 992.57 777.248 996.088 818.148 1012.998 C 859.148 1029.928 936.567 1087.874 953.267 1093.074 C 976.067 1100.214 1080.3 1101.14 1118.9 1114 C 1157.4 1126.86 1144.6 1146.86 1144.6 1146.86 L 1114.6 1142.57 L 1108.8 1195.49 C 1108.8 1195.49 1146 1196.86 1150.3 1211.14 C 1154.6 1225.43 1156 1242.57 1147.4 1252.57 C 1138.9 1262.6 1133.1 1251.14 1128.9 1265.4 C 1124.6 1279.7 1126 1294 1101.7 1292.6 C 1077.4 1291.1 1003.1 1292.6 1003.1 1292.6 C 1003.1 1292.6 987.4 1184 904.6 1186.86 C 821.7 1189.71 808.9 1292.6 808.9 1292.6 L 361.599 1292.6" data-name="Aile arriere gauche" data-severity="0"></path>
                                        <path class="mapPath" data-bg="https://www.pieces-auto-moins-cher.fr/1111465/aile-avant-gauche-clio-0419.jpg" data-id-name="8" data-name="Aile avant gauche" data-id="path30701" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[8]) ? 'rgb(' . $colors[$index] . ')' : 'rgb(255, 255, 255)' }};" d="M 361.599 1292.6 L 308.86 1292.6 C 308.86 1292.6 303.14 1188.29 211.71 1186.86 C 120.29 1185.43 113.14 1292.6 113.14 1292.6 L 47.43 1292.6 L 28.86 1254 C 28.34 1254 2.61 1254 7.43 1236.86 C 12.08 1220.3 3.14 1195.43 24.57 1195.43 C 46 1195.43 71.71 1196.86 71.71 1196.86 L 87.43 1152.57 L 46 1149.71 C 46 1149.71 80.29 1125.43 164.57 1116.86 C 248.86 1108.29 321.71 1108.29 357.43 1085.43 L 361.599 1292.6 Z" data-name="Aile avant gauche" data-severity="0">
                                            <title>Path</title>
                                        </path>
                                        <path class="mapPath" data-bg="https://salmia.ma/wp-content/uploads/2023/02/Porte-avant-gauche-PEUGEOT-3008.jpg" data-id-name="10" data-name="Porte avant gauche" data-id="path3900" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[10]) ? 'rgb(' . $colors[$index] . ')' : 'rgb(255, 255, 255)' }};" d="M 886.971 1038.45 L 878.308 983.581 L 873.976 934.969 L 877.826 867.105 L 881.196 845.446 L 886.971 740.039 L 834.99 740.521 L 775.789 746.778 L 752.205 751.109 L 735.841 759.292 L 670.383 797.315 L 599.64 837.66 C 585.56 868.63 581.34 909.45 581.34 931.97 C 581.34 954.49 585.56 1024.944 603.86 1038.944 L 886.971 1038.45 Z" transform="translate(-254 254)" data-name="Porte avant gauche" data-severity="0"></path>
                                        <path class="mapPath" data-bg="https://salmia.ma/wp-content/uploads/2023/02/Porte-arriere-gauche-Peugeot-5008.jpg" data-id-name="12" data-name="Porte arriere gauche" data-id="path39006" d="M 680.781 993.783 L 732.762 994.746 L 779.2 1000.17 C 797.5 1012.84 835.5 1050.84 872.1 1104.33 C 908.7 1157.82 880.5 1163.45 853.8 1178.93 C 827 1194.42 804.5 1221.641 786.2 1291.981 L 632.78 1292.419 C 627.15 1267.119 620.12 1209.9 620.12 1187.4 C 621.29 1151.3 622.6 1118.8 626.27 1100.1 C 628.74 1075 631.38 1000.204 632.78 994.574 L 680.781 993.783 Z" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[12]) ? 'rgb(' . $colors[12] . ')' : 'rgb(255, 255, 255)' }};" data-name="Porte arriere gauche" data-severity="0"></path>
                                        <path class="mapPath" data-name="" data-id="path3884" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: rgb(255, 255, 255)" d="m618.57 847.14c15.72-18.57 123.38-81.52 151.43-88.57 29.5-7.41 103-7.14 103-7.14l-7.14 95.71z" transform="translate(-254 254)"></path>
                                        <path class="mapPath" data-name="" data-id="path3892" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: rgb(255, 255, 255)" d="m898.7 752.84-4.29 94.32h207.19c-11.3-20.75-46.6-74.9-72.9-88.57-14.3-10-82.86-4.33-130-5.75z" transform="translate(-254 254)"></path>
                                    </g>
                                    <path class="mapPath" data-bg="https://salmia.ma/wp-content/uploads/2023/02/Pare-choc-arriere-DS-DS3-PHASE-2-doccasion.jpeg" data-id-name = "19" data-name="Pare-choc arriere" data-id="path43810" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[19]) ? 'rgb(' . $colors[19] . ')' : 'rgb(255, 255, 255)' }};" d="M 1267.042 624.97 C 1267.042 624.97 1336.7 623.56 1336.7 646.09 L 1336.7 1017.7 C 1336.7 1040.2 1264.271 1043 1264.271 1043" data-name="Pare-choc arriere" data-severity="2"></path>

                                    <g id="g4451" transform="translate(-13.78 15.524)">
                                        <path class="mapPath" data-bg="https://www.piece-carrosserie-discount.com/image/pare-chocs-183428.jpg" data-id-name = "2" data-name="Pare-choc avant" data-id="path4175" style="stroke:#000000;stroke-width:5;fill:{{ isset($colors[19]) ? 'rgb(' . $colors[19] . ')' : 'rgb(255, 255, 255)' }}" d="m736.17 416.79s94.31 5.63 152.02 5.63c106.98 0 201.31-5.63 201.31-5.63m-1.4 297s-77.4-5.63-199.91-5.63c-68.97 0-152.02 7.04-152.02 7.04" transform="translate(-254 254)"></path>

                                        <path class="mapPath" data-bg="https://www.piece-carrosserie-discount.com/image/capot-moteur-183402.png" data-id-name = "5" data-name="Capot" data-id="path41359" d="m345.78 632.78h-294.19l-14.076 102.76-7.038 11.26v142.17l7.038 14.07 15.483 101.36h288.55" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[5]) ? 'rgb(' . $colors[5] . ')' : 'rgb(255, 255, 255)' }};" data-name="Capot" data-severity="0"></path>

                                        <path class="mapPath" data-bg="https://fs.opisto.fr/Pictures/4672/2024_3/84616834-48726a0b5100799397a26b05e50c561ec9b497f31927b46991d42e2bdac21195.jpg" data-id-name = "16" data-name="Malle" data-id="path15" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[16]) ? 'rgb(' . $colors[16] . ')' : 'rgb(255, 255, 255)' }};" d="M 1282.678 961.782 L 1282.677 677.454 L 1214.68 677.456 L 1214.68 961.786 L 1282.678 961.782 Z M 832.7 670.79 C 832.7 670.79 820 718.65 820 743.98 L 820 890.37 C 820 915.71 832.7 967.79 832.7 967.79 L 1038.2 1005.8 L 1146.6 1005.8 C 1146.6 1005.8 1160.6 924.16 1160.6 890.37 L 1160.6 742.58 C 1160.6 704.57 1146.6 632.78 1146.6 632.78 L 1038.2 632.78 L 832.7 670.79 Z" data-name="Malle" data-severity="2"></path>

                                        <path class="mapPath" data-bg="https://voiture.kidioui.fr/image/lexique/pare-brise-athermique.jpg" data-id-name = "6" data-name="Pare-brise avant" data-id="path4165" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[6]) ? 'rgb(' . $colors[6] . ')' : 'rgb(255, 255, 255)' }};" d="M 595.41 378.78 L 736.17 416.79 C 736.17 416.79 727.73 466.01 727.73 488.75 L 727.73 636.37 C 727.73 667.34 736.17 715.2 736.17 715.2 L 595.41 748.98 C 595.41 748.98 578.17 687.08 578.17 656.08 C 578.55 622.28 580.28 470.28 580.28 470.28 C 578.87 439.31 595.41 378.78 595.41 378.78 L 595.41 378.78 Z" transform="translate(-254 254)" data-name="Pare-brise avant" data-severity="0"></path>

                                        <path class="mapPath" data-bg="https://assets-global.website-files.com/6413856d54d41b5f298d5953/64d63826f8cdfc369418fed1_lunette-arriere-automobile.jpeg" data-id-name = "15" data-name="Pare-brise arriere" data-id="path4205" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[15]) ? 'rgb(' . $colors[15] . ')' : 'rgb(255, 255, 255)' }};" d="m1097.9 435.09s-8.4 40.82-8.4 56.3v144.98c0 19.71 7 57.72 7 57.72s94.3 26.74 123.9 26.74h42.2v-312.49h-47.8c-25.4 0-116.9 26.75-116.9 26.75z" transform="translate(-254 254)" data-name="Pare-brise arriere" data-severity="0"></path>

                                    </g>
                                    <path class="mapPath" data-bg="https://www.piece-carrosserie-discount.com/image/pare-chocs-183428.jpg" data-id-name = "2" data-name="Pare-choc avant" data-id="path4245" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[2]) ? 'rgb(' . $colors[2] . ')' : 'rgb(255, 255, 255)' }};" d="M -74.052 1042.25 L -45.91 1042.1 C -17.754 1042.1 -23.38 1019.6 -23.38 1019.6 L -23.38 923.9 C -36.06 923.9 -34.65 914.29 -34.65 907.01 L -34.65 757.81 C -34.2 738.92 -24.79 740.92 -24.79 740.92 L -23.38 649.42 C -23.38 649.42 -16.855 626.389 -47.821 624.989 C -78.791 623.579 -75.919 624.665 -76.336 624.523 C -76.753 624.38 -144.37 622.97 -144.37 645.49 L -144.37 1017.1 C -144.37 1039.6 -74.052 1042.25 -74.052 1042.25 Z" data-name="Pare-choc avant" data-severity="0"></path>
                                    <g id="g4428" transform="translate(-13.78 15.524)">
                                        <path class="mapPath" data-bg="https://www.piece-carrosserie-discount.com/image/pare-chocs-183428.jpg" data-id-name = "7" data-name="Aile avant droit" data-id="path38526" d="M 373.313 355.9 L 308.86 355.9 C 308.86 355.9 303.14 460.19 211.71 461.61 C 120.29 463.04 113.14 355.9 113.14 355.9 L 47.429 355.9 L 28.857 394.47 C 28.342 394.47 2.614 394.47 7.429 411.61 C 12.08 428.18 3.143 453.04 24.571 453.04 C 46 453.04 71.714 451.61 71.714 451.61 L 87.429 495.9 L 46 498.76 C 46 498.76 80.286 523.04 164.57 531.61 C 248.86 540.19 321.71 540.19 357.43 563.04" style="stroke: rgb(0, 0, 0); stroke-width: 5px; fill: {{ isset($colors[7]) ? 'rgb(' . $colors[7] . ')' : 'rgb(255, 255, 255)' }};" data-name="Aile avant droit" data-severity="0"></path>
                                        <path class="mapPath" data-bg="https://www.piecesvoiturettes.fr/1761-large_default/friendly-url-autogeneration-failed.jpg" data-id-name = "13" data-name="Aile arriere droit" data-id="path385267" d="M 373.313 355.9 L 808.86 355.9 C 808.86 355.9 821.71 458.76 904.57 461.61 C 987.43 464.47 1003.1 355.9 1003.1 355.9 C 1003.1 355.9 1077.4 357.33 1101.7 355.9 C 1126 354.47 1124.6 368.76 1128.9 383.04 C 1133.1 397.33 1138.9 385.9 1147.4 395.9 C 1156 405.9 1154.6 423.04 1150.3 437.33 C 1146 451.61 1108.8 452.98 1108.8 452.98 L 1114.6 505.9 L 1144.6 501.61 C 1144.6 501.61 1157.4 521.61 1118.9 534.47 C 1080.3 547.33 975.802 558.017 953.002 565.157 C 936.302 570.357 853.501 620.391 812.511 637.321 C 771.551 654.231 737.43 655.9 686 654.47 C 634.57 653.04 536 657.33 494.57 641.61 C 494.57 641.61 393.14 585.9 357.43 563.04" style="stroke: rgb(0, 0, 0); stroke-width: 5px; fill: {{ isset($colors[13]) ? 'rgb(' . $colors[13] . ')' : 'rgb(255, 255, 255)' }};" data-name="Aile arriere droit" data-severity="0"></path>

                                        <path class="mapPath" data-bg="https://fs.opisto.fr/Pictures/4481/2023_1/Piece-Porte-avant-droit-801001895R-DACIA-LOGAN-1-PHASE-1-deab956cb50582ae623aece05c3df1d4929bb97179869cebfb401fe22e570376_mtn.jpg" data-id-name = "9" data-name="Porte avant droite" data-id="path39004" d="M 345.64 556.81 C 331.56 525.84 327.34 485.02 327.34 462.5 C 327.34 439.98 331.56 371.01 349.86 356.93 L 635.128 355.533 L 626.117 398.01 L 620.325 451.428 L 622.256 506.133 L 627.405 560.195 L 633.197 655.446 L 570.769 654.802 L 508.984 647.723 L 474.23 632.277 L 345.64 556.81 Z" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[9]) ? 'rgb(' . $colors[9] . ')' : 'rgb(255, 255, 255)' }};" data-name="Porte avant droite" data-severity="0"></path>

                                        <path class="mapPath" data-bg="https://fs.opisto.fr/Pictures/4481/2023_1/Piece-Porte-avant-droit-801001895R-DACIA-LOGAN-1-PHASE-1-deab956cb50582ae623aece05c3df1d4929bb97179869cebfb401fe22e570376_mtn.jpg" data-id-name = "11" data-name="Porte arriere droite" data-id="path39422" d="M 720.688 654.344 L 632.78 655.34 C 631.38 649.71 628.74 573.44 626.27 548.41 C 622.6 529.69 621.29 497.19 620.12 461.09 C 620.12 438.57 627.15 380.86 632.78 355.52 L 786.21 356.23 C 804.51 426.61 827.03 454.06 853.78 469.54 C 880.52 485.02 908.67 490.65 872.08 544.14 C 835.48 597.63 797.47 635.64 779.17 648.3 L 720.688 654.344 Z" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[11]) ? 'rgb(' . $colors[11] . ')' : 'rgb(255, 255, 255)' }};" data-name="Porte arriere droite" data-severity="0"></path>

                                        <path class="mapPath" data-name="" data-id="path38965" d="m644.7 641.63-4.29-94.32h207.17c-11.31 20.75-46.62 74.9-72.86 88.57-14.29 10-82.88 4.33-130.02 5.75z" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: rgb(255, 255, 255);"></path>
                                        <path class="mapPath" data-name="" data-id="path38844" d="m364.57 547.33c15.72 18.57 123.38 81.52 151.43 88.57 29.5 7.41 103 7.14 103 7.14l-7.14-95.71z" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: rgb(255, 255, 255);"></path>
                                    </g>
                                    <path class="mapPath" data-bg="https://fs.opisto.fr/Pictures/4481/2023_1/Piece-Porte-avant-droit-801001895R-DACIA-LOGAN-1-PHASE-1-deab956cb50582ae623aece05c3df1d4929bb97179869cebfb401fe22e570376_mtn.jpg" data-id-name = "4" data-name="Feu avant gauche" data-id="path4361" style="stroke: rgb(0, 0, 0); stroke-width: 5px; paint-order: stroke; fill: {{ isset($colors[4]) ? 'rgb(' . $colors[$index] . ')' : 'rgb(255, 255, 255)' }};" d="M -71.88 985.879 L -71.88 948.339 L -49.35 948.339 L -26.83 948.339 L -26.83 985.879 L -26.83 1023.376 L -49.35 1023.376 L -71.88 1023.376 L -71.88 985.879 Z" data-name="Feu avant gauche" data-severity="0"></path>

                                    <path class="mapPath" data-bg="https://www.piece-carrosserie-discount.com/image/10533-183437.jpg" data-id-name = "3" data-name="Feu avant droit" data-id="path4363" style="stroke-width: 5px; stroke: rgb(0, 0, 0); paint-order: stroke; fill: {{ isset($colors[3]) ? 'rgb(' . $colors[$index] . ')' : 'rgb(255, 255, 255)' }};" d="M -71.88 681.701 L -71.88 642.757 L -49.35 642.757 L -26.83 642.757 L -26.83 681.701 L -26.83 720.644 L -49.35 720.644 L -71.88 720.644 L -71.88 681.701 Z" data-name="Feu avant droit" data-severity="0"></path>

                                    <path class="mapPath" data-name="" data-id="path4610" style="stroke:#000000;stroke-width:2;fill:#c8c8c8" d="m195.66 202.84a76.01 76.01 0 1 1 -152.02 0 76.01 76.01 0 1 1 152.02 0z" transform="translate(78.489 1074.7)"></path>
                                    <path class="mapPath" data-name="" data-id="path4612" style="stroke:#000000;stroke-width:2;fill:#ffffff" d="m147.8 72.633a44.339 44.339 0 1 1 -88.681 0 44.339 44.339 0 1 1 88.681 0z" transform="translate(94.676 1204.9)"></path>
                                    <path class="mapPath" data-name="" data-id="path46109" style="stroke: rgb(0, 0, 0); stroke-width: 2; fill: rgb(200, 200, 200);" d="m195.66 202.84a76.01 76.01 0 1 1 -152.02 0 76.01 76.01 0 1 1 152.02 0z" transform="translate(78.489 187.66)"></path>
                                    <path class="mapPath" data-name="" data-id="path46124" style="stroke:#000000;stroke-width:2;fill:#ffffff" d="m147.8 72.633a44.339 44.339 0 1 1 -88.681 0 44.339 44.339 0 1 1 88.681 0z" transform="translate(94.676 317.86)"></path>
                                    <path class="mapPath" data-name="" data-id="path46105" style="stroke:#000000;stroke-width:2;fill:#c8c8c8" d="m195.66 202.84a76.01 76.01 0 1 1 -152.02 0 76.01 76.01 0 1 1 152.02 0z" transform="translate(773.03 187.66)"></path>
                                    <path class="mapPath" data-name="" data-id="path46121" style="stroke:#000000;stroke-width:2;fill:#ffffff" d="m147.8 72.633a44.339 44.339 0 1 1 -88.681 0 44.339 44.339 0 1 1 88.681 0z" transform="translate(789.21 317.86)"></path>
                                    <path class="mapPath" data-name="" data-id="path46104" style="stroke:#000000;stroke-width:2;fill:#c8c8c8" d="m195.66 202.84a76.01 76.01 0 1 1 -152.02 0 76.01 76.01 0 1 1 152.02 0z" transform="translate(773.03 1074.7)"></path>
                                    <path class="mapPath" data-name="" data-id="path46123" style="stroke:#000000;stroke-width:2;fill:#ffffff" d="m147.8 72.633a44.339 44.339 0 1 1 -88.681 0 44.339 44.339 0 1 1 88.681 0z" transform="translate(789.21 1204.9)"></path>
                                    <path class="mapPath" data-bg="https://www.vignal-group.com/media/cache/Catalogue%20Product%20Pictures/Signalisation/Feuxarriere/1/5/154210_web.jpg" data-id-name = "17" data-name="Feu arriere droit" data-id="path4499" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[17]) ? 'rgb(' . $colors[17] . ')' : 'rgb(255, 255, 255)' }};" d="M 1199.9 633.86 L 1199.9 707.05 L 1267.5 707.05 L 1267.5 624 L 1242.2 609.93 L 1199.9 633.86 Z" data-name="Feu arriere droit" data-severity="0"></path>

                                    <path class="mapPath" data-bg="https://www.vignal-group.com/media/cache/Catalogue%20Product%20Pictures/Signalisation/Feuxarriere/1/5/152200_web.jpg" data-id-name = "18" data-name="Feu arriere gauche" data-id="path4501" style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[18]) ? 'rgb(' . $colors[18] . ')' : 'rgb(255, 255, 255)' }};" d="M 1199.9 963.24 L 1267.5 963.24 L 1267.5 1042.1 L 1243.6 1056.1 L 1199.9 1037.8 L 1199.9 963.24 Z" data-name="Feu arriere gauche" data-severity="0"></path>

                                    <path class="mapPath" data-bg="https://maroctl.com/wp-content/uploads/2021/01/plaques-immatriculation-min.jpg" data-id-name = "1"  data-name="Plaque immatriculation avant" data-id="path28" style="stroke-width: 5px; stroke: rgb(0, 0, 0); paint-order: stroke; fill: {{ isset($colors[1]) ? 'rgb(' . $colors[1] . ')' : 'rgb(255, 255, 255)' }};" d="M -126.593 832.725 L -126.593 735.712 L -113.949 735.712 L -101.311 735.712 L -101.311 832.725 L -101.311 929.735 L -113.949 929.735 L -126.593 929.735 L -126.593 832.725 Z" data-name="Plaque immatriculation avant" data-severity="0"></path>
                                    <path class="mapPath" data-bg="https://www.feuvert.be/articles/wp-content/uploads/2021/04/Article-Modifications-legislations-Feu-VERT-2021-plaque-immatriculation-2002.png" data-id-name = "20" data-name="Plaque immatriculation arriere" data-id="path37" style="stroke-width: 5px; stroke: rgb(0, 0, 0); paint-order: stroke; fill: {{ isset($colors[20]) ? 'rgb(' . $colors[20] . ')' : 'rgb(255, 255, 255)' }};" d="M 1292.264 833.899 L 1292.264 736.886 L 1304.908 736.886 L 1317.546 736.886 L 1317.546 833.899 L 1317.546 930.909 L 1304.908 930.909 L 1292.264 930.909 L 1292.264 833.899 Z" data-name="Plaque immatriculation arriere" data-severity="0"></path>
                                </g>
                               </svg>
        `;
                svgContainer.innerHTML = svgContent;
                svgContainer.classList.remove('hidden');

                const paths = svgContainer.querySelectorAll('.mapPath');
                paths.forEach(part => {
                    const partId = part.getAttribute('data-id-name');

                    fetch(`/parts/${partId}/modele/${modeleId}/hasPieces`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.hasPieces) {
                                part.style.fill = 'red';
                                part.onclick = () => {
                                    const content = `
                                                            <div class="p-4  relative" style="width: 500px; height: 300px; display: flex; flex-direction: column; align-items: center; justify-content: center;" ">
                                                                <button class="close-btn" style="align-self: flex-end; color:black;" onclick="closeContent(${modeleId})">
                                                                    <i class="fa-sharp fa-solid fa-xmark"></i>
                                                                </button>
                                                                <div class="font-semibold text-lg mb-2">${data.pieces[0].name}</div>
                                                                <div class="mb-2" style="width: 100%; display: flex; justify-content: center;">
                                                                    <img src="${data.pieces[0].image}" alt="Piece Image" style="width: 50%; display: block; margin: 0 auto;">
                                                                </div>
                                                                <div class="text-sm mb-1">Prix de Réparation: ${data.pieces[0].prix_reparation}</div>
                                                                <div class="text-sm mb-1">Prix de Remplacement: ${data.pieces[0].prix_remplacement}</div>
                                                                <a href="#" class="flex items-center font-medium text-blue-600 dark:text-blue-500 dark:hover:text-blue-600 hover:text-blue-700 hover:underline">Read more <svg class="w-2 h-2 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                                                </svg></a>
                                                            </div>
                                                        `;
                                    const contentDiv = document.getElementById(`content-modele-${modeleId}`);

                                    // Update the content div
                                    contentDiv.innerHTML = content;

                                    // Show the content div
                                    contentDiv.classList.remove('hidden');
                                };

                            }

                            else {
                                part.style.fill = 'white';
                                part.onclick = () => handlePathClick(modeleId, part);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            } else {
                svgContainer.innerHTML = '';
                svgContainer.classList.add('hidden');
            }
        }
       
        //close content piece
        function closeContent(modeleId) {
            const contentDiv = document.getElementById(`content-modele-${modeleId}`);
            contentDiv.classList.add('hidden');
        }

        // Function to handle path click event
        function handlePathClick(modeleId, pathElement) {
            const partId = pathElement.getAttribute('data-id-name');

            console.log(`Path with partId ${partId} clicked for modele ${modeleId}`);
            const redirectUrl = `/add/pieces?modele_id=${modeleId}&part_id=${partId}`;
            window.location.href = redirectUrl;
        }



    </script>





</x-app-layout>