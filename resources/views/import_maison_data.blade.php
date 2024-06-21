<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/docs.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <title>@yield('title',"Acceuil Admin")</title>
</head>
<body>
    <div class="container">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
            @if(Session::get('admin_page')==true)
                @if(Session::has('admin'))
                    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="{{route('defaut')}}" class="nav-link px-2 link-dark">Coucou <b>{{Session::get('admin')[0]->nom}}</b> 👋</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle link-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Etape
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{route('etape_points')}}">Etapes & points</a></li>
                                <li><a class="dropdown-item" href="{{route('coureur_liste')}}">Coureur</a></li>
                            </ul>
                        </li>
                        <li><a href="{{route('participation')}}" class="nav-link px-2 link-dark">Ajouter pénalite</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle link-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Classement
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{route('details_participation')}}">Classement général</a></li>
                                {{-- <li><a class="dropdown-item" href="{{route('classement_etape_equipe')}}">Classement d'équipe par étape</a></li> --}}
                                <li><hr class="dropdown-divider"></li>
                                {{-- <li><a class="dropdown-item" href="{{route('classement_etape_categorie')}}">Classement par étape pour chaque catégorie</a></li> --}}
                                <li><a class="dropdown-item" href="{{route('classement_etape_coureur')}}">Classement par étape pour chaque coureur</a></li>
                            </ul>
                        </li>
                        <li><a href="{{route('graphe')}}" class="nav-link px-2 link-dark">Graphe</a></li>
                        {{-- <li><a href="{{route('pdf')}}" class="nav-link px-2 link-dark">Pdf</a></li> --}}
                    </ul>
                    <div class="col-md-3 text-end">
                        <a href="{{route('logout')}}" class="btn btn-outline-primary me-2">Logout</a>
                    </div>
                @else
                    <div class="col-md-3 text-end">
                        <a href="{{route('login')}}" class="btn btn-outline-primary me-2">Login admin</a>
                    </div>
                @endif
            @endif
            @if(Session::get('client_page')==true)
                @if(Session::has('client'))
                    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="#" class="nav-link px-2 link-dark">Bienvenue <b>@yield('equipe')</b> 👋</a></li>
                        <li><a href="{{route('show_equipe')}}" class="nav-link px-2 link-dark">Acceuil</a></li>
                        <li><a href="{{route('equipe_participation')}}" class="nav-link px-2 link-dark">Participants</a></li>
                        <li><a href="{{route('classement_equipe')}}" class="nav-link px-2 link-dark">Mon classements</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle link-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Classement
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{route('details_participation')}}">Classement général</a></li>
                                <li><a class="dropdown-item" href="{{route('classement_etape_equipe')}}">Classement d'équipe par étape</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{route('classement_etape_categorie')}}">Classement par étape pour chaque catégorie</a></li>
                                <li><a class="dropdown-item" href="{{route('classement_etape_coureur')}}">Classement par étape pour chaque coureur</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="col-md-3 text-end">
                        <a href="{{route('logout_client')}}" class="btn btn-outline-primary me-2">Logout client</a>
                    </div>
                @else
                    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="{{route('defaut')}}" class="nav-link px-2 link-dark">Acceuil</a></li>
                        <li><a href="{{route('details_participation')}}" class="nav-link px-2 link-dark">Voir les participants</a></li>
                    </ul>
                    <div class="col-md-3 text-end">
                        <a href="{{route('login_client')}}" class="btn btn-outline-primary me-2">Login Client</a>
                    </div>
                @endif
            @endif
        </header>
        @if(Session::has('admin'))
            @yield("section")
            @yield("classement")
        @endif
        @if(Session::get('client_page')==true)
            @yield("contenu")
            @yield("classement")
        @endif

        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 d-flex align-items-center">
              <span class="text-muted">@2069</span>
            </div>
        </footer>
        <script src="{{ asset('dist/js/bootstrap.bundle.min.js') }}" ></script>


        <script src="https://cdn.jsdelivr.net/npm/docsearch.js@2/dist/cdn/docsearch.min.js"></script>

        <script src="{{asset('assets/js/docs.min.js')}}"></script>
    </div>
</body>
<script>
    function search() {
        var input = document.getElementById('searchInput');
        var filter = input.value.toUpperCase();
        var table = document.getElementById("travauxMaisonTable");
        var rows = table.getElementsByTagName("tr");
        for (var i = 0; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName('td');
            var found = false;
            for (var j = 0; j < cells.length; j++) {
                var cell = cells[j];
                if (cell) {
                    var textValue = cell.textContent || cell.innerText;
                    if (textValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }
            if (found) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
</script>

</html>
