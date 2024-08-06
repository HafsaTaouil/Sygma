<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.11.1/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- add dossier -->

    <head>
        <title> Ajouter dossier</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <link rel="icon" type="image/x-icon" href="img/favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/css/fontawesome.css" />
        <link rel="stylesheet" type="text/css" href="/css/ionicons.css" />
        <link rel="stylesheet" type="text/css" href="/css/linearicons.css" />
        <link rel="stylesheet" type="text/css" href="/css/open-iconic.css" />
        <link rel="stylesheet" type="text/css" href="/css/pe-icon-7-stroke.css" />
        <link rel="stylesheet" type="text/css" href="/css/feather.css" />
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-material.css" />
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <link rel="stylesheet" type="text/css" href="/css/shreerang-material.css" />
        <link rel="stylesheet" type="text/css" href="/css/uikit.css" />
        <link rel="stylesheet" type="text/css" href="/css/perfect-scrollbar.css" />
        <link rel="stylesheet" type="text/css" href="/css/flot.css" />
        <link rel="stylesheet" type="text/css" href="/css/theme.css" />
        <link rel="stylesheet" type="text/css" href="/css/my_style.css" />

        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.11.1/dist/full.min.css" rel="stylesheet" type="text/css" />
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
            integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
        <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

        <script>
            function populateInputsFromJSON(jsonData) {
                const {
                    "Carte Grise Arriere": {
                        Marque,
                        Type,
                        Genre,
                        Modèle,
                        "Type Carburant": TypeCarburant,
                        "Numero du chassis": NumeroChassis,
                        "Nombre de cylindres": NombreCylindres,
                        "Puissance fiscale": PuissanceFiscale
                    },
                    "Carte Grise Avant": {
                        "Numero d'immatriculation": NumeroImmatriculation,
                        "Immatriculation antérieure": ImmatriculationAntérieure,
                        "Premier M.C": PremierMC,
                        "M.C au Maroc": MCauMaroc,
                        Usage,
                        Propriétaire,
                        Adresse,
                        "Fin de validité": FinValidité
                    }
                } = jsonData;

                // Populating inputs
                document.getElementById("numero").querySelector("input").value = NumeroImmatriculation;
                document.getElementById("immat").querySelector("input").value = ImmatriculationAntérieure;
                document.getElementById("premiere").querySelector("input").value = PremierMC;
                document.getElementById("mc").querySelector("input").value = MCauMaroc;
                document.getElementById("usage").querySelector("input").value = Usage;
                document.getElementById("proper").querySelector("input").value = Propriétaire;
                document.getElementById("address").querySelector("input").value = Adresse;
                document.getElementById("fin").querySelector("input").value = FinValidité;
                document.getElementById("marque").querySelector("input").value = Marque;
                document.getElementById("type").querySelector("input").value = Type;
                document.getElementById("genre").querySelector("input").value = Genre;
                document.getElementById("modele").querySelector("input").value = Modèle;
                document.getElementById("carburant").querySelector("input").value = TypeCarburant;
                document.getElementById("chassis").querySelector("input").value = NumeroChassis;
                document.getElementById("cylindre").querySelector("input").value = NombreCylindres;
                document.getElementById("fiscale").querySelector("input").value = PuissanceFiscale;
            }
        </script>

    </head>


</head>

<body>
    <div class="md:flex hidden bg-[#008080] w-52 h-screen justify-between flex-col fixed">
        <div class="flex flex-col gap-4 mt-8">
            <div class="bg-[#009999] h-fit">
                <img src="{{ asset('images/SygmaLogo.png') }}" class="px-2 py-2" alt="">
            </div>

            <div class="bg-[#009999] h-fit flex flex-col py-4 gap-4">
                <div class="flex items-center flex-col px-4">
                    <a class="w-full text-center text-white text-[1.1rem] bg-[#00B3B3] p-2 rounded-lg font-bold"
                        href="{{ route('dashboard') }}"><i class="fa-solid fa-chart-simple mr-2"></i>Dashboard</a>
                </div>

                <div class="flex items-center flex-col px-4">
                    <a class="w-full text-center text-white text-[1.1rem] bg-[#00B3B3] p-2 rounded-lg font-bold"
                        href="{{ route('dossiers') }}">
                        <i class="fas fa-folder-open mr-2"></i>Dossiers
                    </a>
                </div>

                <div class="flex items-center flex-col px-4">
                    <a class="w-full text-center text-white text-[1.1rem] bg-[#00B3B3] p-2 rounded-lg font-bold"
                        href="{{ route('etapes') }}">
                        <i class="fa-solid fa-newspaper mr-2"></i>Etapes
                    </a>
                </div>
                <div class="flex items-center flex-col px-4">
                    <a class="w-full text-center text-white text-[1.1rem] bg-[#00B3B3] p-2 rounded-lg font-bold"
                        href="{{route('marques.index')}}">
                        <i class="fas fa-file-lines mr-2"></i>Marques
                    </a>
                </div>
                <div class="flex items-center flex-col px-4">
                    <a class="w-full text-center text-white text-[1.1rem] bg-[#00B3B3] p-2 rounded-lg font-bold"
                        href="{{route('pieces.index')}}">
                        <i class="fas fa-gears mr-2"></i>Pieces
                    </a>
                </div>

            </div>
        </div>
        <div class="bg-[#009999] h-fit flex flex-col justify-center px-4 py-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-center text-white text-[1.1rem] p-2 bg-[#00B3B3] rounded-lg font-bold">
                    <i class="fa-solid fa-right-from-bracket mr-2"></i>{{ Auth::check() ? 'Se déconnecter' : 'Login' }}
                </button>
            </form>
        </div>
    </div>
    <div class="md:hidden block h-fit bg-[#008080]">
        <div class="w-full h-full flex items-center justify-center flex-col">
            <div class="flex flex-row w-full h-full justify-between items-center px-4">
                <img src="{{ asset('images/SygmaLogo.png') }}" class="w-fit pt-4 pb-1" alt="">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="bg-[#009999] h-fit w-fit px-2 py-1 rounded-full text-white text-2xl font-bold">
                        <i
                            class="fa-solid fa-right-from-bracket mr-2"></i>{{ Auth::check() ? 'Se déconnecter' : 'Login' }}
                    </button>
                </form>
            </div>
            <div class="flex flex-row pb-4 gap-2">
                <a class="bg-[#009999] px-2 py-1 rounded-full text-white text-2xl font-bold"
                    href="{{ route('dashboard') }}"><i class="fa-solid fa-chart-simple mr-2"></i>Dashboard</a>
                <a class="bg-[#009999] px-2 py-1 rounded-full text-white text-2xl font-bold" href="#"><i
                        class="fa-solid fa-newspaper mr-2"></i>Dossiers</a>
                <a class="bg-[#009999] px-2 py-1 rounded-full text-white text-2xl font-bold" href="#"><i
                        class="fa-solid fa-bell mr-2"></i>Etapes</a>
                <a class="bg-[#009999] px-2 py-1 rounded-full text-white text-2xl font-bold" href="#"><i
                        class="fa-solid fa-bell mr-2"></i>Marques</a>
                 <a class="bg-[#009999] px-2 py-1 rounded-full text-white text-2xl font-bold" href="#"><i
                        class="fa-solid fa-bell mr-2"></i>Pieces</a>        

            </div>
        </div>
    </div>
    <div class="pl-4 pt-4 flex  flex-col">
        {{ $slot }}
    </div>


</body>

</html>