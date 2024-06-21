<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/fontawesome.css')}}">
    <title>@yield('title',"Acceuil Admin")</title>
</head>
<body>
    <div class="container">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
            @if(Session::get('admin_page')==true)
                @if(Session::has('admin'))
                    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="{{route('defaut')}}" class="nav-link px-2 link-dark">Tableau de bord</a></li>
                        <li><a href="#" class="nav-link px-2 link-dark">Graphe</a></li>
                        <li><a href="{{route('choix')}}" class="nav-link px-2 link-dark">Client</a></li>
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
                        <li><a href="{{route('defaut')}}" class="nav-link px-2 link-dark">Acceuil</a></li>
                        <li><a href="#" class="nav-link px-2 link-dark">Paiement</a></li>
                        <li><a href="{{route('choix')}}" class="nav-link px-2 link-dark">Mon devis</a></li>
                    </ul>
                @else
                    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="{{route('defaut')}}" class="nav-link px-2 link-dark">Acceuil</a></li>
                    </ul>
                    <div class="col-md-3 text-end">
                        <a href="#" class="btn btn-outline-primary me-2">Login Client</a>
                    </div>
                @endif
            @endif
        </header>
        @if(Session::has('admin'))
            @yield("section")
        @endif
        @if(Session::get('client_page')==true)
            @yield("contenu")
        @endif
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 d-flex align-items-center">
              <span class="text-muted">@2069</span>
            </div>
          </footer>
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
