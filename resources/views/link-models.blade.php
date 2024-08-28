<x-app-layout>

    <head>


        {{-- The car icon starts --}}
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        {{-- The car icon ends --}}


        <!-- font-family: "Comfortaa", sans-serif;-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
        <!---->


        <link rel="stylesheet" href="{{asset('css/link-models.css')}}">


        <script src="{{ asset('js/fetchMarquesForSearch.js') }}" defer></script>
        <script src="{{ asset('js/link-models.js') }}" defer></script>



        <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js" defer></script>

        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>


    
    <div class="flex justify-center">

        <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 text-justify">

            <span class="material-symbols-outlined">
                swap_driving_apps
            </span>
            
            <a href="#">
                <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">Why Link Cars' Models?</h5>
            </a>
            <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">Linking models aims to automatically assign the valid pieces of one model to another.</p>
            <a href="#" class="inline-flex font-medium items-center text-[#009999] hover:underline">
                Learn more
                <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778"/>
                </svg>
            </a>
        </div>

    </div>


    {{-- Selection of model 1 --}}
    <div class="first-model flex flex-col items-center justify-center space-y-5">

        
        <h1 class="fontfamily mb-4 text-sm font-extrabold leading-none tracking-tight text-gray-900 md:text-base lg:text-xl dark:text-white">
            Models Selection : <span id="model-number" class="underline underline-offset-3 decoration-3 decoration-[#009999] dark:decoration-[#009999]">Model 1</span>
        </h1>

        <!--SELECT The make and the model-->
        <h5 class="fontfamily">1- Choose the Make :</h5>
        <div id="select-car" class="text-justify">
            <button id="states-button" data-dropdown-toggle="dropdown-states" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">
                <span class="material-symbols-outlined me-2">traffic_jam</span>
                <label id="chosen-car">Choisir la marque</label>
                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>



            
            
            <div id="dropdown-states" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            
                <ul id="marques-container" class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="states-button">
                    
                    @foreach($marques as $marque)

                        <li>
                            <button type="button" class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                <div class="inline-flex items-center">
                                    <span class="material-symbols-outlined">directions_car</span>                                    
                                    <label class="make-name">{{ $marque->name }}</label>
                                </div>
                            </button>
                        </li>
                    @endforeach
                                                                            
                </ul>
            </div>

            <select id="modeles" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-e-lg border-s-gray-100 dark:border-s-gray-700 border-s-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Choisir le modèle</option>
                
            </select>
            
        </div>
        
        
        
        

    </div>


    

<!-- Modal toggle -->
<button id='modalToggle' data-modal-target="progress-modal" data-modal-toggle="progress-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
    Toggle modal
</button>
  
  <!-- Main modal -->
  <div id="progress-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-md max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="progress-modal">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                  </svg>
                  <span class="sr-only">Close modal</span>
              </button>
              <div class="p-4 md:p-5">
                  <svg class="w-10 h-10 text-gray-400 dark:text-gray-500 mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                      <path d="M8 5.625c4.418 0 8-1.063 8-2.375S12.418.875 8 .875 0 1.938 0 3.25s3.582 2.375 8 2.375Zm0 13.5c4.963 0 8-1.538 8-2.375v-4.019c-.052.029-.112.054-.165.082a8.08 8.08 0 0 1-.745.353c-.193.081-.394.158-.6.231l-.189.067c-2.04.628-4.165.936-6.3.911a20.601 20.601 0 0 1-6.3-.911l-.189-.067a10.719 10.719 0 0 1-.852-.34 8.08 8.08 0 0 1-.493-.244c-.053-.028-.113-.053-.165-.082v4.019C0 17.587 3.037 19.125 8 19.125Zm7.09-12.709c-.193.081-.394.158-.6.231l-.189.067a20.6 20.6 0 0 1-6.3.911 20.6 20.6 0 0 1-6.3-.911l-.189-.067a10.719 10.719 0 0 1-.852-.34 8.08 8.08 0 0 1-.493-.244C.112 6.035.052 6.01 0 5.981V10c0 .837 3.037 2.375 8 2.375s8-1.538 8-2.375V5.981c-.052.029-.112.054-.165.082a8.08 8.08 0 0 1-.745.353Z"/>
                  </svg>
                  <h3 id="first-sec" class="mb-1 text-xl font-bold text-gray-900 dark:text-white">You've successfully selected the first model</h3>
                  <p class="text-gray-500 dark:text-gray-400 ">The Make selected : <label class="makeSelected"></label><p>
                    <p class="text-gray-500 dark:text-gray-400">The Model selected : <label class="modelSelected"></label><p>
                  
                  
                  <!-- Modal footer -->
                  <div class="flex items-center mt-6 space-x-4 rtl:space-x-reverse">
                      <button id="continue" data-modal-hide="progress-modal" type="button" class="text-white bg-[#009999] hover:bg-[#009999] focus:ring-4 focus:outline-none focus:ring-[#017e7e] font-medium rounded-lg text-sm px-5 py-2.5 text-center">Continue</button>
                      <button data-modal-hide="progress-modal" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                  </div>
              </div>
          </div>
      </div>
  </div> 



  
<button id="modalToggle2" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
    Toggle modal
    </button>
    
    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-[#009999] w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                        <label id="marque1"></label> and <label id="marque2"></label>
                        Are Successfully Linked
                    </h3>
                    <button data-modal-hide="popup-modal" type="button" class="fontfamily text-white bg-[#009999] hover:bg-[#017070] focus:ring-4 focus:outline-none focus:ring-[#03b1b1] dark:focus:ring-[#017070] font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        View the association report
                    </button>
                    
                </div>
            </div>
        </div>
    </div>
    
  



</x-app-layout>