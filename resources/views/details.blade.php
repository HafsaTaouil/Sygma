<!DOCTYPE html>
<html data-theme="light" lang="en" style="background-color: #008080;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.11.1/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
</head>
<style>
    * {
        font-family: "Roboto", sans-serif;
        font-weight: 400;
        font-style: normal;
    }
</style>
@php
    $colors = [];

    foreach ($dossier->dossierParties as $part) {
        $severityMap = [
            1 => '107 114 128',
            2 => '179 213 232',
            3 => '4 153 253',
            4 => '252 2 4',
            5 => '0 0 0',
        ];
        $partId = $part->damage;
        $colors[$part->partie_id] = $severityMap[$partId] ?? '255 255 255';
    }
@endphp
<x-app-layout>

    <body>

        <div class="w-[93%] ml-auto h-full">
            <!-- navbar -->
            <div class="bg-[#009999]  ml-auto h-[69px] py-2 flex justify-end items-center mt-4">
              
                <button class="mr-10 animate-pulse bg-[#1B9BA4] rounded-lg py-3 px-4  text-xl  text-white flex items-center">
                    Download PDF <i class="fas fa-file-pdf ml-2"></i>
                </button>
            </div>

            <!-- titles -->
            <div class="md:px-24 px-8">

                <div class = "bg-white w-full h-fit rounded-lg flex justify-between items-center my-10">
                    <div class = "mt-5 w-full flex-wrap">
                        <div class = "flex flex-col gap-4 ml-8">
                            <div class = "w-full flex flex-row pr-8 justify-between">
                                <h1 class = "text-[#009999] font-bold text-4xl w-fit">
                                    {{ $dossier->modele->marque->name }}</h1>
                                <h1 class = "text-3xl text-[#009999]">Repair Cost <b id = "repairCost">0 Dh</b></h1>
                            </div>
                            <div class = "w-full">
                                <div class="text-[#000] flex flex-row flex-wrap gap-8 mr-5 mb-4">
                                    <div class="mb-2">
                                        <i class="fa fa-calendar"></i> Date d'entrée
                                        <p class="font-bold text-[#009999]">{{ $dossier->created_at->format('Y-m-d H:i') }}</p>
                                    </div>
                                    <div class="mb-2">
                                        <i class="fa fa-ticket"></i> Matriculation
                                        <p class="font-bold text-[#009999]">{{ $dossier->registration_number }}</p>
                                    </div>
                                    <div class="mb-2">
                                        <i class="fa fa-car"></i> Marque
                                        <p class="font-bold text-[#009999]">{{ $dossier->modele->marque->name }}</p>
                                    </div>
                                    <div class="mb-2">
                                        <i class="fas fa-cogs"></i> Modele
                                        <p class="font-bold text-[#009999] text-center">{{ $dossier->modele->name }}</p>
                                    </div>
                                    <div class="mb-2">
                                        <i class="fas fa-crown"></i> Owner
                                        <p class="font-bold text-[#009999]">{{ $dossier->owner}}</p>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 1st -->
                <div class="bg-white w-full h-screen  rounded-lg  flex justify-between my-10">
                    <div class="m-10 w-full">

                        <!-- car info -->
                        <div class="flex mt-5 flex-wrap-reverse md:flex-wrap justify-between">
                            <!-- colonne 1 -->
                            <div class="flex flex-row gap-6">
                                <div>
                                    <h1 class="text-[#23AF8C] font-bold text-xl  mb-2 w-fit">Repair Details</h1>
                                    <table class="text-xs table-fixed w-fit">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-2">Parts name</th>
                                                <th class="px-4 py-2">Severity</th>
                                                <th class="px-4 py-2">Decision</th>
                                                <th class="px-10 py-2">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody id = "RapportDetails" class = "">
                                            @foreach ($dossier->dossierParties as $part)
                                                <tr>
                                                    <td class="border px-4 py-2">{{ $part->partie->name }}</td>
                                                    <td class="border px-4 py-2">{{ $part->damage }}</td>
                                                    <td class="border px-4 py-2">Replace</td>
                                                    <td class="border px-4 py-2">2000
                                                        <i class="fa fa-pencil text-[#23AF8C] ml-5"></i>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="border px-4 py-2 font-bold">Total</td>
                                                <td class="border px-4 py-2"></td>
                                                <td class="border px-4 py-2"></td>
                                                <td id = "totalPrice" class="border px-4 py-2 font-bold">0
                                                    <i class="fa fa-pencil text-[#23AF8C] ml-5"></i>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- <div class="w-fit">
                            <h1 class="text-[#23AF8C] font-bold text-xl mb-2 ml-5 ">Repair Totals</h1>
                            <table class="table-auto ml-10">
                                <tbody>
                                    <tr>
                                        <th class="px-4 py-4">Parts</th>
                                        <td class="border px-4 py-2">3000
                                            <i class="fa fa-pencil text-[#23AF8C] ml-5"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="px-4 py-2">Labor</th>
                                        <td class="border px-4 py-2">400
                                            <i class="fa fa-pencil text-[#23AF8C] ml-5"></i>
                                        </td>

                                    </tr>
                                    <tr>
                                        <th class="px-4 py-2">Paint</th>
                                        <td class="border px-4 py-2">400
                                            <i class="fa fa-pencil text-[#23AF8C] ml-5"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> -->
                            </div>


                            <div class="relative h-[300px] mb-24 md:mb-0 md:h-20">
                                <svg class="m-auto w-11/12 md:w-full relative bottom-12" viewBox="280 -280 1100 1800"
                                    xmlns="http://www.w3.org/2000/svg" id="car-map">
                                    <g id="layer2"
                                        transform="matrix(0, 1, -1, 0, 254.000085527972, -254.000194186645)"
                                        style="transform-origin: 555.665px 834.02px;">
                                        <g id="g4113" transform="translate(-13.78 3.524)">
                                            <path class="mapPath"
                                                data-bg="https://www.aureliacar.com/Files/29327/Img/09/FT02146-SX-Aile-arriere-gauche-FIAT-500-phase-1--2007-2015--Neuve-a-peindre_1x800.jpg"
                                                data-name="Aile arriere gauche" data-id="path3070"
                                                style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: rgb(255, 255, 255);"
                                                d="M 357.43 1085.43 C 393.14 1062.57 494.57 1006.86 494.57 1006.86 C 536 991.14 634.57 995.43 686 994 C 737.43 992.57 777.248 996.088 818.148 1012.998 C 859.148 1029.928 936.567 1087.874 953.267 1093.074 C 976.067 1100.214 1080.3 1101.14 1118.9 1114 C 1157.4 1126.86 1144.6 1146.86 1144.6 1146.86 L 1114.6 1142.57 L 1108.8 1195.49 C 1108.8 1195.49 1146 1196.86 1150.3 1211.14 C 1154.6 1225.43 1156 1242.57 1147.4 1252.57 C 1138.9 1262.6 1133.1 1251.14 1128.9 1265.4 C 1124.6 1279.7 1126 1294 1101.7 1292.6 C 1077.4 1291.1 1003.1 1292.6 1003.1 1292.6 C 1003.1 1292.6 987.4 1184 904.6 1186.86 C 821.7 1189.71 808.9 1292.6 808.9 1292.6 L 361.599 1292.6"
                                                data-name="Aile arriere gauche" data-severity="0"></path>
                                            <path class="mapPath"
                                                data-bg="https://www.pieces-auto-moins-cher.fr/1111465/aile-avant-gauche-clio-0419.jpg"
                                                data-id-name = "8" data-name="Aile avant gauche" data-id="path30701"
                                                style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[8]) ? 'rgb(' . $colors[8] . ')' : 'rgb(255, 255, 255)' }};"
                                                d="M 361.599 1292.6 L 308.86 1292.6 C 308.86 1292.6 303.14 1188.29 211.71 1186.86 C 120.29 1185.43 113.14 1292.6 113.14 1292.6 L 47.43 1292.6 L 28.86 1254 C 28.34 1254 2.61 1254 7.43 1236.86 C 12.08 1220.3 3.14 1195.43 24.57 1195.43 C 46 1195.43 71.71 1196.86 71.71 1196.86 L 87.43 1152.57 L 46 1149.71 C 46 1149.71 80.29 1125.43 164.57 1116.86 C 248.86 1108.29 321.71 1108.29 357.43 1085.43 L 361.599 1292.6 Z"
                                                data-name="Aile avant gauche" data-severity="0">
                                                <title>Path</title>

                                            </path>
                                            <path class="mapPath"
                                                data-bg="https://salmia.ma/wp-content/uploads/2023/02/Porte-avant-gauche-PEUGEOT-3008.jpg"
                                                data-id-name = "10" data-name="Porte avant gauche" data-id="path3900"
                                                style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[10]) ? 'rgb(' . $colors[10] . ')' : 'rgb(255, 255, 255)' }};"
                                                d="M 886.971 1038.45 L 878.308 983.581 L 873.976 934.969 L 877.826 867.105 L 881.196 845.446 L 886.971 740.039 L 834.99 740.521 L 775.789 746.778 L 752.205 751.109 L 735.841 759.292 L 670.383 797.315 L 599.64 837.66 C 585.56 868.63 581.34 909.45 581.34 931.97 C 581.34 954.49 585.56 1024.944 603.86 1038.944 L 886.971 1038.45 Z"
                                                transform="translate(-254 254)" data-name="Porte avant gauche"
                                                data-severity="0"></path>

                                            <path class="mapPath"
                                                data-bg="https://salmia.ma/wp-content/uploads/2023/02/Porte-arriere-gauche-Peugeot-5008.jpg"
                                                data-id-name = "12" data-name="Porte arriere gauche"
                                                data-id="path39006"
                                                d="M 680.781 993.783 L 732.762 994.746 L 779.2 1000.17 C 797.5 1012.84 835.5 1050.84 872.1 1104.33 C 908.7 1157.82 880.5 1163.45 853.8 1178.93 C 827 1194.42 804.5 1221.641 786.2 1291.981 L 632.78 1292.419 C 627.15 1267.119 620.12 1209.9 620.12 1187.4 C 621.29 1151.3 622.6 1118.8 626.27 1100.1 C 628.74 1075 631.38 1000.204 632.78 994.574 L 680.781 993.783 Z"
                                                style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[12]) ? 'rgb(' . $colors[12] . ')' : 'rgb(255, 255, 255)' }};"
                                                data-name="Porte arriere gauche" data-severity="0"></path>

                                            <path class="mapPath" data-name="" data-id="path3884"
                                                style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: rgb(255, 255, 255)"
                                                d="m618.57 847.14c15.72-18.57 123.38-81.52 151.43-88.57 29.5-7.41 103-7.14 103-7.14l-7.14 95.71z"
                                                transform="translate(-254 254)"></path>
                                            <path class="mapPath" data-name="" data-id="path3892"
                                                style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: rgb(255, 255, 255)"
                                                d="m898.7 752.84-4.29 94.32h207.19c-11.3-20.75-46.6-74.9-72.9-88.57-14.3-10-82.86-4.33-130-5.75z"
                                                transform="translate(-254 254)"></path>
                                        </g>
                                        <path class="mapPath"
                                            data-bg="https://salmia.ma/wp-content/uploads/2023/02/Pare-choc-arriere-DS-DS3-PHASE-2-doccasion.jpeg"
                                            data-id-name = "19" data-name="Pare-choc arriere" data-id="path43810"
                                            style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[19]) ? 'rgb(' . $colors[19] . ')' : 'rgb(255, 255, 255)' }};"
                                            d="M 1267.042 624.97 C 1267.042 624.97 1336.7 623.56 1336.7 646.09 L 1336.7 1017.7 C 1336.7 1040.2 1264.271 1043 1264.271 1043"
                                            data-name="Pare-choc arriere" data-severity="2"></path>

                                        <g id="g4451" transform="translate(-13.78 15.524)">
                                            <path class="mapPath"
                                                data-bg="https://www.piece-carrosserie-discount.com/image/pare-chocs-183428.jpg"
                                                data-id-name = "2" data-name="Pare-choc avant" data-id="path4175"
                                                style="stroke:#000000;stroke-width:5;fill:{{ isset($colors[19]) ? 'rgb(' . $colors[19] . ')' : 'rgb(255, 255, 255)' }}"
                                                d="m736.17 416.79s94.31 5.63 152.02 5.63c106.98 0 201.31-5.63 201.31-5.63m-1.4 297s-77.4-5.63-199.91-5.63c-68.97 0-152.02 7.04-152.02 7.04"
                                                transform="translate(-254 254)"></path>

                                            <path class="mapPath"
                                                data-bg="https://www.piece-carrosserie-discount.com/image/capot-moteur-183402.png"
                                                data-id-name = "5" data-name="Capot" data-id="path41359"
                                                d="m345.78 632.78h-294.19l-14.076 102.76-7.038 11.26v142.17l7.038 14.07 15.483 101.36h288.55"
                                                style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[5]) ? 'rgb(' . $colors[5] . ')' : 'rgb(255, 255, 255)' }};"
                                                data-name="Capot" data-severity="0"></path>

                                            <path class="mapPath"
                                                data-bg="https://fs.opisto.fr/Pictures/4672/2024_3/84616834-48726a0b5100799397a26b05e50c561ec9b497f31927b46991d42e2bdac21195.jpg"
                                                data-id-name = "16" data-name="Malle" data-id="path15"
                                                style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[16]) ? 'rgb(' . $colors[16] . ')' : 'rgb(255, 255, 255)' }};"
                                                d="M 1282.678 961.782 L 1282.677 677.454 L 1214.68 677.456 L 1214.68 961.786 L 1282.678 961.782 Z M 832.7 670.79 C 832.7 670.79 820 718.65 820 743.98 L 820 890.37 C 820 915.71 832.7 967.79 832.7 967.79 L 1038.2 1005.8 L 1146.6 1005.8 C 1146.6 1005.8 1160.6 924.16 1160.6 890.37 L 1160.6 742.58 C 1160.6 704.57 1146.6 632.78 1146.6 632.78 L 1038.2 632.78 L 832.7 670.79 Z"
                                                data-name="Malle" data-severity="2"></path>

                                            <path class="mapPath"
                                                data-bg="https://voiture.kidioui.fr/image/lexique/pare-brise-athermique.jpg"
                                                data-id-name = "6" data-name="Pare-brise avant" data-id="path4165"
                                                style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[6]) ? 'rgb(' . $colors[6] . ')' : 'rgb(255, 255, 255)' }};"
                                                d="M 595.41 378.78 L 736.17 416.79 C 736.17 416.79 727.73 466.01 727.73 488.75 L 727.73 636.37 C 727.73 667.34 736.17 715.2 736.17 715.2 L 595.41 748.98 C 595.41 748.98 578.17 687.08 578.17 656.08 C 578.55 622.28 580.28 470.28 580.28 470.28 C 578.87 439.31 595.41 378.78 595.41 378.78 L 595.41 378.78 Z"
                                                transform="translate(-254 254)" data-name="Pare-brise avant"
                                                data-severity="0"></path>

                                            <path class="mapPath"
                                                data-bg="https://assets-global.website-files.com/6413856d54d41b5f298d5953/64d63826f8cdfc369418fed1_lunette-arriere-automobile.jpeg"
                                                data-id-name = "15" data-name="Pare-brise arriere" data-id="path4205"
                                                style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[15]) ? 'rgb(' . $colors[15] . ')' : 'rgb(255, 255, 255)' }};"
                                                d="m1097.9 435.09s-8.4 40.82-8.4 56.3v144.98c0 19.71 7 57.72 7 57.72s94.3 26.74 123.9 26.74h42.2v-312.49h-47.8c-25.4 0-116.9 26.75-116.9 26.75z"
                                                transform="translate(-254 254)" data-name="Pare-brise arriere"
                                                data-severity="0"></path>

                                        </g>
                                        <path class="mapPath"
                                            data-bg="https://www.piece-carrosserie-discount.com/image/pare-chocs-183428.jpg"
                                            data-id-name = "2" data-name="Pare-choc avant" data-id="path4245"
                                            style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[2]) ? 'rgb(' . $colors[2] . ')' : 'rgb(255, 255, 255)' }};"
                                            d="M -74.052 1042.25 L -45.91 1042.1 C -17.754 1042.1 -23.38 1019.6 -23.38 1019.6 L -23.38 923.9 C -36.06 923.9 -34.65 914.29 -34.65 907.01 L -34.65 757.81 C -34.2 738.92 -24.79 740.92 -24.79 740.92 L -23.38 649.42 C -23.38 649.42 -16.855 626.389 -47.821 624.989 C -78.791 623.579 -75.919 624.665 -76.336 624.523 C -76.753 624.38 -144.37 622.97 -144.37 645.49 L -144.37 1017.1 C -144.37 1039.6 -74.052 1042.25 -74.052 1042.25 Z"
                                            data-name="Pare-choc avant" data-severity="0"></path>
                                        <g id="g4428" transform="translate(-13.78 15.524)">
                                            <path class="mapPath"
                                                data-bg="https://www.piece-carrosserie-discount.com/image/pare-chocs-183428.jpg"
                                                data-id-name = "7" data-name="Aile avant droit" data-id="path38526"
                                                d="M 373.313 355.9 L 308.86 355.9 C 308.86 355.9 303.14 460.19 211.71 461.61 C 120.29 463.04 113.14 355.9 113.14 355.9 L 47.429 355.9 L 28.857 394.47 C 28.342 394.47 2.614 394.47 7.429 411.61 C 12.08 428.18 3.143 453.04 24.571 453.04 C 46 453.04 71.714 451.61 71.714 451.61 L 87.429 495.9 L 46 498.76 C 46 498.76 80.286 523.04 164.57 531.61 C 248.86 540.19 321.71 540.19 357.43 563.04"
                                                style="stroke: rgb(0, 0, 0); stroke-width: 5px; fill: {{ isset($colors[7]) ? 'rgb(' . $colors[7] . ')' : 'rgb(255, 255, 255)' }};"
                                                data-name="Aile avant droit" data-severity="0"></path>
                                            <path class="mapPath"
                                                data-bg="https://www.piecesvoiturettes.fr/1761-large_default/friendly-url-autogeneration-failed.jpg"
                                                data-id-name = "13" data-name="Aile arriere droit"
                                                data-id="path385267"
                                                d="M 373.313 355.9 L 808.86 355.9 C 808.86 355.9 821.71 458.76 904.57 461.61 C 987.43 464.47 1003.1 355.9 1003.1 355.9 C 1003.1 355.9 1077.4 357.33 1101.7 355.9 C 1126 354.47 1124.6 368.76 1128.9 383.04 C 1133.1 397.33 1138.9 385.9 1147.4 395.9 C 1156 405.9 1154.6 423.04 1150.3 437.33 C 1146 451.61 1108.8 452.98 1108.8 452.98 L 1114.6 505.9 L 1144.6 501.61 C 1144.6 501.61 1157.4 521.61 1118.9 534.47 C 1080.3 547.33 975.802 558.017 953.002 565.157 C 936.302 570.357 853.501 620.391 812.511 637.321 C 771.551 654.231 737.43 655.9 686 654.47 C 634.57 653.04 536 657.33 494.57 641.61 C 494.57 641.61 393.14 585.9 357.43 563.04"
                                                style="stroke: rgb(0, 0, 0); stroke-width: 5px; fill: {{ isset($colors[13]) ? 'rgb(' . $colors[13] . ')' : 'rgb(255, 255, 255)' }};"
                                                data-name="Aile arriere droit" data-severity="0"></path>

                                            <path class="mapPath"
                                                data-bg="https://fs.opisto.fr/Pictures/4481/2023_1/Piece-Porte-avant-droit-801001895R-DACIA-LOGAN-1-PHASE-1-deab956cb50582ae623aece05c3df1d4929bb97179869cebfb401fe22e570376_mtn.jpg"
                                                data-id-name = "9" data-name="Porte avant droite" data-id="path39004"
                                                d="M 345.64 556.81 C 331.56 525.84 327.34 485.02 327.34 462.5 C 327.34 439.98 331.56 371.01 349.86 356.93 L 635.128 355.533 L 626.117 398.01 L 620.325 451.428 L 622.256 506.133 L 627.405 560.195 L 633.197 655.446 L 570.769 654.802 L 508.984 647.723 L 474.23 632.277 L 345.64 556.81 Z"
                                                style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[9]) ? 'rgb(' . $colors[9] . ')' : 'rgb(255, 255, 255)' }};"
                                                data-name="Porte avant droite" data-severity="0"></path>

                                            <path class="mapPath"
                                                data-bg="https://fs.opisto.fr/Pictures/4481/2023_1/Piece-Porte-avant-droit-801001895R-DACIA-LOGAN-1-PHASE-1-deab956cb50582ae623aece05c3df1d4929bb97179869cebfb401fe22e570376_mtn.jpg"
                                                data-id-name = "11" data-name="Porte arriere droite"
                                                data-id="path39422"
                                                d="M 720.688 654.344 L 632.78 655.34 C 631.38 649.71 628.74 573.44 626.27 548.41 C 622.6 529.69 621.29 497.19 620.12 461.09 C 620.12 438.57 627.15 380.86 632.78 355.52 L 786.21 356.23 C 804.51 426.61 827.03 454.06 853.78 469.54 C 880.52 485.02 908.67 490.65 872.08 544.14 C 835.48 597.63 797.47 635.64 779.17 648.3 L 720.688 654.344 Z"
                                                style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[11]) ? 'rgb(' . $colors[11] . ')' : 'rgb(255, 255, 255)' }};"
                                                data-name="Porte arriere droite" data-severity="0"></path>

                                            <path class="mapPath" data-name="" data-id="path38965"
                                                d="m644.7 641.63-4.29-94.32h207.17c-11.31 20.75-46.62 74.9-72.86 88.57-14.29 10-82.88 4.33-130.02 5.75z"
                                                style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: rgb(255, 255, 255);">
                                            </path>
                                            <path class="mapPath" data-name="" data-id="path38844"
                                                d="m364.57 547.33c15.72 18.57 123.38 81.52 151.43 88.57 29.5 7.41 103 7.14 103 7.14l-7.14-95.71z"
                                                style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: rgb(255, 255, 255);">
                                            </path>
                                        </g>
                                        <path class="mapPath"
                                            data-bg="https://fs.opisto.fr/Pictures/4481/2023_1/Piece-Porte-avant-droit-801001895R-DACIA-LOGAN-1-PHASE-1-deab956cb50582ae623aece05c3df1d4929bb97179869cebfb401fe22e570376_mtn.jpg"
                                            data-id-name = "4" data-name="Feu avant gauche" data-id="path4361"
                                            style="stroke: rgb(0, 0, 0); stroke-width: 5px; paint-order: stroke; fill: {{ isset($colors[4]) ? 'rgb(' . $colors[4] . ')' : 'rgb(255, 255, 255)' }};"
                                            d="M -71.88 985.879 L -71.88 948.339 L -49.35 948.339 L -26.83 948.339 L -26.83 985.879 L -26.83 1023.376 L -49.35 1023.376 L -71.88 1023.376 L -71.88 985.879 Z"
                                            data-name="Feu avant gauche" data-severity="0"></path>

                                        <path class="mapPath"
                                            data-bg="https://www.piece-carrosserie-discount.com/image/10533-183437.jpg"
                                            data-id-name = "3" data-name="Feu avant droit" data-id="path4363"
                                            style="stroke-width: 5px; stroke: rgb(0, 0, 0); paint-order: stroke; fill: {{ isset($colors[3]) ? 'rgb(' . $colors[3] . ')' : 'rgb(255, 255, 255)' }};"
                                            d="M -71.88 681.701 L -71.88 642.757 L -49.35 642.757 L -26.83 642.757 L -26.83 681.701 L -26.83 720.644 L -49.35 720.644 L -71.88 720.644 L -71.88 681.701 Z"
                                            data-name="Feu avant droit" data-severity="0"></path>

                                        <path class="mapPath" data-name="" data-id="path4610"
                                            style="stroke:#000000;stroke-width:2;fill:#c8c8c8"
                                            d="m195.66 202.84a76.01 76.01 0 1 1 -152.02 0 76.01 76.01 0 1 1 152.02 0z"
                                            transform="translate(78.489 1074.7)"></path>
                                        <path class="mapPath" data-name="" data-id="path4612"
                                            style="stroke:#000000;stroke-width:2;fill:#ffffff"
                                            d="m147.8 72.633a44.339 44.339 0 1 1 -88.681 0 44.339 44.339 0 1 1 88.681 0z"
                                            transform="translate(94.676 1204.9)"></path>
                                        <path class="mapPath" data-name="" data-id="path46109"
                                            style="stroke: rgb(0, 0, 0); stroke-width: 2; fill: rgb(200, 200, 200);"
                                            d="m195.66 202.84a76.01 76.01 0 1 1 -152.02 0 76.01 76.01 0 1 1 152.02 0z"
                                            transform="translate(78.489 187.66)"></path>
                                        <path class="mapPath" data-name="" data-id="path46124"
                                            style="stroke:#000000;stroke-width:2;fill:#ffffff"
                                            d="m147.8 72.633a44.339 44.339 0 1 1 -88.681 0 44.339 44.339 0 1 1 88.681 0z"
                                            transform="translate(94.676 317.86)"></path>
                                        <path class="mapPath" data-name="" data-id="path46105"
                                            style="stroke:#000000;stroke-width:2;fill:#c8c8c8"
                                            d="m195.66 202.84a76.01 76.01 0 1 1 -152.02 0 76.01 76.01 0 1 1 152.02 0z"
                                            transform="translate(773.03 187.66)"></path>
                                        <path class="mapPath" data-name="" data-id="path46121"
                                            style="stroke:#000000;stroke-width:2;fill:#ffffff"
                                            d="m147.8 72.633a44.339 44.339 0 1 1 -88.681 0 44.339 44.339 0 1 1 88.681 0z"
                                            transform="translate(789.21 317.86)"></path>
                                        <path class="mapPath" data-name="" data-id="path46104"
                                            style="stroke:#000000;stroke-width:2;fill:#c8c8c8"
                                            d="m195.66 202.84a76.01 76.01 0 1 1 -152.02 0 76.01 76.01 0 1 1 152.02 0z"
                                            transform="translate(773.03 1074.7)"></path>
                                        <path class="mapPath" data-name="" data-id="path46123"
                                            style="stroke:#000000;stroke-width:2;fill:#ffffff"
                                            d="m147.8 72.633a44.339 44.339 0 1 1 -88.681 0 44.339 44.339 0 1 1 88.681 0z"
                                            transform="translate(789.21 1204.9)"></path>
                                        <path class="mapPath"
                                            data-bg="https://www.vignal-group.com/media/cache/Catalogue%20Product%20Pictures/Signalisation/Feuxarriere/1/5/154210_web.jpg"
                                            data-id-name = "17" data-name="Feu arriere droit" data-id="path4499"
                                            style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[17]) ? 'rgb(' . $colors[17] . ')' : 'rgb(255, 255, 255)' }};"
                                            d="M 1199.9 633.86 L 1199.9 707.05 L 1267.5 707.05 L 1267.5 624 L 1242.2 609.93 L 1199.9 633.86 Z"
                                            data-name="Feu arriere droit" data-severity="0"></path>

                                        <path class="mapPath"
                                            data-bg="https://www.vignal-group.com/media/cache/Catalogue%20Product%20Pictures/Signalisation/Feuxarriere/1/5/152200_web.jpg"
                                            data-id-name = "18" data-name="Feu arriere gauche" data-id="path4501"
                                            style="stroke: rgb(0, 0, 0); stroke-width: 5; fill: {{ isset($colors[18]) ? 'rgb(' . $colors[18] . ')' : 'rgb(255, 255, 255)' }};"
                                            d="M 1199.9 963.24 L 1267.5 963.24 L 1267.5 1042.1 L 1243.6 1056.1 L 1199.9 1037.8 L 1199.9 963.24 Z"
                                            data-name="Feu arriere gauche" data-severity="0"></path>

                                        <path class="mapPath"
                                            data-bg="https://maroctl.com/wp-content/uploads/2021/01/plaques-immatriculation-min.jpg"
                                            data-id-name = "1" data-name="Plaque immatriculation avant"
                                            data-id="path28"
                                            style="stroke-width: 5px; stroke: rgb(0, 0, 0); paint-order: stroke; fill: {{ isset($colors[1]) ? 'rgb(' . $colors[1] . ')' : 'rgb(255, 255, 255)' }};"
                                            d="M -126.593 832.725 L -126.593 735.712 L -113.949 735.712 L -101.311 735.712 L -101.311 832.725 L -101.311 929.735 L -113.949 929.735 L -126.593 929.735 L -126.593 832.725 Z"
                                            data-name="Plaque immatriculation avant" data-severity="0"></path>
                                        <path class="mapPath"
                                            data-bg="https://www.feuvert.be/articles/wp-content/uploads/2021/04/Article-Modifications-legislations-Feu-VERT-2021-plaque-immatriculation-2002.png"
                                            data-id-name = "20" data-name="Plaque immatriculation arriere"
                                            data-id="path37"
                                            style="stroke-width: 5px; stroke: rgb(0, 0, 0); paint-order: stroke; fill: {{ isset($colors[20]) ? 'rgb(' . $colors[20] . ')' : 'rgb(255, 255, 255)' }};"
                                            d="M 1292.264 833.899 L 1292.264 736.886 L 1304.908 736.886 L 1317.546 736.886 L 1317.546 833.899 L 1317.546 930.909 L 1304.908 930.909 L 1292.264 930.909 L 1292.264 833.899 Z"
                                            data-name="Plaque immatriculation arriere" data-severity="0"></path>
                                    </g>
                                </svg>
                            </div>
                            <!-- Images  -->
                            <!-- <div class="flex flex-col w-1/3 gap-4">
                            <img id="car1" src="../images/car1.jpg" alt="Photo 1"
                                class="w-full h-fit object-contain hover:scale-105 transition-all cursor-pointer h-auto">
                            <img id="car2" src="../images/car2.jpg" alt="Photo 2"
                                class="cursor-pointer hover:scale-105 transition-all">
                        </div>
                         -->


                            <div class = "flex flex-col w-1/3 gap-4">
                                <img id="car1" src="{{ asset($dossier->dossierParties[0]->damage_image) }}"
                                    onclick="car1Pic.showModal()" alt="Photo 1"
                                    class="w-full h-fit object-contain hover:scale-105 transition-all cursor-pointer h-auto">
                                <dialog id="car1Pic" class="modal">
                                    <div class="modal-box">
                                        <form method="dialog">
                                            <button
                                                class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                        </form>
                                        <h3 class="font-bold text-lg mb-4">Picture</h3>
                                        <img src="{{ asset($dossier->dossierParties[0]->damage_image) }}"
                                            alt="Photo 1" class="cursor-pointer h-auto">
                                    </div>
                                </dialog>
                                <div class = "grid grid-cols-3 gap-2">
                                    @foreach ($dossier->dossierParties as $part)
                                        <label for = "{{ $loop->index }}Pic">
                                            <img id="car{{ $loop->index }}"
                                                class = "cursor-pointer hover:scale-105 transition-all"
                                                src="{{ asset($part->damage_image) }}" alt="">
                                            <input type="checkbox" id="{{ $loop->index }}Pic"
                                                class="modal-toggle" />
                                            <div id="{{ $loop->index }}Pic" role = "dialog" class="modal">
                                                <div class="modal-box">
                                                    <form method="dialog">
                                                        <label for = "{{ $loop->index }}Pic"
                                                            class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                                                    </form>
                                                    <h3 class="font-bold text-lg mb-4">Picture</h3>
                                                    <img src="{{ asset($part->damage_image) }}" alt="Photo 1"
                                                        class="cursor-pointer h-auto">
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                    <div onclick = "carousel.showModal()"
                                        class = "cursor-pointer hover:scale-105 transition-all w-full h-full bg-[#23AF8C] flex items-center justify-center flex-col">
                                        <i class = "fas fa-images text-white"></i>
                                        <h2 class = "text-center text-md font-bold text-white">All images</h2>
                                    </div>
                                    <dialog id="carousel" class="modal">
                                        <div class="modal-box">
                                            <form method="dialog">
                                                <button
                                                    class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                            </form>
                                            <h3 class="font-bold text-lg mb-4">Picture</h3>
                                            <div class="carousel w-full">
                                                @foreach ($dossier->dossierParties as $part)
                                                    <div id="slide{{ $loop->index }}"
                                                        class="carousel-item relative w-full">
                                                        <img src="{{ asset($part->damage_image) }}" class="w-full" />
                                                        <div
                                                            class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                                            <a href="#slide{{ $loop->index - 1 }}"
                                                                class="btn btn-circle">❮</a>
                                                            <a href="#slide{{ $loop->index + 1 }}"
                                                                class="btn btn-circle">❯</a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="flex justify-center w-full py-2 gap-2">
                                                @foreach ($dossier->dossierParties as $part)
                                                    <a href="#slide{{ $loop->index }}"
                                                        class="btn btn-xs">{{ $loop->index }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </dialog>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </div>
        @include('layouts.footer')

        <script>
            async function convertImageToBase64(imageUrl) {
                return new Promise((resolve, reject) => {
                    const img = new Image();
                    img.crossOrigin = 'Anonymous';
                    img.src = imageUrl;

                    img.onload = () => {
                        const canvas = document.createElement('canvas');
                        canvas.width = img.width;
                        canvas.height = img.height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0);
                        const base64String = canvas.toDataURL('image/jpeg').split(',')[1];
                        // console.log(`Converted image ${imageUrl} to Base64:`, base64String.substring(0, 30) + '...');
                        resolve(base64String);
                    };

                    img.onerror = (error) => {
                        console.error(`Error loading image ${imageUrl}:`, error);
                        reject(error);
                    };
                });
            }
            //fonction to processs car damage severity images
            async function processImages() {
                const images = ["../images/car1.jpg", "../images/car2.jpg"];
                const base64Images = await Promise.all(images.map(convertImageToBase64));
                //console.log(base64Images)

                const formData = new FormData();
                formData.append('images', JSON.stringify(base64Images));

                formData.append('llm', 'gpt-4o');

                // Iterate over FormData entries
                // for (const pair of formData.entries()) {
                //     console.log(pair[0], pair[1]);
                // }
                const apiUrl = "http://13.36.237.112/damages";

                try {
                    const response = await fetch(apiUrl, {
                        method: "POST",
                        body: formData
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const result = await response.json();
                    console.log("API Response:", result);

                    initializeParts(result);
                } catch (error) {
                    console.error("Error processing images:", error);
                }
            }


            document.addEventListener('DOMContentLoaded', (event) => {
                processImages();
            });

            document.querySelectorAll('.carPart').forEach(mapPath => {
                const dataName = mapPath.getAttribute('data-name');
                const dataSeverity = mapPath.getAttribute('data-severity');

                if (dataName) {
                    tippy(mapPath, {
                        followCursor: true,
                        content: dataName
                    });
                }
            });
            const severityLevels = ["0", "1", "2", "3"];
            const severityColors = ["white", "orange", "yellow", "red"];
            const severityDecision = ["Nothing", "Repair", "Repair", "Replace"];
            const partPrices = {
                "Plaque immatriculation avant": [0, 0, 0, 0], // No prices specified
                "Pare-choc avant": [0, 300, 500, 1200],
                "Feu avant droit": [0, 600, 600, 600],
                "Feu avant gauche": [0, 600, 600, 600],
                "Capot": [0, 300, 600, 1300],
                "Aile avant droit": [0, 200, 400, 600],
                "Aile avant gauche": [0, 200, 400, 600],
                "Porte avant droite": [0, 500, 800, 2000],
                "Porte avant gauche": [0, 500, 800, 2200],
                "Porte arriere droite": [0, 500, 800, 2000],
                "Porte arriere gauche": [0, 500, 800, 2000],
                "Aile arriere droit": [0, 200, 400, 600],
                "Aile arriere gauche": [0, 200, 400, 600],
                "Malle": [0, 500, 1000, 2500],
                "Feu arriere droit": [0, 500, 500, 500],
                "Feu arriere gauche": [0, 500, 500, 500],
                "Pare-choc arriere": [0, 300, 500, 1000],
                "Plaque immatriculation arriere": [0, 100, 100, 100],
                "Pare-brise avant": [0, 600, 600, 600],
                "Pare-brise arriere": [0, 600, 600, 600],
                "Enjoliver": [0, 50, 50, 50],
                "Jante": [0, 400, 400, 400],
                "Pneu": [0, 400, 400, 400],
                "calandre": [0, 200, 200, 200],
                "Logo": [0, 50, 50, 50],
                "support d'immatriculation": [0, 100, 100, 100],
                "Baguette d'ail": [0, 100, 100, 100]
            };

            // Function to handle click on a part
            function handlePartClick(evt) {
                const part = evt.target;
                const severity = Number(part.getAttribute("data-severity"));
                const nextSeverity = (severity + 1) % severityLevels.length;

                part.style.fill = severityColors[nextSeverity];
                part.setAttribute("data-severity", nextSeverity);

                const partName = part.getAttribute("data-name");

                if (nextSeverity > 0) {
                    updateRapportDetails(partName, nextSeverity);
                } else {
                    removeRowFromRapportDetails(partName);
                }

                updateTotalPrice();
            }

            // Function to update or add details to RapportDetails table
            function updateRapportDetails(partName, severity) {
                const rapportDetailsTable = document.getElementById("RapportDetails");
                const rows = rapportDetailsTable.querySelectorAll("tr");
                let rowExists = false;

                rows.forEach(row => {
                    if (row.firstChild.textContent === partName) {
                        rowExists = true;
                        row.cells[1].textContent = severityLevels[severity];
                        row.cells[2].textContent = severityDecision[severity];
                        row.cells[3].textContent = partPrices[partName][severity];
                    }
                });

                if (!rowExists) {
                    const newRow = rapportDetailsTable.insertRow();
                    const cell1 = newRow.insertCell(0);
                    const cell2 = newRow.insertCell(1);
                    const cell3 = newRow.insertCell(2);
                    const cell4 = newRow.insertCell(3);

                    cell1.textContent = partName;
                    cell2.textContent = severityLevels[severity];
                    cell3.textContent = severityDecision[severity];
                    cell4.textContent = partPrices[partName][severity];

                    cell1.className = "border px-4 py-2";
                    cell2.className = "border px-4 py-2";
                    cell3.className = "border px-4 py-2";
                    cell4.className = "border px-4 py-2";

                    newRow.setAttribute("data-severity", severity);
                }
            }

            // Function to remove row from RapportDetails table
            function removeRowFromRapportDetails(partName) {
                const rapportDetailsTable = document.getElementById("RapportDetails");
                const rows = rapportDetailsTable.querySelectorAll("tr");

                rows.forEach(row => {
                    if (row.firstChild.textContent === partName) {
                        row.remove();
                    }
                });
            }

            function updateTotalPrice() {
                const rapportDetailsTable = document.getElementById("RapportDetails");
                const rows = rapportDetailsTable.querySelectorAll("tr");

                let newTotalPrice = 0;

                rows.forEach(row => {
                    const price = parseInt(row.cells[3].textContent) || 0;
                    newTotalPrice += price;
                });

                // console.log(newTotalPrice);

                document.getElementById("totalPrice").textContent = newTotalPrice;
                document.getElementById("repairCost").textContent = newTotalPrice + " Dh";
            }


            //Display damage from db in car part        
            const parts = document.querySelectorAll(".mapPath");
            let partIds = [];
            @foreach ($dossier->dossierParties as $part)
                partIds.push({
                    id: "{{ $part->partie_id }}",
                    pic: "{{ $part->damage_image }}"
                });
            @endforeach

            parts.forEach((part) => {
                let dataIdName = part.getAttribute('data-id-name');
                let foundPart = partIds.find(item => item.id === dataIdName);

                if (foundPart) {
                    part.setAttribute('onclick', `part${dataIdName}.showModal()`);

                    const partModal = document.createElement('div');
                    partModal.innerHTML = `
            <dialog id="part${dataIdName}" class="modal">
                <div class="modal-box">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 waves-effect -top-1 float-right">✕</button>
                    </form>
                    <h3 class="text-lg font-medium text-gray-800">Picture of <b class="lowercase">${part.getAttribute('data-name')}</b></h3>
                    <img class="mt-4" src="/storage/${foundPart.pic}">
                </div>
            </dialog>
        `;

                    // Append the created modal dialog to the document body or another suitable container
                    document.body.appendChild(partModal);

                    console.log(part);
                    console.log(partModal);
                    console.log("part ids : ", partIds);
                }
            });




            function initializeParts(apiResponse) {
                const partsData =
                apiResponse; // Assuming the API response contains a property 'parts' with data about the parts

                for (const partName in apiResponse) {
                    if (apiResponse.hasOwnProperty(partName)) {
                        const quantity = apiResponse[partName];
                        const partElement = document.querySelector(`.carPart[data-name="${partName}"]`);
                        if (partElement) {
                            // Assuming severity is calculated based on quantity
                            const severity = quantity;
                            partElement.setAttribute("data-severity", severity);
                            partElement.style.fill = severityColors[severity];
                            updateRapportDetails(partName, severity);
                        }
                    }
                }

                updateTotalPrice();
            }
        </script>
    </body>
</x-app-layout>

</html>
